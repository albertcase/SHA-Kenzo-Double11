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
        $this->_pdo = PDO::getInstance();
    }

    public function testAction()
    {
      echo 'test';exit;
    }

    /**
     * 填写的信息
     */
    public function lotteryinfoAction()
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
      if($this->findLotteryInfoByUid($user->uid)) {
          $this->statusPrint('2', '您已经填写过信息！');
      }
  		$data = new \stdClass();
  		$data->uid = $user->uid;
  		$data->name = $request->request->get('name');
  		$data->tel = $request->request->get('tel');
  		$data->province = $request->request->get('province');
      $data->city = $request->request->get('city');
      $data->address = $request->request->get('address');

  		if($this->insertLotteryInfo($data)) {
        $this->statusPrint('1', '信息填写成功！');
      } else {
        $this->statusPrint('0', '信息填写失败！');
  		}
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
      if($this->findGiftInfoByUid($user->uid)) {
          $this->statusPrint('2', '您已经填写过信息！');
      }
  		$data = new \stdClass();
  		$data->uid = $user->uid;
  		$data->name = $request->request->get('name');
  		$data->tel = $request->request->get('tel');
  		$data->province = $request->request->get('province');
      $data->city = $request->request->get('city');
      $data->address = $request->request->get('address');

  		if($this->insertGiftInfo($data)) {
  			$this->statusPrint('1', '信息填写成功！');
  		} else {
  			$this->statusPrint('0', '信息填写失败！');
  		}
    }

    /**
     * 发送客服消息
     */
    private function sendCustomMsg($accessToken, $msgType, $content)
    {

    }

    /**
     * 发送模版消息
     */
    private function sendTmpMsg($accessToken, $content)
    {

    }

    /**
    * Create gift_info in database
    */
    public function insertGiftInfo($giftinfo) {
      $helper = new Helper();
      $giftinfo->created = date('Y-m-d H:i:s');
      $giftinfo = (array) $giftinfo;
      $id = $helper->insertTable('gift_info', $giftinfo);
      if($id) {
        return true;
      }
      return false;
    }

    /**
    * Create lottery_info in database
    */
    public function insertLotteryInfo($lotteryinfo) {
      $helper = new Helper();
      $lotteryinfo->created = date('Y-m-d H:i:s');
      $lotteryinfo = (array)$lotteryinfo;
      $id = $helper->insertTable('lottery_info', $lotteryinfo);
      if($id) {
        return true;
      }
      return false;
    }

    /**
     * Find gift_info in database
     */
    public function findGiftInfoByUid($uid){
      $sql = "SELECT `uid`, `name`, `tel`, `province`, `city`, `address` FROM `gift_info` WHERE `uid` = :uid";
      $query = $this->_pdo->prepare($sql);
      $query->execute(array(':uid' => $uid));
      $row = $query->fetch(\PDO::FETCH_ASSOC);
      if($row) {
        return  (Object) $row;
      }
      return NULL;
    }

    /**
     * Find lottery_info in database
     */
    public function findLotteryInfoByUid($uid){
      $sql = "SELECT `uid`, `name`, `tel`, `province`, `city`, `address` FROM `lottery_info` WHERE `uid` = :uid";
      $query = $this->_pdo->prepare($sql);
      $query->execute(array(':uid' => $uid));
      $row = $query->fetch(\PDO::FETCH_ASSOC);
      if($row) {
        return  (Object) $row;
      }
      return NULL;
    }

}
