<?php

namespace WechatBundle;

use Core\Controller;
use Lib\UserAPI;

class SameController extends Controller
{
	public function callbackAction()
	{
		$openid = $_GET['openid'];
		$res = $_GET['rediret'];
		var_dump($openid);
		var_dump($res);exit;
		$this->statusPrint('error');
		// $this->redirect($url);

	}

}
