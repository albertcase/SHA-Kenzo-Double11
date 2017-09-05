;(function($) {
    'use strict';
    $(function() {

		function checkMobileFormat(mobile) {
		    var regexp = /^1[34578][0-9]{9}$/;
		    if (mobile.length != 11 || !mobile.match(regexp)) {
		        return false;
		    }
		    return true;
		}

		var overscroll = function(el) {
		  el.addEventListener('touchstart', function() {
		    var top = el.scrollTop
		      , totalScroll = el.scrollHeight
		      , currentScroll = top + el.offsetHeight
		    //If we're at the top or the bottom of the containers
		    //scroll, push up or down one pixel.
		    //
		    //this prevents the scroll from "passing through" to
		    //the body.
		    if(top === 0) {
		      el.scrollTop = 1
		    } else if(currentScroll === totalScroll) {
		      el.scrollTop = top - 1
		    }
		  })
		  el.addEventListener('touchmove', function(evt) {
		    //if the content is actually scrollable, i.e. the content is long enough
		    //that scrolling can occur
		    if(el.offsetHeight < el.scrollHeight)
		      evt._isScroller = true
		  })
		}
		// overscroll(document.querySelector('#rules'));
		//overscroll(document.querySelector('#page2-3'));
		document.body.addEventListener('touchmove', function(evt) {
		  //In this case, the default behavior is scrolling the body, which
		  //would result in an overflow.  Since we don't want that, we preventDefault.
		  if(!evt._isScroller) {
		    evt.preventDefault()
		  }
		});

		var pageGoTo = function(page) {
			$(".page").fadeOut();
			$("#" + page).fadeIn();
		}

		var errorPage = function(msg) {
			$(".form-body").hide();
			$(".error p").html(msg);
			$(".error").show();
		}

		$(".open-rules").on("click", function() {
			$(".mask-layer").show();
		});

		$("#close-btn").on("click", function() {
			$(".mask-layer").hide();
		});

		$(".mask").on("click", function() {
			$(".mask-layer").hide();
		});

		$(".start-btn").on("click", function() {
			$("#snowflakeContainer").hide();
			pageGoTo("page2");
		});

		$("#back").on("click", function() {
			$(".error").hide();
			$(".form-body").show();
		});

		$("#name").focus(function() {
			$(this).attr('placeholder','');
		}).blur(function(){
  			$(this).attr('placeholder','姓名');
		});

		$("#cellphone").focus(function() {
			$(this).attr('placeholder','');
		}).blur(function(){
  			$(this).attr('placeholder','手机号');
		});

		$("#submit").on("click", function() {
			var name = $("#name").val();
			var cellphone = $("#cellphone").val();
			var product = $("#product").val();
			if(!name) {
				errorPage('用户名不能为空！');
				return;
			}
			if(!checkMobileFormat(cellphone)) {
				errorPage('手机号码不正确！');
				return;
			}
			if(!product) {
				errorPage('请选择产品！');
				return;
			}
			$("#loading-mask").show();
			var url = "/ajax/post";
			var xhr = $.ajax({
				"url" : url,
				"cache" : false,
				"dataType" : 'json',
				"type" : "POST",
				"data" : {
					name: name,
					cellphone: cellphone,
					product: product
				}
			});
			xhr.done(function(data){
				$("#loading-mask").hide();
				if(data.status == '1') {
					switch(data.cid) {
						case 1: 
							pageGoTo("page3");
							break;
						case 2: 
							pageGoTo("page4");
							break;
						case 3: 
							pageGoTo("page5");
							break;
						case 4: 
							pageGoTo("page6");
							break;
						default:
							pageGoTo("page7");
							break;
					} 
				} else {
					errorPage(data.msg);
				}
			});
		});



    });

})(jQuery)