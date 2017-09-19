<?php

namespace CampaignBundle;

use Core\Controller;
use Lib\Helper;
use Lib\PDO;
use Lib\UserAPI;
use Lib\WechatAPI;
use \Lib\Redis;
use \Lib\Captcher;

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

    /**
     * 抽奖
     */
    public function lotteryAction()
    {
        global $user;

        //已中奖
        if ($this->findLotteryByUid($user->uid)) {
            $this->setLottery($user->uid, 2);
            $data = array('status' => 3, 'msg'=> '您已获奖');
            $this->dataPrint($data);
        }

        //奖发完
        if(!$this->checkLotteryQuota()) {
            $data = array('status' => 2, 'msg'=> '奖品已经发完！');
            $this->dataPrint($data);
        }

        //抽奖次数用完
        $sum = $this->getCheckinSum($user->uid);
        $num = $this->getLotterys($user->uid);

        if($num >= $sum) {
            $data = array('status' => 4, 'msg'=> '您的抽奖次数已经用完！');
            $this->dataPrint($data);
        }

        //中奖率
        $rands = explode('/', PROBABILITY);
        $rand = mt_rand(1, $rands['1']);

        //中奖
        if ($rand <= $rands['0']) {
            $this->setLottery($user->uid, 1);
            $user->status['isluckydraw'] = 1;
            $data = array('status' => 1, 'msg'=> '恭喜中奖');
            $this->dataPrint($data);
        }

        //未中奖
        $this->setLottery($user->uid, 2);
        $data = array('status' => 0, 'msg'=> '遗憾未中奖');
        $this->dataPrint($data);
    }

    /**
     * 判断是否还有奖品可以抽
     */
    private function checkLotteryQuota()
    {
        $sum = $this->getLotterySum();
        if($sum <= LOTTERY_NUM) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 查看当前一共抽中多少奖
     */
    private function getLotterySum()
    {
        $sql = "select count(id) AS sum from lottery where status = 1";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return (int) $row['sum'];
    }

    /**
     * 返回当前的抽奖人的状态
     */
    public function luckydrawstatusAction()
    {
        global $user;
        $totaldays = $this->getCheckinSum($user->uid);
        $lotteryNum = $this->getLotterys($user->uid);
        $totaltimes = $totaldays;
        if($lotteryNum > $totaltimes) {
            $remaintimes = 0;
        } else {
            $remaintimes = $totaldays - $lotteryNum;
        }
        $msg = array(
            'totaldays' => $totaldays,
            'totaltimes' => $totaldays,
            'remaintimes' => $remaintimes,
        );
        $data = array('status' => 1, 'msg' => $msg);
        $this->dataPrint($data);
    }
    
    /**
     * 查找当前用户是否中奖
     */
    private function findLotteryByUid($uid)
    {
        $sql = "SELECT `id` FROM `lottery` WHERE `uid` = :uid AND status=1";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $uid));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return 1;
        }
        return 0;
    }

    /**
     * 查找当前用户一共抽了多少次
     */
    private function getLotterys($uid)
    {
        $sql = "select count(id) AS sum from lottery where uid = {$uid}";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return (int) $row['sum'];
    }

    /**
     * 抽奖
     */
    private function setLottery($uid, $status)
    {
        $helper = new Helper();
        $lottery = new \stdClass();
        $lottery->uid = $uid;
        $lottery->status = $status;
        $lottery->created = date('Y-m-d H:i:s');
        $lottery = (array) $lottery;
        $id = $helper->insertTable('lottery', $lottery);
        if($id) {
            return true;
        }
        return false;
    }

    /**
     * 获得一共签到了多少天
     */
    private function getCheckinSum($uid)
    {
        $sql = "select count(d.date) AS sum from date d left join checkin c on d.id = c.did and uid =" . $uid ." where d.date <='" . SIGN_DATE . "' and c.uid is not null";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return (int) $row['sum'];
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
        $RedisAPI = new Redis();
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
            'phone' => array('cellphone', '121'),
            'phonecode' => array('notnull', '120'),
        );
        $request->validation($fields);
        $phone = $request->request->get('phone');
        $phoneCode = $request->request->get('phonecode');
        if($this->checkMsgCode($phone, $phonecode)) {
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
        $captcha = new Captcher(150, 65);
        $captchaImage = $captcha->generate();
        $captchaText = $captcha->getCaptchaText();
        $_SESSION['captcha-protection'] = $captchaText;
        $picture = base64_encode($captchaImage);
        $data = array('status' => 1, 'picture' => $picture);
        $this->dataPrint($data);
    }

    /**
     * 填写抽奖的信息
     */
    public function lotteryinfoAction()
    {
        global $user;
        $request = $this->request;
        $fields = array(
            'name' => array('notnull', '120'),
            'province' => array('notnull', '121'),
            'city' => array('notnull', '121'),
            'address' => array('notnull', '122'),
            'mobile' => array('cellphone', '121'),
            'msgCode' => array('notnull', '120'),
        );
        $request->validation($fields);

        if(!$this->checkMsgCode($request->request->get('mobile'), $request->request->get('msgCode'))) {
            $data = array('status' => 2, 'msg'=> '手机验证码错误');
            $this->dataPrint($data);
        }

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
            'province' => array('notnull', '121'),
            'city' => array('notnull', '121'),
            'address' => array('notnull', '122'),
            'mobile' => array('cellphone', '121'),
            'msgCode' => array('notnull', '120'),
        );
        $request->validation($fields);

        if(!$this->checkMsgCode($request->request->get('mobile'), $request->request->get('msgCode'))) {
            $data = array('status' => 2, 'msg'=> '手机验证码错误');
            $this->dataPrint($data);
        }

        if($this->findGiftInfoByUid($user->uid)) {
            $this->statusPrint('2', '您已经填写过信息！');
        }
        $data = new \stdClass();
        $data->uid = $user->uid;
        $data->name = $request->request->get('name');
        $data->tel = $request->request->get('mobile');
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
     * 抽奖填写个人数据
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
     * 查找抽奖的个人数据是否填写过
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
