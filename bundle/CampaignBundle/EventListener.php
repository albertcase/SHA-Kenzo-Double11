<?php

namespace CampaignBundle;

use Core\Event;
use Lib\PDO;
use Lib\UserAPI;
use Lib\Helper;

class EventListener
{
	public function initUser(Event $event)
	{
		global $user;
		$this->request = $event->getRequest();
		$UserAPI = new UserAPI();
		$user = $UserAPI->userLoad();
		if(!$user->uid) {
			$helper = new Helper();
			$user_info = new \stdClass();
			$user_info->openid = $helper->uuidGenerator();
			$userAPI->userRegister($user_info);
        }
	}

	public function extendUser(Event $event)
	{
		global $user;	
		$info = $this->getUserInfo($user->uid);
		//$user->nickname = $info->nickname; //add some additional field 
	}

	public function getUserInfo($uid)
	{
		$pdo = PDO::getInstance();
		$info = new \stdClass();
		$info->nickname = 'Albert';
		return $info;
		//do some query
	}
}