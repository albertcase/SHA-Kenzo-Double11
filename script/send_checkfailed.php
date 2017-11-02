<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;

$s = new sendFailed();
$s->sendMsg();

echo 'send ok';

class sendFailed
{
    private $_pdo;
    private $accessToken;

    public function __construct()
    {
        $this->_pdo = PDO::getInstance();
        $this->aceessToken = $this->getAccessToken();
        $this->helper = new Helper();
    }

    public function sendMsg()
    {
        // $sql = "SELECT uid FROM `checkin` where created < '2017-11-01 23:59:59' GROUP BY uid HAVING count(uid) = 24";
        // $query = $this->_pdo->prepare($sql);
        // $query->execute();
        // $row = $query->fetchAll(\PDO::FETCH_ASSOC);
        // foreach ($row as $k => $v) {
        //     $row[$k] = $v['uid'];
        // }

        // $sql2 = "SELECT uid FROM `checkin` where created < '2017-11-02 23:59:59' GROUP BY uid HAVING count(uid) = 25";
        // $query2 = $this->_pdo->prepare($sql2);
        // $query2->execute();
        // $row2 = $query2->fetchAll(\PDO::FETCH_ASSOC);
        // foreach ($row2 as $k => $v) {
        //     $row2[$k] = $v['uid'];
        // }

        // $rs = array();
        // $rs = array_intersect($row2, $row);
        // print_r($rs);exit;

        $sql = "SELECT uid FROM `checkin` GROUP BY uid HAVING count(uid) = 24";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $openidList = array();
        $k = 0;
        while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            if(!$this->findLastDate($row['uid'])) {
                $openidList[$k]=$row['uid'];
                $k++;
            }
        }

        foreach ($openidList as $key => $val) {
            $sql1 = "SELECT `openid`, `nickname` FROM `user` WHERE `uid` = {$val}";
            $query1 = $this->_pdo->prepare($sql1);
            $query1->execute();
            $row1 = $query1->fetch(\PDO::FETCH_ASSOC);
            $data = array(
                'touser' => $row1['openid'],
                'msgtype' => 'text',
                'text' => "Hi 【" . $row1['nickname'] ."】，今天凌晨值班的服务器打了个盹儿，现在已经缓过劲儿啦！非常抱歉给您带来不便。请再点击右下角【一键签到】重新签到一次吧！累计的签到天数将对应11月11日睡美人面膜正装抽奖次数哦~",
            );
            $rs = $this->sendCustomMsgTowechat(json_encode($data, JSON_UNESCAPED_UNICODE));
            $text = "{$row1['openid']} send custom ok\n";
            echo $text;
            file_put_contents("log.txt", $text, FILE_APPEND);
            // 记录消息日志
            // $msglog = new \stdClass();
            // $msglog->openid = $openid;
            // $msglog->data = json_encode($data, JSON_UNESCAPED_UNICODE);
            // $msglog->errcode = $rs->errcode;
            // $msglog->errmsg = $rs->errmsg;
            // $this->insertMsgLog($msglog);
        }
        
        exit;
    }

    // private function insertMsgLog($log)
    // {
    //     $helper = new Helper();
    //     $log->created = date('Y-m-d H:i:s');
    //     $log = (array) $log;
    //     $id = $helper->insertTable('msg_log', $log);
    //     if($id) {
    //         return $id;
    //     }
    //     return false;
    // }

    private function findLastDate($uid)
    {
        $sql = "SELECT uid FROM `checkin` WHERE uid={$uid} AND created like '2017-11-02%'";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $rs = $row = $query->fetch(\PDO::FETCH_ASSOC);
        return $rs;
    }

    /**
     * 获取access_token
     */
    private function getAccessToken()
    {   
        $apiUrl = 'http://120.132.102.63/Weixin/Getaccesstoken';
        $accessToken = $this->getdata($apiUrl);
        if($accessToken) {
            return $accessToken;
        } else {
            return NULL;
        }
    }

    /**
     * 发送微信客服消息
     */
    public function sendCustomMsgTowechat($data) {
        $applink = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=%s";
        $url = sprintf($applink, $this->aceessToken);
        $rs = $this->postData($url, $data);
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