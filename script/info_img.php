<?php
define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;

$img = new InfoImg();
$img->saveMedia();

class InfoImg
{
    const WECHAT_MEDIA_URL = "https://api.weixin.qq.com/cgi-bin/material/add_material?access_token=%s&type=%s";

    private $helper;
    private $_pdo;
    private $aceessToken;

    public function __construct() 
    {
        $this->helper = new Helper();
        $this->_pdo = PDO::getInstance();
        $this->aceessToken = $this->getAccessToken();
    }

    public function saveMedia() 
    {
        $list = $this->getDataList();
        foreach ($list as $k => $v) {
            $mediaObj = new \stdClass();
            $mediaObj->id = $v['id'];
            $postObj = $this->uploadImg($v['date']);
            $mediaObj->media_id = $postObj->media_id;
            $mediaObj->url = $postObj->url;
            $this->updateMeid($mediaObj);
        }
    }

    private function uploadImg($date)
    {
        $apiUrl = sprintf(self::WECHAT_MEDIA_URL, $this->aceessToken, 'image');
        $filePostName = $date . 'jpg';
        $imgUrl = $this->getImgByDate($date, 'image/jpeg', $filePostName);
        $imgFile = curl_file_create($imgUrl); 
        $imgData = array('media' => $imgFile);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $apiUrl);
        curl_setopt($curl, CURLOPT_USERAGENT,'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
        curl_setopt($curl, CURLOPT_HTTPHEADER,array('User-Agent: Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15','Referer: http://someaddress.tld','Content-Type: multipart/form-data'));
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
        curl_setopt($curl, CURLOPT_POST, true); // enable posting
        curl_setopt($curl, CURLOPT_POSTFIELDS, $imgData); // post images 
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // if any redirection after upload
        $r = curl_exec($curl); 
        return json_decode($r);
        curl_close($curl); 
    }

    private function getImgByDate($date)
    {
        // $img = file_get_contents(SITE_URL . '/script/img/'. $date . '.jpg');
        // return $img;
        return SITE_URL . '/script/img/'. $date . '.jpg';
    }

    private function getDataList()
    {
        $sql = "SELECT `id`, `date` FROM `date` where `media_id` is null";
        $query = $this->_pdo->prepare($sql);
        $query->execute();
        $list = $query->fetchAll(\PDO::FETCH_ASSOC);
        if(!$list) {
            return array();    
        } 
        return $list;
    }

    private function updateMeid($data)
    {   
        $condition = array(
            array('id', $data->id, '='),
        );
        $info = new \stdClass();
        $info->media_id = $data->media_id;
        $info->url = $data->url;
        return $this->helper->updateTable('date', $info, $condition);
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