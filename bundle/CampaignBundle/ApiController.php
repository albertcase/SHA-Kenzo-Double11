<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\Helper;
use Lib\PDO;
use Lib\UserAPI;
use Lib\WechatAPI;

class ApiController extends Controller
{
    public function __construct() {

    	global $user;

        parent::__construct();

        if(!$user->uid) {
	        $this->statusPrint('100', 'access deny!');
        }
    }

    public function testAction()
    {
        echo 'test';exit;
    }

    /**
     * 领取礼品填写的信息
     */
    public function giftinfoAction()
    {

    	global $user;

    	$request = $this->request;
    	$fields = array(
  			'name' => array('notnull', '120'),
  			'tel' => array('cellphone', '121'),
        'province' => array('notnull', '121'),
        'city' => array('notnull', '121'),
  			'address' => array('notnull', '122'),
		);
  		$request->validation($fields);
  		$helper = new ();
  		$data = new \stdClass();
  		$data->uid = $user->uid;
  		$data->name = $request->request->get('name');
  		$data->cellphone = $request->request->get('cellphone');
  		$data->address = $request->request->get('address');

  		if($DatabaseAPI->insertInfo($data)) {
  			$data = array('status' => 1);
  			$this->dataPrint($data);
  		} else {
  			$this->statusPrint('0', 'failed');
  		}
    }

    /**
     * 发送客服消息
     */
    private function sendCustomMsg($accessToken, $msgType, $content)
    {

    }


}
