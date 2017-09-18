<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
$gmsg = new GroupMsg();
$gmsg->pushMsg();

class GroupMsg
{
    private $_pdo;
    private $accessToken;

    public function __construct()
    {
        $this->_pdo = PDO::getInstance();
        $this->aceessToken = $this->getAccessToken();
    }

    public function pushMsg()
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

}