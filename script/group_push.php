<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
$gmsg = new GroupMsg();
$gmsg->pushMsg();
//$gmsg->getMediaList();
echo 'send ok';

class GroupMsg
{
    private $_pdo;
    private $accessToken;

    public function __construct()
    {
        $this->_pdo = PDO::getInstance();
        $this->aceessToken = $this->getAccessToken();
        $this->helper = new Helper();
    }

//    public function getMediaList()
//    {
//        $apiUrl = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=%s";
//        $url = sprintf($apiUrl, $this->aceessToken);
//        $data = array(
//            'type' => 'news',
//            'offset' => 0,
//            'count' => 2,
//        );
//        $rs = $this->postData($url, json_encode($data, JSON_UNESCAPED_UNICODE));
//        var_dump($rs);exit;
//        return $rs;
//
//    }

    public function pushMsg()
    {
//        $sql = "SELECT `uid`, `openid` FROM `user`";
//        $query = $this->_pdo->prepare($sql);
//        $query->execute();
        $openidList = array(
            'oEts5uCiZfLl7DlKLyeicIrtneP0',
            'oEts5uHq4oonn9HZ9TSGkGS66E9g'
        );
//        while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
//            array_push($openidList, $row['openid']);
//        }
//        var_dump($openidList);exit;
        $data = $this->msgFormat($openidList, 'SGeNhcvpGy-dKXS_exvIuK4glpwn9tOVWJwtKP2J68A');

        $rs = $this->sendMsgByGroup($data);

        $log = new \stdClass();
        $log->openid = json_encode($openidList, JSON_UNESCAPED_UNICODE);
        $log->data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $log->errcode = $rs->errcode;
        $log->errmsg = $rs->errmsg;
        $this->insertTmpLog($log);
        return true;
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
     * 格式化消息
     */
    private function msgFormat($openidList, $mediaId)
    {
        $msgData = array(
            'touser' => $openidList,
            'mpnews' => array(
                'media_id' => $mediaId,
            ),
            'msgtype' => 'mpnews',
            'send_ignore_reprint' => 0,
        );
        return $msgData;
    }

    /**
     * 分组推送
     */
    private function sendMsgByGroup($data)
    {
        $applink = "https://api.weixin.qq.com/cgi-bin/message/mass/send?access_token=%s";
        $url = sprintf($applink, $this->aceessToken);
        $rs = $this->postData($url, json_encode($data, JSON_UNESCAPED_UNICODE));
        return $rs;
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