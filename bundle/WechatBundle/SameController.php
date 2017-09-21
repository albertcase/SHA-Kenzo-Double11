<?php

namespace WechatBundle;

use Core\Controller;
use Lib\UserAPI;

class SameController extends Controller
{
	public function callbackAction()
	{
		$request = $this->request;
		$fields = array(
			'openid' => array('notnull', '120'),
			'rd' => array('notnull', '120')
		);
		$request->validation($fields);
		$openid = $request->query->get('openid');
		$url = urldecode($request->query->get('rd'));
		$userAPI = new UserAPI();
		$user = $userAPI->userLogin($openid);
		if(!$user) {
			// $this->statusPrint('error');
			$user = new new \stdClass();
			$user->openid = $openid;
			$userAPI->userRegister($openid);
		}
		$this->redirect($url);
		$this->statusPrint('error');
	}

}
