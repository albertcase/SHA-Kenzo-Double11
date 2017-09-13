<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\Helper;
use Lib\PDO;
use Lib\UserAPI;
use Lib\WechatAPI;
use \Lib\Redis;
use Masterminds\HTML5\Exception;

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
            $apiIp = $this->get_client_ip();
//            if(!$this->checkIp($apiIp)){
//                throw new Exception('API IP is not allow');
//            }

            // 记录API原始数据日志
            $logdata = new \stdClass();
            $logdata->openid = $postArr['FromUserName'];
            $logdata->data = $postData;
            $this->insertCheckInLog($logdata);

            // 用户注册登陆
            $user = $this->initUser($postArr['FromUserName']);

            // 用户签到
            $checkin = new \stdClass();
            $checkin->uid = $user->uid;
            $date = $this->getDate();
            $checkin->did = $date->id;

            //发送图片信息
            $accessToken = $postArr['_tk'];
            $this->sendCustomMsg($accessToken, $postArr['FromUserName'], 'image', array('media_id' => $date->media_id));
            if($this->findCheckIn($checkin)) {
                $this->sendCustomMsg($accessToken, $postArr['FromUserName'], 'text', array('content' => '您已经签到过！'));
            } else {
                if($this->checkIn($checkin)) {
                    $this->sendCustomMsg($accessToken, $postArr['FromUserName'], 'text', array('content' => '签到成功！'));
                }
            }
        } catch (Exception $e) {
            //记录错误日志
            //返回错误的签到客服消息
            $msg = $e->getMessage();
            $this->chenkinlog();
//            var_dump($msg);exit;
            $this->sendCustomMsg($accessToken, $postArr['FromUserName'], 'text', array('content' => '当前签到人过多！请稍后再来！'));
        }
    }

    /**
     * 发送客服消息
     */
    private function sendCustomMsg($accessToken, $openid, $msgType, $content)
    {
        $wechat = new WechatAPI();
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
        $wechat->sendTmpMsg($accessToken, $data);
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
        if(!$user->uid) {
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
        $helper = new Helper();
        $userInfo->created = date('Y-m-d H:i:s');
        $userInfo = (array) $userInfo;
        $id = $helper->insertTable('user', $userInfo);
        if($id) {
            return true;
        }
        return false;
    }

    /**
     * 验证用户
     */
    private function userLoad($openid)
    {
        $sql = "SELECT `id`, `openid`, `nickname` FROM `user` WHERE `openid` = :openid";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':openid' => $openid));
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

    }

    /**
     * 获取用户的详细信息
     */
    private function getUserInfoByWechat()
    {

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
            return true;
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
            return true;
        }
        return false;
    }

    /**
     * 获取API来源IP
     */
    private function get_client_ip()
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
