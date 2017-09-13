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

    public function freetrialAction()
    {
        $config = array();
        return $this->render('freetrial', array('config' => $config));
    }

    public function luckydrawAction()
    {
        $config = array();
        return $this->render('luckydraw', array('config' => $config));
    }

}