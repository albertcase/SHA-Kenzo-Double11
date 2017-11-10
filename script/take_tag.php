<?php

define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;

$tag = new Tag();
// $tag->getTagUsers(101); //拉取标签下的用户列表
// $tag->createTag(); //新增标签
$tag->takeTag(); //为用户打标签

/**
 * 为参加活动的用户打上标签 
 */
class Tag
{
    private $_pdo;
    private $accessToken;
    private $helper;

    public function __construct()
    {
        $this->_pdo = PDO::getInstance();
        $this->helper = new Helper();
    }

    public function takeTag()
    {   
        // $openidList = array('oEts5uHq4oonn9HZ9TSGkGS66E9g', 'oEts5uH57nQrFTaEgkkZXGB2tHIM');
        // $this->batchTag($openidList, 101);exit;

        $tagList = $this->getTagList();
        var_dump($tagList);exit;

        $pageNum = $this->getPageNum();
        $openidList = array();
        $tagId = 100;

        for($i=1; $i<=$pageNum; $i++) {
            $start = ($i - 1) * 50;
            $sql = "SELECT `uid`, `openid` FROM `user` WHERE `openid` is not null ORDER BY uid limit {$start}, 50";
            $query = $this->_pdo->prepare($sql);
            $query->execute();
            $userList = $query->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($userList as $k => $v) {
                array_push($openidList, $userList[$k]['openid']); 
            }
            $this->batchTag($openidList, $tagId);
            echo $i."页打标枪成功！";
            $openidList = array();
        }
    }

    public function batchTag($openidList, $tagId)
    {
        $token = $this->getAccessToken();
        $apiUrl = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token={$token}";
        $apiData = array(
            'openid_list' => $openidList,
            'tagid' => $tagId,
        );
        $rs = $this->postData($apiUrl, json_encode($apiData));
        var_dump($rs);
    }

    public function getPageNum()
    {
        $sql = "SELECT count(`uid`) AS sum FROM `user`";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $count = $query->fetch(\PDO::FETCH_ASSOC);
        $num = ceil($count['sum'] / 50);
        return $num;
    }


    public function getTagUsers($tagId)
    {
        $token = $this->getAccessToken();
        $apiUrl = "https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token={$token}";
        $apiData = array(
            'tagid' => $tagId,
        );
        $rs = $this->postData($apiUrl, json_encode($apiData));
        var_dump($rs);
    }

    /**
     * 获取access_token
     */
    public function getAccessToken()
    {   
        $apiUrl = 'http://kenzowechat.samesamechina.com/Weixin/Getaccesstoken';
        $accessToken = $this->getdata($apiUrl);
        if($accessToken) {
            return $accessToken;
        } else {
            return NULL;
        }
    }

    public function getTagList()
    {
        $token = $this->getAccessToken();
        $apiUrl = "https://api.weixin.qq.com/cgi-bin/tags/get?access_token={$token}";
        $list = $this->getdata($apiUrl);
        $rs = json_decode($list, 1);
        var_dump($rs);exit;
        return $rs['tags'][1];
    }

    public function createTag()
    {
        $token = $this->getAccessToken();
        $apiUrl = "https://api.weixin.qq.com/cgi-bin/tags/create?access_token={$token}";
        $data = array(
            'tag' => array(
                'name' => 'test',
            ),    
        );
        $rs = $this->postData($apiUrl, json_encode($data));
        var_dump($rs);exit;
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