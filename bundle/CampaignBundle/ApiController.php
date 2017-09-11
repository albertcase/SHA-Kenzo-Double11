<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\Helper;
use Lib\PDO;
use Lib\UserAPI;
use Lib\WechatAPI;
use \Lib\Redis;

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
        global $user;
        var_dump($user);
        echo 'test';exit;
    }

    /**
     * 抽奖
     */
    public function lotteryAction()
    {
    	global $user;
      if(!$this->checkQuotaTime()) {
        $data = array('status' => 5, 'msg'=> '活动未开始，！', 'userStatus' => $user->status);
        $this->dataPrint($data);
      }
    	$databaseAPI = new \Lib\DatabaseAPI();
    	$date = date('Y-m-d');
    	//已中奖
    	$lottery = $databaseAPI->loadLotteryByUid($user->uid);
  	  if($lottery) {
  			$databaseAPI->setLottery($user->uid, 2);
        $data = array('status' => 3, 'msg'=> '您已获奖', 'userStatus' => $user->status);
  			$this->dataPrint($data);
		  }
		  //奖发完
      $sum = $databaseAPI->checkGiftQuota($date, 2);
  		$count = $databaseAPI->loadLotteryCount($date . '%');
  		if ($count>=$sum) {
        $data = array('status' => 2, 'msg'=> '今天的奖品已经发没，请明天再来！', 'userStatus' => $user->status);
  			$this->dataPrint($data);
  		}
  		//中奖率
      $rands = explode('/', PROBABILITY);
  		$rand = mt_rand(1, $rands['1']);
  		if ($rand <= $rands['0']) {
  			$databaseAPI->setLottery($user->uid, 1);
        $user->status['isluckydraw'] = 1;
        $data = array('status' => 1, 'msg'=> '恭喜中奖', 'userStatus' => $user->status);
  			$this->dataPrint($data);
  		}
  		$databaseAPI->setLottery($user->uid, 2);
      $data = array('status' => 0, 'msg'=> '遗憾未中奖', 'userStatus' => $user->status);
  		$this->dataPrint($data);
    }

    /**
     * 发送短信验证码
     */
    public function phoneCodeAction()
    {
      $request = $this->request;
      $fields = array(
          'mobile' => array('cellphone', '121'),
      );
      $request->validation($fields);

      $ch = curl_init();
      $apikey = "b42c77ce5a2296dcc0199552012a4bd9";
      $mobile = $request->request->get('mobile');
      $code = rand(1000, 9999);
      $RedisAPI = new \Lib\RedisAPI();
      $RedisAPI->setPhoneCode($mobile, $code, '3600');
      $text = "【Kenzo凯卓】您的验证码是{$code}";
      $data = array('text'=>$text,'apikey'=>$apikey,'mobile'=>$mobile);
      curl_setopt ($ch, CURLOPT_URL, 'https://sms.yunpian.com/v2/sms/single_send.json');
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      $json_data = curl_exec($ch);
      $array = json_decode($json_data,true);
      $data = array('status' => 1, 'msg' => 'send ok');
      $this->dataPrint($data);
    }

    /**
     * 验证短信验证码
     */
    public function checkPhoneCodeAction()
    {
      $request = $this->request;
      $fields = array(
          'phonecode' => array('notnull', '120'),
      );
      $request->validation($fields);
      $phoneCode = $request->request->get('phonecode');
      if(strtolower($phoneCode) == strtolower($_SESSION['phone-code'])) {
          $data = array('status' => 1, 'msg' => 'success');
      } else {
          $data = array('status' => 0, 'msg' => 'phone code is failed');
      }
      $this->dataPrint($data);
    }

    /**
     *  判断手机验证码是否正确
     */
    private function checkMsgCode($mobile, $msgCode) {
      $RedisAPI = new Redis();
      $code = $RedisAPI->get($mobile);
      if($code == $msgCode) {
          return true;
      } else {
          return false;
      }
    }

    /**
     * 验证验证码是否正确
     */
    public function checkPictureAction()
    {
      $request = $this->request;
      $fields = array(
      'picture' => array('notnull', '120'),
      );
      $request->validation($fields);
      $picture = $request->request->get('picture');
      if(strtolower($picture) == strtolower($_SESSION['captcha-protection'])) {
              $data = array('status' => 1, 'msg' => 'success');
      } else {
          unset($_SESSION['captcha-protection']);
              $data = array('status' => 0, 'msg' => 'picture code is failed');
      }
      $this->dataPrint($data);
    }

    /**
     * 获取图片验证码
     */
    public function pictureCodeAction()
    {
      $captcha = new \Lib\Captcher(150, 65);
      $captchaImage = $captcha->generate();
      $captchaText = $captcha->getCaptchaText();
      $_SESSION['captcha-protection'] = $captchaText;
      $picture = base64_encode($captchaImage);
      $data = array('status' => 1, 'picture' => $picture);
      $this->dataPrint($data);
    }

    /**
     * 领礼品
     */
    public function giftAction()
    {
      global $user;
      $DatabaseAPI = new \Lib\DatabaseAPI();
      if(!$this->checkQuotaTime()) {
          $data = array('status' => 5, 'msg'=> '今日活动还未开启，请稍后！', 'userStatus' => $user->status);
          $this->dataPrint($data);
      }
      $checknew = $DatabaseAPI->checkOpenid($user->openid);
      if (!$checknew) {
          $date = date('Y-m-d');
          //新用户申领
          //今天的小样领取完毕
          //已经领取过小样
          if($DatabaseAPI->checkGift($user->uid)) {
              $data = array('status' => 4, 'msg'=> '对不起，您已经领取过小样！', 'userStatus' => $user->status);
              $this->dataPrint($data);
          }
          $sum = $DatabaseAPI->checkGiftQuota($date, 1);
          $count = $DatabaseAPI->loadGiftCount($date . '%');
          if($count>=$sum) {
              //小样全部领取完毕
              if($this->checkLastQuota($date)) {
                  $data = array('status' => 3, 'msg'=> '小样已经全部领空。', 'userStatus' => $user->status);
                  $this->dataPrint($data);
              } else {
                  $data = array('status' => 2, 'msg'=> '今天小样已经领取完毕，请明天再来。', 'userStatus' => $user->status);
                  $this->dataPrint($data);
              }
          }
          //领取小样
          $DatabaseAPI->setGift($user->uid);
          $user->status['isgift'] = 1;
          $data = array('status' => 1, 'msg'=> '小样领取成功', 'userStatus' => $user->status);
          $this->dataPrint($data);
      } else {
          $data = array('status' => 0, 'msg'=> '非新关注用户没有领取资格', 'userStatus' => $user->status);
          $this->dataPrint($data);
      }
    }

   /**
    * 判断小样是否已经领取没了
    */
   private function checkGiftNum($db, $quota)
   {
     $count = $db->hasGift();
     if($count == $quota) {
         return FALSE;
     } else {
         return TRUE;
     }
   }

   /**
    * 查小样的数量
    */
   private function getGiftQuota($db, $date)
   {
      $quota = $db->checkGiftQuota($date, 1);
      $num = $db->getGift();
      if($quota >= 0) {
          return true;
      } else {
          return false;
      }
   }

   /**
    * 查奖品的数量
    */
   private function getLotteryQuota($db, $date)
   {
     $quota = $db->checkGiftQuota($date, 2);
     if($quota > 0) {
         return true;
     } else {
         return false;
     }
   }

   /**
    * 判断小样是否是都没了
    */
   private function checkLastQuota($date)
   {
     $lastDate = '2017-08-19';
     if($lastDate == $date) {
         return true;
     } else {
         return false;
     }
   }

   /**
    * 每天十点放库存
    */
   private function checkQuotaTime()
   {
      $time = date("H");
      if($time >= OPEN_TIME) {
          return true;
      } else {
          return false;
      }
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
     * 发送模版消息
     */
    private function sendTmpMsg($accessToken, $msgType, $content)
    {

    }

    /**
     * 验证数据来源ip是否合法
     */
    private function checkApiIp($ip)
    {
      if(API_IP == $ip) {
        return true;
      }
      return false;
    }

    /**
     * 领取奖品填写个人数据
     */
    public function insertGiftInfo($giftinfo)
    {
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
    public function insertLotteryInfo($lotteryinfo)
    {
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
    public function findGiftInfoByUid($uid)
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

    /**
     * Find lottery_info in database
     */
    public function findLotteryInfoByUid($uid)
    {
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
