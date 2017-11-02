<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;

$userinfo = new GetInfo();
$userinfo->setInfo();

class GetInfo
{
    private $helper;
    private $_pdo;
    private $accessToken;

    public function __construct()
    {
        $this->helper = new Helper();
        $this->_pdo = PDO::getInstance();
        $this->aceessToken = $this->getAccessToken();
    }

    public function setInfo()
    {
        $sql = "SELECT `uid`, `openid` FROM `user` where nickname is null";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        
        while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            $info = $this->getUserInfoByWechat($row['openid']);
            if($info->subscribe == 1) {
                $userInfo = new \stdClass();
                $userInfo->updated = date('Y-m-d H:i:s');
                $userInfo->nickname = $info->nickname;
                $userInfo->sex = $info->sex;
                $userInfo->province = $info->province;
                $userInfo->country = $info->country;
                $userInfo->city = $info->city;
                $userInfo->headimgurl = $info->headimgurl;
                $this->updateUserInfo($row['uid'], $userInfo);
                echo "user " . $row['openid'] . " is subscribe and get userInfo\n";
            } else {
                echo "user " . $row['openid'] . " is not subscribe\n";
            }
        }
    }

    private function updateUserInfo($uid, $info)
    {
        $condition = array(
            array('uid', $uid, '='),
        );
        return $this->helper->updateTable('user', $info, $condition);
    }

    private function getUserInfoByWechat($openid)
    {
        $applink = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";
        $url = sprintf($applink, $this->aceessToken, $openid);
        $return = $this->getdata($url);
        return json_decode($return);
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

    private function postData($url, $post_json) 
    {
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
