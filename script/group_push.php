<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
$gmsg = new GroupMsg();
$gmsg->pushMsg();
echo 'send ok';

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
        $sql = "SELECT `uid`, `openid` FROM `user` where status = 0";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $openidList = array();
        while($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            array_push($openidList, $row['openid']);
        }
        $data = $this->msgFormat($openidList, '');

        $rs = $this->sendTmpMsg($data);

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
                'mpnews' => $mediaId,
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

}