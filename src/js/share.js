
function wechatShareConfig(data) {

	wx.config({
	  debug: false, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
	  appId: data.appId, // 必填，公众号的唯一标识
	  timestamp: data.timestamp, // 必填，生成签名的时间戳
	  nonceStr: data.nonceStr, // 必填，生成签名的随机串
	  signature: data.signature,// 必填，签名，见附录1
	  jsApiList: [
	    'checkJsApi',
	    'onMenuShareTimeline',
	    'onMenuShareAppMessage',
	    'onMenuShareQQ',
	    'onMenuShareWeibo',
	    'hideMenuItems',
	    'showMenuItems',
	    'hideAllNonBaseMenuItem',
	    'showAllNonBaseMenuItem',
	    'translateVoice',
	    'startRecord',
	    'stopRecord',
	    'onRecordEnd',
	    'playVoice',
	    'pauseVoice',
	    'stopVoice',
	    'uploadVoice',
	    'downloadVoice',
	    'chooseImage',
	    'previewImage',
	    'uploadImage',
	    'downloadImage',
	    'getNetworkType',
	    'openLocation',
	    'getLocation',
	    'hideOptionMenu',
	    'showOptionMenu',
	    'closeWindow',
	    'scanQRCode',
	    'chooseWXPay',
	    'openProductSpecificView',
	    'addCard',
	    'chooseCard',
	    'openCard'
	  ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
	});


	// wx.error(function(res){
	// 	//console.log(res);
	// });
}

function wechatShare(data, callback) {
	wx.onMenuShareTimeline({
	    title: data.t_title, // 分享标题
	    link: data.link, // 分享链接
	    imgUrl: data.img, // 分享图标
	    success: function () {
	        // 用户确认分享后执行的回调函数
	        callback('Timeline');
	        //_hmt.push(['_trackEvent', 'wechat', 'share', 'Timeline']);
	    },
	    cancel: function () { 
	        // 用户取消分享后执行的回调函数
	        // alert("分享失败")
	    }
	});

	wx.onMenuShareAppMessage({
	    title: data.title, // 分享标题
	    link: data.link, // 分享链接
	    imgUrl: data.img, // 分享图标
	  	desc: data.desc,
	    success: function () { 
	        // 用户确认分享后执行的回调函数
	        callback('AppMessage');
	        //_hmt.push(['_trackEvent', 'wechat', 'share', 'AppMessage']);
	    },
	    cancel: function () { 
	        // 用户取消分享后执行的回调函数
	       // alert("分享失败")
	    }
	});
}
