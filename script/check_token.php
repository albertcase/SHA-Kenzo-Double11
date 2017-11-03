<?php

define('SITE_URL', dirname(dirname(__FILE__)));
require_once SITE_URL . "/vendor/autoload.php";
require_once SITE_URL . "/config/config.php";

use Lib\Helper;
use Lib\PDO;
use CampaignBundle\BackApiController;

$backApi = new BackApiController();
$token = $backApi->getAccessTokenByWechat();
$rs = file_get_contents("https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token={$token}");
var_dump($token, $rs);
exit;
