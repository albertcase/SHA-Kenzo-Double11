<!DOCTYPE html>
<html>
<head lang="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>KENZO全新果冻霜礼赠</title>
    <meta name="msapplication-tap-highlight" content="no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="x5-fullscreen" content="true">
    <meta name="full-screen" content="yes">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no"/>
    <link rel="stylesheet" type="text/css" href="../src/dist/css/style.css?v=2.0"/>
    <script src="http://kenzowechat.samesamechina.com/weixin/jssdkforsite"></script>
    <script>
        var _hmt = _hmt || [];
        (function() {
            var hm = document.createElement("script");
            hm.src = "https://hm.baidu.com/hm.js?f60c5af227048e276b4e4d768cdfb959";
            var s = document.getElementsByTagName("script")[0];
            s.parentNode.insertBefore(hm, s);
        })();
    </script>
    <script type="text/javascript">
        var userInfo = {
            isOld: <?php echo $userStatus['isold'];?>, /*是否是老用户*/
            isSubmit: <?php echo $userStatus['issubmit'];?>, /*是否提交了用户详细信息表单*/
            isGift: <?php echo $userStatus['isgift'];?>, /*是否领取了小样*/
            isLuckyDraw: <?php echo $userStatus['isluckydraw'];?> /*是否抽奖*/
        };
    </script>
    <script src="../src/dist/js/all_followed.min.js?v=2.0"></script>
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
    <div class="logo">
        <img src="../src/dist/images/logo.png" alt="kenzo"/>
    </div>
    <!-- z-index is low-->
    <div class="container">
        <!--加载的第一个页面 landing-->
        <div class="pin pin-1 pin-landing" id="pin-landing-1">
            <div class="title">
                <div class="tag-new">
                    <img src="../src/dist/images/tag-new.png" alt="kenzo"/>
                </div>
                <img src="../src/dist/images/landing-1.png" alt="kenzo"/>
            </div>
            <div class="des-wrap">
                <div class="des des-1">
                    高度锁水滋润，持续哑光控油<br>
                    动人美肌，不见油光，只现水润<br>
                    肌肤舒缓娇嫩，尽显清爽润泽<br>
                    ...身心亦是焕然一新
                </div>
            </div>
            <div class="limit-quantity hide">（今日限量<?php echo $quota;?>份）</div>
            <div class="btn btn-luckydraw">即刻赢取礼赠</div>
            <div class="terms-link">*规则与条款</div>
            <div class="foreground">
                <div class="box">
                    <div class="box-top">
                        <img src="../src/dist/images/ani-2.png" alt="kenzo"/>
                    </div>
                    <div class="box-bottom">
                        <img src="../src/dist/images/ani-3.png" alt="kenzo"/>
                    </div>
                </div>
                <div class="flower">
                    <img src="../src/dist/images/f-1.png" alt="kenzo"/>
                </div>
                <div class="fleurs">
                    <div class="top-flower">
                        <img src="../src/dist/images/fleurs.png" alt="kenzo"/>
                    </div>
                    <div class="bottom-flower">
                        <img src="../src/dist/images/fleurs-2.png" alt="kenzo"/>
                    </div>
                </div>
                <div class="product-name">
                    <img src="../src/dist/images/text.png" alt="kenzo"/>
                </div>
                <!--<img src="../src/dist/images/foreground-1.png" alt="kenzo"/>-->
            </div>
            <div class="ani-petal">
                <img src="../src/dist/images/ani-1.png" alt="kenzo"/>
            </div>
        </div>
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
                            获取验证码<span class="second"></span>
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
                <div class="btn btn-submit">提 交</div>
            </form>
            <div class="foreground">
                <img src="../src/dist/images/foreground-1.png" alt="kenzo"/>
            </div>
        </div>
        <!-- result page-->
        <div class="pin pin-3" id="pin-result">
            <div class="des v-content">
                <div class="prize-item">

                </div>
                <div class="btn btn-getbigprize">
                    <span class="product-name-2">* 果冻霜：KENZO舒缓白莲清爽保湿霜 </span>
                    赢取果冻霜正装<span class="num">(共100份)</span>
                </div>
            </div>
            <div class="b-img">
                <img src="../src/dist/images/gift-flower.png" alt=""/>
            </div>
        </div>
    </div>
</div>
<!--share pop-->
<div class="popup share-popup">
    <div class="guide-share right-star">
        <img src="../src/dist/images/guide-share.png" alt=""/>
    </div>
    <div class="des">
        <span class="bigfont">·向好友传递清爽礼赠·</span>
        即刻获得一次<br>
        KENZO白莲果冻霜正装（50ML）<br>
        抽奖机会
    </div>
</div>

<!-- z-index is high-->
<div class="popup terms-pop">
    <div class="inner">
        <h3 class="title">活动条款</h3>
        <div class="pcontent">
            <h4 class="subtitle">活动时间</h4>
            <p class="des activity-time">
                2017年8月9日至2017年8月13日
            </p>
            <h4 class="subtitle">参与条件</h4>
            <p class="des activity-requirement">
                活动期间，首次关注KenzoParfums凯卓官方微信的<br>
                用户即可参与申领，每个微信ID仅限申领一次，<br>
                奖品限量5000份。每天份额限量，详情请见活动主页<br>
                （先到先得）
            </p>
            <h4 class="subtitle">奖品内容</h4>
            <p class="des activity-prize">
                奖品为KENZO舒缓白莲清爽保湿霜体验装（2ml）<br>
                根据用户填写的邮寄地址在中奖后的30个工作日内寄送
            </p>
            <!--<p class="product-name">* KENZO花颜舒柔夜间修护面膜</p>-->
        </div>
        <div class="btn-close">X</div>
    </div>
</div>
</body>
</html>