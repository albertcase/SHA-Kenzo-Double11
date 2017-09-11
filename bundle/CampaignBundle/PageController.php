<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\Helper;
use Lib\PDO;
use Lib\UserAPI;
use Lib\WechatAPI;

class PageController extends Controller
{

    public function __construct()
    {
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
    public function signAction()
    {
        $postData = file_get_contents('php://input', 'r');
        $postArr = json_decode($postData, 1);
        $ip = $_SERVER['REMOTE_ADDR'];

        // 记录API原始数据日志
        $logdata = new \stdClass();
        $logdata->openid = $postArr['FromUserName'];
        $logdata->data = $postData;
        $this->insertSignLog($logdata);

        // 用户注册登陆
        $user = $this->initUser($postArr['FromUserName']);

        // 用户签到
        $usersign = new \stdClass();
        $usersign->uid = $user->uid;
        $date = $this->getDid();
        $usersign->did = $date->id;

        //发送图片信息
        $accessToken = $postArr['_tk'];
        $this->sendCustomMsg($accessToken, $postArr['FromUserName'], 'image', array('media_id' => '1232312'));
        if($this->findSign($usersign)) {
            $this->sendCustomMsg($accessToken, $postArr['FromUserName'], 'text', array('content' => '您已经签到过！'));
        }
        if($this->UserSign($usersign)) {
            $this->sendCustomMsg($accessToken, $postArr['FromUserName'], 'text', array('content' => '签到成功！'));
        }
        exit;
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
    private function findSign($sign)
    {
        $sql = "SELECT `id` FROM `sign` WHERE `uid` = :uid AND `did` = :did";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $sign->uid, ':did' => $sign->did));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return  (Object) $row;
        }
        return NULL;
    }

    /**
     * 获取今天的日期ID
     */
    private function getDid()
    {
        $sql = "SELECT `id` FROM `date` WHERE `date` = :date";
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
        global $user;
        $UserAPI = new UserAPI();
        $user = $UserAPI->userLoad();
        if(!$user->uid) {
            $user_info = new \stdClass();
            $user_info->openid = $openid;
            $user = $UserAPI->userRegister($user_info);
        }
        return $user;
    }

    /**
     * 用户签到
     */
    private function UserSign($usersign)
    {
        $helper = new Helper();
        $usersign->created = date('Y-m-d H:i:s');
        $usersign = (array) $usersign;
        $id = $helper->insertTable('sign', $usersign);
        if($id) {
            return true;
        }
        return false;
    }

    /**
     * 签到日志记录（API原始记录）
     */
    private function insertSignLog($signlog)
    {
        $helper = new Helper();
        $signlog->created = date('Y-m-d H:i:s');
        $signlog = (array) $signlog;
        $id = $helper->insertTable('sign_log', $signlog);
        if($id) {
            return true;
        }
        return false;
    }



	public function indexAction()
    {
		global $user;
		var_dump($user);exit;
		$RedisAPI = new \Lib\RedisAPI();
		$config = $RedisAPI->jssdkConfig($this->request->getUrl(TRUE));
		return $this->render('index', array('config' => $config));
	}

	public function clearCookieAction()
    {
      	$request = $this->Request();
		setcookie('_user', '', time(), '/', $request->getDomain());
		$this->statusPrint('success');
	}

}