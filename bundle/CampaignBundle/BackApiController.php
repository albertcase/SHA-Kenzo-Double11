<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\Helper;
use Lib\PDO;
use Lib\UserAPI;
use Lib\WechatAPI;
use Lib\Redis;

class BackApiController extends Controller
{
    public function __construct() {
        parent::__construct();
        $this->_pdo = PDO::getInstance();
    }

    /**
     * 签到
     *
     * 1.记录日志
     * 2.注册用户,用户登陆.
     * 3.用户签到
     * 4.记录用户签到日志
     * 5.发送客服消息
     */
    public function checkinAction()
    {
        try {
            $postData = file_get_contents('php://input', 'r');
            $postArr = json_decode($postData, 1);

            // 验证API访问者IP
            $apiIp = $this->getClientIp();
            // if(!$this->checkIp($apiIp)){
            //     throw new \Exception('API IP is not allow');
            // }
            $openid = $postArr['FromUserName'];

            // 记录API原始数据日志
            $logdata = new \stdClass();
            $logdata->openid = $openid;
            $logdata->data = $postData;
            $lid = $this->insertCheckInLog($logdata);

            // 用户注册登陆
            $user = $this->initUser($openid);
            if(!$user) {
               throw new \Exception('init user is failed');
            }

            // 用户签到
            $checkin = new \stdClass();
            $checkin->uid = $user->uid;
            $date = $this->getDate();
            $checkin->did = (int) $date->id;

            if($this->findCheckIn($checkin)) {
                // 已经签到
                $this->sendMsg(2, $user, '');
            } else {
                if($this->checkIn($checkin)) {
                    // 签到成功
                    $this->sendMsg(1, $user, $date->media_id);
                } else {
                   throw new \Exception('checkin is failed');
                }
            }
        } catch (Exception $e) {
            //记录错误日志
            //返回错误的签到客服消息
            $msg = $e->getMessage();
            $errlog = new \stdClass();
            $errlog->lid = $lid;
            $errlog->msg = $msg;
            $this->chenkinFaileLog($errlog);
            // 签到失败
            $this->sendMsg(3, $user, '');
        }
        $data = array('status' => 1, 'msg' => 'checkin ok');
        $this->dataPrint($data);
    }

    /**
     * 消息组
     */
    private function sendMsg($status, $user, $media_id)
    {
        $accessToken = $this->getAccessTokenByWechat();
        $chekinSum = $this->getCheckinSum($user->uid);

        // 累计签到25天推送另外的信息
        // 优先级 1>2>3>4
        // 1.已经领取，已经填写信息 status=4
        // 2.已经领取，未填写信息 status=5
        // 3.有库存,未领取 status=6
        // 4.无库存 status=7
        if((int) $chekinSum >= 25) {

            if($this->findGiftByUid($user->uid)) {
                if($this->findGiftInfoByUid($user->uid)){ //1.已经领取，已经填写信息
                    $status = 4;
                } else { //2.已经领取，未填写信息
                    $status = 5;
                }
            } else {
                if($this->checkGiftSum()) { //3.有库存,未领取
                    $status = 6;
                } else { //4.无库存
                    $status = 7;
                }
            }
        }

        switch ($status) {
            case 1:
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = '签到成功！' . $user->nickname . '您已经签到' . $chekinSum . '天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 2:
                $content = '您已经签到！' . $user->nickname . '您已经签到' . $chekinSum . '天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 3:
                $content = '当前签到人过多！请稍后再来！' . $user->nickname . '您已经签到' . $chekinSum . '天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 4:
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = '已经领取小样，已经填写信息！' . $user->nickname . '您已经签到' . $chekinSum . '天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 5:
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = '已经领取小样，未填写信息！' . $user->nickname . '您已经签到' . $chekinSum . '天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 6:
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = "<a href='http://kenzodouble11.samesamechina.com/freetrial'>点击</a>填写信息信息领取礼品！" . $user->nickname . '您已经签到' . $chekinSum . '天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 7:
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = '小样库存已没！您可以继续签到！签到次数越多抽奖机会越多！' . $user->nickname . '您已经签到' . $chekinSum . '天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;
        }
    }

