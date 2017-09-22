<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;

//推送的日期
$date = date('Y-m-d', strtotime($argv[1])) ? date('Y-m-d', strtotime($argv[1])) : false;

$helper = new Helper();

$pmsg = new PushTmp($helper, $date);
$pmsg->pushTmp(); //推送消息


class PushTmp
{
    private $helper;
    private $_pdo;
    private $accessToken;
    private $pushDate;

    public function __construct($helper, $date)
    {
        $this->helper = $helper;
        $this->_pdo = PDO::getInstance();
        $this->aceessToken = $this->getAccessToken();
        $this->pushDate = $date;
    }

    /**
     * 获取access_token
     */
    private function getAccessToken()
    {   
        $apiUrl = 'http://kenzowechat.samesamechina.com/Weixin/Getaccesstoken';
        $accessToken = file_get_contents($apiUrl);
        if($accessToken) {
            return $accessToken;
        } else {
            return NULL;
        }
    }


    private function updateUserStatus($uid)
    {
        $condition = array(
            array('uid', $uid, '='),
        );
        $info = new \stdClass();
        $info->status = 1;
        $info->updated = date('Y-m-d H:i:s');
        return $this->helper->updateTable('user', $info, $condition);
    }

    private function insertTmpLog($log)
    {
        $log->created = date('Y-m-d H:i:s');
        $log = (array) $log;
        $id = $this->helper->insertTable('tmp_log', $log);
        if($id) {
            return $id;
        }
        return false;
    }

