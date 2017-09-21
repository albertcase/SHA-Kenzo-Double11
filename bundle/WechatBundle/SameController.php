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
		$url = $request->query->get('rd');
		var_dump($openid);
		var_dump($url);exit;
		$this->statusPrint('error');
		// $this->redirect($url);

	}

}
