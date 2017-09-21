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
        $config = array();
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
        global $user;
        $gift = $this->findGiftInfoByUid($user->uid);
        if($gift) {
            $isSubmit = 1;
        } else{
            $isSubmit = 0;
        }

        $config = array(
            'isSubmit' => $isSubmit,
        );
        return $this->render('freetrial', array('conf' => $config));
    }

    /**
     * 查看是否领取小样的个人数据填写过
     */
    private function findGiftInfoByUid($uid)
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

    public function luckydrawAction()
    {
        global $user;
        $isSubmit = $this->findLotteryInfoByUid($user->uid);
        $isLottery = $this->findLottery($user->uid);

        $totaldays = $this->getCheckinSum($user->uid);
        $lotteryNum = $this->getLotterys($user->uid);

        if($lotteryNum > $totaldays) {
            $remaintimes = 0;
        } else {
            $remaintimes = $totaldays - $lotteryNum;
        }

        $config = array(
            'isSubmit' => $isSubmit,
            'isLuckyDraw' => $isLottery,
            'remaintimes' => $remaintimes,
        );
        return $this->render('luckydraw', array('conf' => $config));
    }

    public function loginAction() {
        $openid = $_GET['openid'];
        $userAPI = new \Lib\UserAPI();
        $user = $userAPI->userLogin($openid);
        if(!$user) {
            $user = new \stdClass();
            $user->openid = $openid;
            $userAPI->userRegister($user);
        }
        echo 'user:login:'.$openid;
        exit;
    }

    private function getLotterys($uid)
    {
        $sql = "select count(id) AS sum from lottery where uid = {$uid}";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return (int) $row['sum'];
    }

    private function getCheckinSum($uid)
    {
        $sql = "select count(d.date) AS sum from date d left join checkin c on d.id = c.did and uid =" . $uid ." where d.date <='" . SIGN_DATE . "' and c.uid is not null";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return (int) $row['sum'];
    }

    /**
     * 查找抽奖的个人数据是否填写过
     */
    private function findLotteryInfoByUid($uid)
    {
        $sql = "SELECT `uid`, `name`, `tel`, `province`, `city`, `address` FROM `lottery_info` WHERE `uid` = :uid";
        $query = $this->_pdo->prepare($sql);
        $query->execute(array(':uid' => $uid));
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row) {
            return 1;
        }
        return 0;
    }

    private function findLottery($uid)
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

}