    /**
     * 查看是否领取小样的个人数据填写过
     */
    private function findGiftInfoByUid($uid)
    {
        $sql = "SELECT `uid`, `name`, `tel`, `province`, `city`, `address` FROM `gift_info` WHERE `uid` = :uid";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $uid));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        }
        return NULL;
    }

    private function checkGiftSum()
    {
        $sql = "select count(id) AS sum from gift";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if((int) $row['sum'] <= GIFT_NUM) {
            return true;
        } else {
            return false;
        }
    }

    private function findGiftByUid($uid)
    {
        $sql = "SELECT `id`, `uid` FROM `gift` WHERE `uid` = :uid";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $uid));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        }
        return NULL;
    }

    private function setGift($uid)
    {
        $helper = new Helper();
        $gift = new \stdClass();
        $gift->uid = $uid;
        $gift->created = date('Y-m-d H:i:s');
        $id = $helper->insertTable('gift', $gift);
        if($id) {
            return true;
        }
        return false;
    }

    private function getCheckinSum($uid)
    {
        $sql = "select count(d.date) AS sum from date d left join checkin c on d.id = c.did and uid =" . $uid ." where d.date <='" . SIGN_DATE . "' and c.uid is not null";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return $row['sum'];
    }

    /**
     * 签到错误日志
     */
    private function chenkinFaileLog($log)
    {
        $helper = new Helper();
        $log->created = date('Y-m-d H:i:s');
        $log = (array) $log;
        $id = $helper->insertTable('checkerr_log', $log);
        if($id) {
            return true;
        }
        return false;
    }

    /**
     * 发送客服消息
     */
    private function sendCustomMsg($accessToken, $openid, $msgType, $content)
    {
        if($msgType == 'image') {
            $data = array(
                'touser' => $openid,
                'msgtype' => $msgType,
                'image' => $content,
            );
        }
        if($msgType == 'text') {
            $data = array(
                'touser' => $openid,
                'msgtype' => $msgType,
                'text' => $content,
            );
        }
        $rs = $this->sendCustomMsgTowechat($accessToken, $data);
        // 记录消息日志
        $msglog = new \stdClass();
        $msglog->openid = $openid;
        $msglog->data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $msglog->errcode = $rs->errcode;
        $msglog->errmsg = $rs->errmsg;
        $this->insertMsgLog($msglog);
    }

    private function insertMsgLog($log)
    {
        $helper = new Helper();
        $log->created = date('Y-m-d H:i:s');
        $log = (array) $log;
        $id = $helper->insertTable('msg_log', $log);
        if($id) {
            return $id;
        }
        return false;
    }

    /**
     * 发送微信客服消息
     */
    public function sendCustomMsgTowechat($accessToken, $data) {
        $applink = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=%s";
        $url = sprintf($applink, $accessToken);
        $rs = $this->postData($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $rs;
    }

    /**
     * post data
     */
    private function postData($url, $post_json) {
        // post data to wechat
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }

    /**
     * 查看是都已经签到过
     */
    private function findCheckIn($checkin)
    {
        $sql = "SELECT `id` FROM `checkin` WHERE `uid` = :uid AND `did` = :did";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $checkin->uid, ':did' => $checkin->did));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        }
        return NULL;
    }

    /**
     * 获取今天的日期ID
     */
    private function getDate()
    {
        $sql = "SELECT `id`, `media_id` FROM `date` WHERE `date` = :date";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':date' => SIGN_DATE));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        }
    }

    /**
     * 通过openid注册登陆
     */
    private function initUser($openid)
    {
        $user = $this->userLoad($openid);
        if(!$user) {
            $user_info = new \stdClass();
            $user_info->openid = $openid;
            $user = $this->userRegister($user_info);
        }
        return $user;
    }

    /**
     * 新增用户
     */
    private function userRegister($userInfo)
    {
        $accessToken = $this->getAccessTokenByWechat();
        $info = $this->getUserInfoByWechat($accessToken, $userInfo->openid);
        $helper = new Helper();
        $userInfo->created = date('Y-m-d H:i:s');
        if($info->errcode == 0) {
            $userInfo->nickname = $info->nickname;
            $userInfo->sex = $info->sex;
            $userInfo->province = $info->province;
            $userInfo->country = $info->country;
            $userInfo->city = $info->city;
            $userInfo->headimgurl = $info->headimgurl;
        }
        $userInfo = (array) $userInfo;
        $id = $helper->insertTable('user', $userInfo);
        if($id) {
            $user = $this->findUserById($id);
            return $user;
        }
        return false;
    }

    /**
     * 验证用户
     */
    private function userLoad($openid)
    {
        $sql = "SELECT `uid`, `openid`, `nickname` FROM `user` WHERE `openid` = :openid";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':openid' => $openid));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        } else {
            return false;
        }
    }

    private function findUserById($uid)
    {
        $sql = "SELECT `uid`, `openid`, `nickname` FROM `user` WHERE `uid` = :uid";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $uid));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        } else {
            return false;
        }
    }

    /**
     * 获取微信的TOKEN
     */
    private function checkIp($ip)
    {
        if($ip == API_IP) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 获取微信的TOKEN
     */
    private function getAccessTokenByWechat()
    {
        $apiUrl = 'http://kenzowechat.samesamechina.com/Weixin/Getaccesstoken';
        return file_get_contents($apiUrl);
    }

    /**
     * 获取用户的详细信息
     */
    private function getUserInfoByWechat($accessToken, $openid)
    {
        $applink = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";
        $url = sprintf($applink, $accessToken, $openid);
        $return = file_get_contents($url);
        return json_decode($return);
    }

    /**
     * 用户签到
     */
    private function checkIn($checkin)
    {
        $helper = new Helper();
        $checkin->created = date('Y-m-d H:i:s');
        $checkin = (array) $checkin;
        $id = $helper->insertTable('checkin', $checkin);
        if($id) {
            return $id;
        }
        return false;
    }

    /**
     * 签到日志记录（API原始记录）
     */
    private function insertCheckInLog($checkinlog)
    {
        $helper = new Helper();
        $checkinlog->created = date('Y-m-d H:i:s');
        $checkinlog = (array) $checkinlog;
        $id = $helper->insertTable('checkin_log', $checkinlog);
        if($id) {
            return $id;
        }
        return false;
    }

    /**
     * 获取API来源IP
     */
    private function getClientIp()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
            $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_X_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
            $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if(isset($_SERVER['HTTP_FORWARDED']))
            $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if(isset($_SERVER['REMOTE_ADDR']))
            $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
}
