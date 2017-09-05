<!DOCTYPE html>
<html>
<head>
	<title>xxxx</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<!--禁用手机号码链接(for iPhone)-->
	<meta name="format-detection" content="telephone=no">

	<!--自适应设备宽度-->
	<meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimum-scale=1.0,maximum-scale=1.0,minimal-ui" />
	
	<!--控制全屏时顶部状态栏的外，默认白色-->
	<meta name="apple-mobile-web-app-status-bar-style" content="black">

	<!--是否启动webapp功能，会删除默认的苹果工具栏和菜单栏。-->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="Keywords" content="">
	<meta name="Description" content="...">

	<link rel='stylesheet' type='text/css' href="/src/css/reset.css">
	<link rel='stylesheet' type='text/css' href="/src/css/common.css">
	<link rel='stylesheet' type='text/css' href="/src/css/main.css">
	<script>

	</script>
	<script type="text/javascript" src="https://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript" src="src/js/jquery.js"></script>
	<script type="text/javascript" src="src/js/rem.js"></script>
	<script type="text/javascript" src="src/js/main.js"></script>
	<script type="text/javascript" src="src/js/share.js"></script>
</head>
<body>

<div class="wrapper">

</div>

<!-- 横屏代码 -->
<div id="orientLayer" class="mod-orient-layer">
    <div class="mod-orient-layer__content">
        <i class="icon mod-orient-layer__icon-orient"></i>
        <div class="mod-orient-layer__desc">为了更好的体验，请使用竖屏浏览</div>
    </div>
</div>

<script>
wechatShareConfig(<?php print $config; ?>);

wx.ready(function(){
	wechatShare({
			title: 'xxxxxx',
			t_title: 'xxxxxxx',
			link: location.href,
			img: "http://" + window.location.host + "/src/img/share.jpg",
			desc: 'xxxxxxx'
		}, function(env){
			//callback fun
		});

	// wx.hideMenuItems({
		//   		menuList: data.exclude // 要隐藏的菜单项，只能隐藏“传播类”和“保护类”按钮，所有menu项见附录3
	// });

});

</script>
</body>
</html>
