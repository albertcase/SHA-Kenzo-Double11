<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;

//推送的日期
// $date = date('Y-m-d', strtotime($argv[1])) ? date('Y-m-d', strtotime($argv[1])) : false;
$date = date('Y-m-d');

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
        $accessToken = $this->getdata($apiUrl);
        if($accessToken) {
            return $accessToken;
        } else {
            return NULL;
        }
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
            $checkinNum = $this->getCheckinSum($row['uid']);
            if($checkinNum == 24) {
                $rs = $this->sendMsg((object)$row);
                if($rs) {
                    echo 'openid' . $row['openid'] . " push success!\n";
                } else {
                    echo 'openid' . $row['openid'] . " push failed!\n";
                }
            } else {
                echo 'no people push msg!';
            }
        }
    }

    private function getCheckinSum($uid)
    {
        $sql = "select count(d.date) AS sum from date d left join checkin c on d.id = c.did and uid =" . $uid ." where d.date <='" . SIGN_DATE . "' and c.uid is not null";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $row = $query->fetch(\PDO::FETCH_ASSOC);
        return $row['sum'];
    }

    /**
     * 根据用户状态发送对应的模版消息
     */
    private function sendMsg($user)
    {
        $content = 'Hi ' . $user->nickname . '，你已签到满24 天，掌声鼓励！今天也请继续保持签到，就有机会抢先试用全新花颜舒柔系列产品哦！';
        $data = $this->msgFormat($user->openid, 'WwsoVpViE-R3yL4t_1oJBP0dqJdYmvr7oFLFKUCmpeA', $content);
        if(!empty($data)) {
            $rs = $this->sendTmpMsg($data);
            $log = new \stdClass();
            $log->openid = json_encode(array($user->openid));
            $log->data = json_encode($data);
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

    private function getdata($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json; charset=utf-8"));
        curl_setopt($ch, CURLOPT_POSTFIELDS, '{}');
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }
}
