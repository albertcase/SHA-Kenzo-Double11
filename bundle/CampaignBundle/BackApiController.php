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
     * 模版消息推送结果通知
     */
    public function tmpendAction()
    {
        $postData = file_get_contents('php://input', 'r');
        $postArr = json_decode($postData, 1);
        $log = new \stdClass();
        $log->wechat_msgid = $postArr['MsgID'];
        $log->wechat_status = $postArr['Status'];
        $log->wechat_ftime = date('Y-m-d H:i:s');
        $this->updateTmpWechatStatus($log);
        $data = array('status' => 1, 'msg' => 'tmp update status ok');
        $this->dataPrint($data);
    }

    private function updateTmpWechatStatus($log)
    {
        $helper = new Helper();
        $condition = array(
            array('wechat_msgid', $log->wechat_msgid, '='),
        );
        return $helper->updateTable('tmp_log', $log, $condition);
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

        $isGift = $this->findGiftByUid($user->uid); //是否领取小样
        $isGiftInfo = $this->findGiftInfoByUid($user->uid); //是否填写信息
        $isGuftNum = $this->checkGiftSum(); //是否有库存

        // 活动最后一天签到回复
        // 1.未签满25天 status=8
        // 2.签满25天并且领过小样并且填写过信息 status=9
        // 3.签到大于25天并且没有没有领过小样也没有填写过信息 status=10
        // 4.签满25天未获得小样 status=11
        // 5.签到大于25天领取过小样但是没有填写过信息 status=12
        // 6.签满25天获得小样 status=13
        if(SIGN_DATE == '2017-11-10' && $status != 2) {

            //签满小于25天
            if($chekinSum < 25) {
                $user->num = (int) $isGift->id;
                $status = 8;
            }

            //签满大于25天 领取小样 填写信息
            if($chekinSum > 25 && $isGiftInfo && $isGift) {
                $user->num = (int) $isGift->id;
                $status = 9;
            }

            //签满大于25天 未领取小样 未填写信息
            if($chekinSum > 25 && !$isGift) {
                $user->num = (int) $isGift->id;
                $status = 10;
            }

            //刚好签满25天， 无小样库存
            if($chekinSum == 25) {
                if($isGuftNum) {
                    if(!$isGift) {
                        $user->num = $this->setGift($user->uid, 1);
                    }
                    $status = 13;
                } else {
                    if(!$isGift) {
                        $user->num = $this->setGift($user->uid, 2);
                    }
                    $status = 11;
                }   
            }

            //签到大于25天，领取过小样，没有填写过信息
            if($chekinSum > 25 && !$isGiftInfo && $isGift) {
                $user->num = (int) $isGift->id;
                $status = 12;
            }

        } else {
            // 累计签到25天推送另外的信息
            // 优先级 1>2>3>4
            // 1.已经领取，已经填写信息 status=4
            // 2.已经领取，未填写信息 status=5
            // 3.有库存,未领取 status=6
            // 4.无库存 status=7
            if((int) $chekinSum >= 25 && $status != 2) {
                // 有库存
                if($isGuftNum) {
                    if($isGift) {
                        // 已经领小样，已经填写信息
                        if($isGiftInfo) {
                            $status = 4;
                        } else {
                            if((int) $chekinSum > 25) {
                                $user->num = (int) $isGift->id;
                                if(!$isGiftInfo) { //有库存 已经领取小样 未填写信息
                                    $status = 5;
                                }
                            }
                        }
                    } else {
                        if($chekinSum == 25) { //第一次满足25天
                            $status = 6;
                        }
                        $user->num = $this->setGift($user->uid, 1);
                    }   
                } 

                // 没库存
                if(!$isGuftNum) {
                    if($isGift) {
                        $user->num = (int) $isGift->id;
                        if(!$isGiftInfo) { //没库存领过小样未填写信息
                            $status = 5;
                        }
                    } else {
                        $user->num = $this->setGift($user->uid, 2);
                    }
                    if((int) $chekinSum == 25) { //在第25天没库存只提醒一次
                        $status = 7;
                    }
                }
            }
        }

        switch ($status) {
            case 1: //签到成功
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . '，这是你签到的第' . $chekinSum . '天。愿今天也是美丽的一天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 2: //重复签到
                $content = 'Hi ' . $user->nickname . ' 小迷糊，你今天已经签到过啦，记得明天再来哦！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 3: //签到失败
                $content = 'Hi ' . $user->nickname . '，刚刚网络开小差了，没能成功签到，请再试一次吧！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 4: //已经领取小样，已经填写信息。
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . '，这是你签到的第' . $chekinSum . '天。愿今天也是美丽的一天！';                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 5: //已经领取小样，未填写信息。
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . '这是你签到的第' . $chekinSum . '天！别忘了' . "<a href='http://kenzodouble11.samesamechina.com/freetrial'>点击</a>" . '填写表单，领取全新花颜舒柔系列产品哦~愿今天也是美丽的一天！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 6: //未领取小样，未填写信息。（第一次领取）
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . '，恭喜你以第' . $user->num . '名完成签到25天、获得花颜礼盒一份！' . "<a href='http://kenzodouble11.samesamechina.com/freetrial'>点击</a>" . '填写表单，抢先试用全新花颜舒柔系列产品。继续保持签到，你的签到天数对应最终「花颜舒柔夜间修护面膜正装（75ML）」的抽奖次数哦，11月11号开启抽奖！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 7: //小样领取库存无，
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . '，你已成功签到25天，在小伙伴中排名第' . $user->num . '，很遗憾' . GIFT_NUM . '套花颜礼盒已被全部申领完毕！别灰心，请继续坚持，你的签到天数对应最终「花颜舒柔夜间修护面膜正装（75ML）」的抽奖次数哦，11月11号开启抽奖！';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 8: //2017-11-10 未签满25天
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . ' , 今天是你签到的第' . $chekinSum . '天。你的签到天数对应「花颜舒柔夜间修护面膜正装（75ML）」的抽奖次数哦，明天开启抽奖，不见不散~';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 9: //2017-11-10 签满大于25天 并且领取过小样，填写过信息
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . ' , 今天是你签到的第' . $chekinSum . '天。你的签到天数对应「花颜舒柔夜间修护面膜正装（75ML）」的抽奖次数哦，明天开启抽奖，不见不散~';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 10: //2017-11-10 签满大于25天 并且领取过小样，填写过信息
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . ' , 今天是你签到的第' . $chekinSum . '天。你的签到天数对应「花颜舒柔夜间修护面膜正装（75ML）」的抽奖次数哦，明天开启抽奖，不见不散~';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 11: //2017-11-10 签满刚好25天 并且无库存
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
            $content = 'Hi ' . $user->nickname . ' ，你已成功签到25天，在小伙伴中排名第' . $user->num . '，很遗憾' . GIFT_NUM . '套花颜礼盒已被全部申领完毕！别灰心，你获得25次抽取「花颜舒柔夜间修护面膜正装（75ML）」的机会，明天开启抽奖，不见不散~';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 12: //2017-11-10 
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . ' ，这是你签到的第' . $chekinSum . '天！别忘了' . "<a href='http://kenzodouble11.samesamechina.com/freetrial'>点击</a>" . '填写表单，领取花颜礼盒哦。你的签到天数对应「花颜舒柔夜间修护面膜正装（75ML）」的抽奖次数哦，明天开启抽奖，不见不散~';
                $this->sendCustomMsg($accessToken, $user->openid, 'text', array('content' => $content));
                break;

            case 13: //2017-11-10 刚好签满25天，并且小样有库存，
                $this->sendCustomMsg($accessToken, $user->openid, 'image', array('media_id' => $media_id));
                $content = 'Hi ' . $user->nickname . ' 恭喜你以第' . $user->num . '名完成签到25天、获得花颜礼盒一份！' . "<a href='http://kenzodouble11.samesamechina.com/freetrial'>点击</a>" . '填写表单，抢先试用全新花颜舒柔系列产品。你的签到天数将对应「花颜舒柔夜间修护面膜正装（75ML）」的抽奖次数哦，明天开启抽奖，不见不散~';
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
        $sql = "select count(id) AS sum from gift WHERE status = 1 ";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if((int) $row['sum'] < GIFT_NUM) {
            return true;
        } else {
            return false;
        }
    }

    private function findGiftByUid($uid)
    {
        $sql = "SELECT `id`, `uid` FROM `gift` WHERE status =1 AND `uid` = :uid";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $uid));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        }
        return NULL;
    }

    private function setGift($uid, $status)
    {
        $helper = new Helper();
        $gift = new \stdClass();
        $gift->uid = $uid;
        $gift->status = $status;
        $gift->created = date('Y-m-d H:i:s');
        $id = $helper->insertTable('gift', $gift);
        if($id) {
            return $id;
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
        $msglog->data = json_encode($data);
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

    private function getdata($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
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
        //普通版本
        // $apiUrl = 'http://120.132.102.63/Weixin/Getaccesstoken';
        // $accessToken = $this->getData($apiUrl);
        // return $accessToken;

        //AccessToken本地缓存
        $RedisAPI = new Redis();
        if($RedisAPI->get('AccessToken')) {
            return $RedisAPI->get('AccessToken');
        } else {
            $apiUrl = 'http://120.132.102.63/Weixin/Getaccesstoken';
            $accessToken = $this->getData($apiUrl);
            $RedisAPI->set('AccessToken', $accessToken);
            $RedisAPI->setTimeout('AccessToken', time() + 120);
            return $accessToken;
        }
    }

    /**
     * 获取用户的详细信息
     */
    private function getUserInfoByWechat($accessToken, $openid)
    {
        $applink = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";
        $url = sprintf($applink, $accessToken, $openid);
        $return = $this->getData($url);
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
