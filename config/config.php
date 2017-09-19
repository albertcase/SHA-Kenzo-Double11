<?php

define("BASE_URL", 'http://kenzodouble11.samesamechina.com/');
define("TEMPLATE_ROOT", dirname(__FILE__) . '/../template');
define("VENDOR_ROOT", dirname(__FILE__) . '/../vendor');

//ENV
define("ENV", 'dev');

//User
define("USER_STORAGE", 'COOKIE');

//
define("WECHAT_CAMPAIGN", true);

//Wechat Vendor
define("WECHAT_VENDOR", 'coach'); // default | curio

//Wechat config info
define("TOKEN", '');
define("APPID", '');
define("APPSECRET", '');
define("NOWTIME", date('Y-m-d H:i:s'));
define("AHEADTIME", '1000');

define("NONCESTR", '?????');
define("COACH_AUTH_URL", 'http://kenzowechat.samesamechina.com/weixin/oauth2'); 

//Redis config info
define("REDIS_HOST", '127.0.0.1');
define("REDIS_DBNAME", 1);
define("REDIS_PORT", '6379');

//Database config info
define("DBHOST", '127.0.0.1');
define("DBUSER", 'root');
define("DBPASS", '');
define("DBNAME", 'kenzo_double11');

//Wechat Authorize
define("CALLBACK", 'wechat/callback');
define("SCOPE", 'snsapi_base');

//Wechat Authorize Page
define("AUTHORIZE_URL", '[
    "/freetrial",
    "/luckydraw"
]');

//Account Access
define("OAUTH_ACCESS", '{
	"xxxx": "samesamechina.com"
}');
define("JSSDK_ACCESS", '{
	"xxxx": "samesamechina.com",
	"dev": "127.0.0.1"
}');

define("ENCRYPT_KEY", '29FB77CB8E94B358');
define("ENCRYPT_IV", '6E4CAB2EAAF32E90');

define("WECHAT_TOKEN_PREFIX", 'wechat:token:');

define("API_IP", '127.0.0.1');
define("SIGN_DATE", '2017-11-09');
define("OPEN_TIME", '1');
define("PROBABILITY", '1/10');
define("GIFT_NUM", 10);
define("LOTTERY_NUM", 10);