    /**
     * 获取用户列表
     */
    public function pushTmp()
    {
        /** TEST
        $user = new  \stdClass();
        $user->nickname = 'hghg';
        $user->openid = 'oEts5uHtOI2ITSLsEg5zBLyj43ag';
        // $content = 'Hi ' . $user->nickname . '，Miss K提醒你，你的签到天数对应最终睡美人面膜（75ML）的抽奖次数哦，赶紧点击菜单栏签到吧，11月11号开启抽奖哦~';
        $content = 'Hi ' . $user->nickname . '，错过今天的签到，就将遗憾错过KENZO花颜礼盒哦，点击菜单栏“签到”恢复签到习惯吧~';
        $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', $content);
        $rs = $this->sendTmpMsg($data);
        */

        $sql = "SELECT `uid`, `openid`, `nickname`  FROM `user` where status = 0";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        
        while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $rs = $this->sendMsg((object)$row);
            if($rs) {
                echo 'openid' . $row['openid'] . " push success!\n";
            } else {
                echo 'openid' . $row['openid'] . " push failed!\n";
            }
        }
    }

    /**
     * 根据用户状态发送对应的模版消息
     */
    private function sendMsg($user)
    {
        $status = $this->getUserStatus($user->uid);
        switch($status) {

            case '9days':
                $content = 'Hi ' . $user->nickname . '，Miss K提醒你，你的签到天数对应最终睡美人面膜（75ML）的抽奖次数哦，赶紧点击菜单栏签到吧，11月11号开启抽奖哦~';
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', $content);
                break;

            case '8days':
                $content = 'Hi ' . $user->nickname . '，错过今天的签到，就将遗憾错过KENZO花颜礼盒哦，点击菜单栏“签到”恢复签到习惯吧~';
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', $content);
                break;

            case '5days':
                $content = 'Hi ' . $user->nickname . '你已经连续5天没有来签到咯，Miss K很想你呢，点击菜单栏“签到”即可快速签到！';
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', $content);
                break;

            case '3days':
                $content = 'Hi ' . $user->nickname . '，你已经连续3天没有来签到咯，今天别忘了哦，Miss K等你~点击菜单栏“签到”即可快速签到！';
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', $content);
                break;

            default:
                $data = array();
                break;
                
        }
        if(!empty($data)) {
            $rs = $this->sendTmpMsg($data);
            $log = new \stdClass();
            $log->openid = json_encode(array($user->openid), JSON_UNESCAPED_UNICODE);
            $log->data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $log->errcode = $rs->errcode;
            $log->errmsg = $rs->errmsg;
            $log->wechat_msgid = $rs->msgid;
            $this->insertTmpLog($log);
            return true;
        }
        return false;
    }

    /**
     * 格式化模版消息
     */
    private function msgFormat($openid, $tmpid, $text)
    {
        $msgData = array(
            'touser' => $openid,
            'template_id' => $tmpid,
            // 'url' => 'http://weixin.qq.com/download',
            'data' => array(
                'first' => array(
                    'value' => $text . "\n",
                    'color' => '#173177',
                ),
                'keyword1' => array(
                    'value' => 'KENZO签到提醒',
                    'color' => '#173177',
                ),
                'keyword2' => array(
                    'value' => $this->pushDate,
                    'color' => '#173177',
                ),
            ),
        );
        return $msgData;
    }

    /**
     * 发送模版消息
     */
    private function sendTmpMsg($data)
    {
        $applink = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=%s";
        $url = sprintf($applink, $this->aceessToken);
        $rs = $this->postData($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $rs;
    }

    /**
     * 分组推送
     */
    private function sendMsgByGroup($data)
    {
        $applink = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=%s";
        $url = sprintf($applink, $this->aceessToken);
        $rs = $this->postData($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $rs;
    }

    /**
     * 超过8天
     */
    private function getDays9Status($uid)
    {
        $privous9day = $this->getTargetDate($this->pushDate, 9);
        $privous9dayCount = $this->getUserStatusQuery($uid, array($privous9day, $this->pushDate));
        if($privous9dayCount >= 9){
            return '9days';
        } else {
            return '';
        }
    }

    /**
     * 累计8天
     */
    private function getDays8Status($uid)
    {
        $dayCount = $this->getUserStatusQuery($uid, array('2017-10-09', $this->pushDate));
        $dayCountPrivous1 = $this->getUserStatusQuery($uid, array('2017-10-09', $this->getTargetDate($this->pushDate, 1)));

        if($dayCountPrivous1 == 8 && $this->pushDate != '2017-10-18')
            return '';

        if($dayCount == 8)
            return '8days'; 

    }

    /**
     * 连续5天
     */
    private function getDays5Status($uid)
    {
        $privous5day = $this->getTargetDate($this->pushDate, 5);
        $privous6day = $this->getTargetDate($this->pushDate, 6);
        $privous5dayCount = $this->getUserStatusQuery($uid, array($privous5day, $this->pushDate));
        $privous6dayCount = $this->getUserStatusQuery($uid, array($privous6day, $this->pushDate));
        if($privous5dayCount == 5 && $privous6dayCount == 5){
            return '5days';
        } else {
            return '';
        }
    }

    /**
     * 连续3天
     */
    private function getDays3Status($uid)
    {
        $privous3day = $this->getTargetDate($this->pushDate, 3);
        $privous4day = $this->getTargetDate($this->pushDate, 4);
        $privous3dayCount = $this->getUserStatusQuery($uid, array($privous3day, $this->pushDate));
        $privous4dayCount = $this->getUserStatusQuery($uid, array($privous4day, $this->pushDate));
        if($privous3dayCount == 3 && $privous4dayCount == 3){
            return '3days';
        } else {
            return '';
        }
    }

    private function getTargetDate($currentDate = null, $offset)
    {
        if($currentDate)
           return date("Y-m-d", strtotime("$currentDate -$offset days"));
    }

    /**
     * 获取用户的状态
     */
    private function getUserStatus($uid) {
        if($status = $this->getDays9Status($uid)) {
            return $status;
        }
        if($status = $this->getDays8Status($uid)) {
            return $status;
        }
        if($status = $this->getDays5Status($uid)) {
            return $status;
        }
        if($status = $this->getDays3Status($uid)) {
            return $status;
        }
    }

    /**
     * 查询用户的状态
     * @param $where 查询条件
     */
    private function getUserStatusQuery($uid, $where)
    {
        $sql = "SELECT count(d.date) AS sum FROM date d LEFT JOIN checkin c on d.id = c.did AND uid =".$uid." WHERE d.date >= '".$where[0]."' AND d.date < '".$where[1]."' AND c.uid is null";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        if($row)
            return $row['sum'];
        return null;
    }

    private function postData($url, $post_json) {
        // post data to wechat
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_json);
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }

}
