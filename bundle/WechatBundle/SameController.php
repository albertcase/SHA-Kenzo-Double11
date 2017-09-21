<?php

namespace WechatBundle;

use Core\Controller;
use Lib\UserAPI;

class SameController extends Controller
{
	public function callbackAction()
	{
		$request = $this->request;
		$url = $request->getSourcetUrl();
		$fields = array(
			'openid' => array('notnull', '120'),
		);
		$request->validation($fields);
		$openid = $request->query->get('openid');
		var_dump($openid);
		var_dump($url);exit;
		$this->statusPrint('error');
		// $this->redirect($url);

	}

}
