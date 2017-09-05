<?php

$redis = new Redis();
$redis->pconnect('127.0.0.1', 6379);

$i = 1;
$r = array();
while(true) {
	$r = $redis->brPop("events", 10);
	var_dump($i);
	var_dump($r);
	$i++;
}

?>