<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;

$s = new sendCustom();
$s->sendMsg();

echo 'send ok';

class sendCustom
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
        $sql = "SELECT `openid`, `data` FROM `msg_log` WHERE `errcode` != 0 AND `created` >= '2017-11-01 00:00:00'";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        
        while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $sendRs = $this->sendCustomMsgTowechat($row['data']);
            if($sendRs->errcode == 0) {
                $this->updateSendStatus($row['openid'], $sendRs->errcode, $sendRs->errmsg);
            }
        }
    }

    private function updateSendStatus($openid, $errcode, $errmsg);
    {

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

}