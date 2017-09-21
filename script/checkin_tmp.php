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
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', '您已经超过8天未签到了');
                break;

            case '8days':
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', '您已经累计8天未签到了');
                break;

            case '5days':
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', '您已经连续5天未签到了');
                break;

            case '3days':
                $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', '您已经连续3天未签到了');
                break;

            default:
                $data = array();
                break;
                
        }
        // var_dump($data);exit;
        if(!empty($data)) {
            $rs = $this->sendTmpMsg($data);
            $log = new \stdClass();
            $log->openid = json_encode(array($user->openid), JSON_UNESCAPED_UNICODE);
            $log->data = json_encode($data, JSON_UNESCAPED_UNICODE);
            $log->errcode = $rs->errcode;
            $log->errmsg = $rs->errmsg;
            // $log->wechat_msgid = $rs->msgid;
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
            'url' => 'http://weixin.qq.com/download',
            'data' => array(
                'first' => array(
                    'value' => '测试模版消息',
                    'color' => '#173177',
                ),
                'keyword1' => array(
                    'value' => $text,
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
        // $days9 = new \stdClass();
        // $days9->where = "d.date < '$this->pushDate' and c.uid is null";
        // $days9->num = 9;
        // if($this->getUserStatusQuery($uid, $days9)) {
        //     $this->updateUserStatus($uid);
        //     return '9days';
        // }
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

        // 如果累计8天之后连续签到的话只发一次消息
        // $days8 = new \stdClass();
        // $days8->where = "d.date < '$this->pushDate' and c.uid is null";
        // $days8->num = 8;
        // $days88 = new \stdClass();
        // $end = date("Y-m-d", strtotime("$this->pushDate + $");
        // $days88->where = "d.date < '" . $end . "' and c.uid is null";
        // $days88->num = 8;
        // if($this->getUserStatusQuery ($uid, $days8) && $this->getUserStatusQuery ($uid, $days88) && $this->pushDate != '2017-10-18') {
        //     return '8days';
        // } else {
        //     return '';
        // }
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
        // $days5 = new \stdClass();
        // $end5 = date("Y-m-d", strtotime($this->pushDate) - (6 * 24 * 3600));
        // $days5->where = "d.date < '$this->pushDate' and d.date > '" . $end5 . "' and c.uid is null";
        // $days5->num = 5;
        // $days55 = new \stdClass();
        // $end = date("Y-m-d", strtotime($this->pushDate) - (24 * 3600));
        // $end5 = date("Y-m-d", strtotime($end) - (6 * 24 * 3600));
        // $days55->where = "d.date < '" . $end . "' and d.date > '" . $end5 . "' and c.uid is null";
        // $days55->num = 5;
        // if($this->getUserStatusQuery ($uid, $days5) && $this->getUserStatusQuery ($uid, $days55)) {
        //     return '5days';
        // } else {
        //     return '';
        // }
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
        // $days3 = new \stdClass();
        // $end3 = date("Y-m-d", strtotime($this->pushDate) - (4 * 24 * 3600));
        // $days3->where = "d.date < '$this->pushDate' and d.date > '" . $end3 . "' and c.uid is null";
        // $days3->num = 3;
        // $days33 = new \stdClass();
        // $end = date("Y-m-d", strtotime($this->pushDate) - (24 * 3600));
        // $end3 = date("Y-m-d", strtotime($end) - (4 * 24 * 3600));
        // $days33->where = "d.date < '" . $end . "' and d.date > '" . $end3 . "' and c.uid is null";
        // $days33->num = 3;
        // if($this->getUserStatusQuery ($uid, $days3) && $this->getUserStatusQuery ($uid, $days33)) {
        //     return '3days';
        // } else {
        //     return '';
        // }
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
