<?php

$routers = array();
//System
$routers['/wechat/callback'] = array('WechatBundle\Wechat', 'callback');
$routers['/wechat/curio/callback'] = array('WechatBundle\Coach', 'callback');
$routers['/wechat/curio/receive'] = array('WechatBundle\Coach', 'receiveUserInfo');
$routers['/wechat/jssdk/config/js'] = array('WechatBundle\Wechat', 'jssdkConfigJs');
$routers['/simulation/login'] = array('WechatBundle\Wechat', 'simulationLogin');
$routers['/clear'] = array('CampaignBundle\Page', 'clearCookie');
//System end

//Campaign
$routers['/ajax/post'] = array('CampaignBundle\Api', 'form');
$routers['/'] = array('CampaignBundle\Page', 'index');
$routers['/api/checkin'] = array('CampaignBundle\BackApi', 'checkin'); //签到
$routers['/test'] = array('CampaignBundle\Api', 'test');
$routers['/api/giftinfo'] = array('CampaignBundle\Api', 'giftinfo');
$routers['/api/lotteryinfo'] = array('CampaignBundle\Api', 'lotteryinfo');
$routers['/api/gift'] = array('CampaignBundle\Api', 'gift');
$routers['/api/islogin'] = array('CampaignBundle\Api', 'islogin');
$routers['/api/lottery'] = array('CampaignBundle\Api', 'lottery');
$routers['/api/picturecode'] = array('CampaignBundle\Api', 'pictureCode');
$routers['/api/checkpicture'] = array('CampaignBundle\Api', 'checkPicture');
$routers['/api/phonecode'] = array('CampaignBundle\Api', 'phoneCode');
$routers['/api/checkphonecode'] = array('CampaignBundle\Api', 'checkPhoneCode');

//TMP
$routers['/freetrial'] = array('CampaignBundle\Page', 'freetrial');
$routers['/luckydraw'] = array('CampaignBundle\Page', 'luckydraw');
