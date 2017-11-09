<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
$gmsg = new GroupMsg();
$gmsg->pushMsg();
// $gmsg->getMediaList();
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

   // public function getMediaList()
   // {
   //     $apiUrl = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=%s";
   //     $url = sprintf($apiUrl, $this->aceessToken);
   //     $data = array(
   //         'type' => 'news',
   //         'offset' => 0,
   //         'count' => 10,
   //     );
   //     $rs = $this->postData($url, json_encode($data, JSON_UNESCAPED_UNICODE));
   //     var_dump($rs);exit;
   //     return $rs;

   // }

    public function pushMsg()
    {
        $tagID = 101;
        $mediaId = 'SGeNhcvpGy-dKXS_exvIuKh6PWo9fX5dnoWCPSNbChQ';
        $data = $this->msgFormat($tagID, $mediaId);
        // var_dump($data);exit;

        $rs = $this->sendMsgByTag($data);
        // $log = new \stdClass();
        // $log->openid = $openidList;
        // $log->data = json_encode($data);
        // $log->errcode = $rs->errcode;
        // $log->errmsg = $rs->errmsg;
        // $this->insertTmpLog($log);
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
    private function msgFormat($tagid, $mediaId)
    {
        $msgData = array(
            'filter' => array(
                'is_to_all' => false,
                'tag_id' => $tagid,
            ),
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
    private function sendMsgByTag($data)
    {
        $applink = "https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=%s";
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