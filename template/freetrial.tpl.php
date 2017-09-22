<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>KENZO睡美人悦肤礼赠 </title>
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="full-screen" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="../src/dist/css/style.css"/>
    <script src="http://kenzowechat.samesamechina.com/weixin/jssdkforsite"></script>
    <script>
        isSubmit= <?php echo $conf['isSubmit']; ?>;
    </script>
    <!-- userflow-->
    <script src="../src/dist/js/all_form_freetrial.min.js"></script>
</head>
<body class="page-home">
<div id="orientLayer" class="mod-orient-layer">
    <div class="mod-orient-layer__content">
        <i class="icon mod-orient-layer__icon-orient"></i>
        <div class="mod-orient-layer__desc">请在解锁模式下使用竖屏浏览</div>
    </div>
</div>
<div class="preload">
    <div class="animate-flower">
        <!--<img src="../src/dist/images/preload-flower.jpg" alt="kenzo"/>-->
    </div>
    <div class="loading-num">
        ...<span class="num">10</span>%
    </div>
</div>
<!--main content-->
<!-- 已关注 -->
<div class="wrapper animate">
    <!-- sometimes z-index is larger than border-frame, sometimes is lower-->

    <!-- z-index is middle-->
    <div class="border-frame">
        <div class="bf bf-1"></div>
        <div class="bf bf-2"></div>
        <div class="bf bf-3"></div>
    </div>
    <div class="foreground">
        <div class="fb-flower fb-1">
            <img src="../src/dist/images/flower-bottom-2.png" alt="kenzo"/>
        </div>
        <div class="fb-flower fb-2">
            <img src="../src/dist/images/flower-bottom-1.png" alt="kenzo"/>
        </div>
    </div>
    <div class="logo">
        <img src="../src/dist/images/logo.png" alt="kenzo"/>
    </div>
    <!-- z-index is low-->
    <div class="container">
        <!-- 填写表单选项-->
        <div class="pin pin-2" id="pin-fillform">
            <h3 class="title">
                *请确认您的邮寄信息填写无误<br>
                以便我们为您更快寄出产品
            </h3>
            <form id="form-contact">
                <div class="form-information">
                    <div class="input-box input-box-name">
                        <input type="text" id="input-name" placeholder="姓名"/>
                    </div>
                    <div class="input-box input-box-mobile">
                        <input type="tel" maxlength="11" id="input-mobile" placeholder="电话"/>
                    </div>
                    <div class="input-box input-box-validate-code">
                        <input type="text" id="input-validate-code" placeholder="输入验证码"/>
                        <div class="validate-code">
                            <span class="validate-code-img"></span>
                            <span class="code-text">看不清楚？换张图片</span>
                        </div>
                    </div>
                    <div class="input-box input-box-validate-message-code">
                        <input type="text" id="input-validate-message-code" placeholder="输入短信验证码"/>
                        <div class="btn btn-get-msg-code">
                            <div class="tt">获取验证码<span class="second">(60s)</span></div>
                        </div>
                    </div>
                    <div class="input-box input-box-province select-box">
                        <input type="text" id="input-text-province" placeholder="省份"/>
                        <select name="province" id="select-province">
                            <option value="">省份</option>
                        </select>
                    </div>
                    <div class="input-box input-box-city-district">
                        <div class="select-box">
                            <input type="text" id="input-text-city" placeholder="城市"/>
                            <select name="city" id="select-city">
                                <option value="">城市</option>
                            </select>
                        </div>
                        <div class="select-box">
                            <input type="text" id="input-text-district" placeholder="区县"/>
                            <select name="district" id="select-district">
                                <option value="">区县</option>
                            </select>
                        </div>
                    </div>
                    <div class="input-box input-box-address">
                        <input type="text" id="input-address" placeholder="详细地址"/>
                    </div>
                </div>
                <div class="btn btn-submit">
                    <span class="tt">提 交</span>
                </div>
            </form>
        </div>
        <!-- 抽奖结果显示 -->
        <div class="pin pin-3" id="pin-result">
            <div class="v-content">
                <h3 class="title">「提交成功」</h3>
                <div class="des">
                    Miss K将会在30个工作日内将产品寄出<br>
                    请耐心等待哦~
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>

