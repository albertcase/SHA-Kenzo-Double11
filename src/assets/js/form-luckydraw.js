/*For join page
 * Inclue two function, one is load new qr for each person, another is show rule popup
 * */
;(function(){
    var controller = function(){
        //get userflow status from backend

        //var userInfo = {
        //    isOld: false, /*是否是老用户*/
        //    isSubmit: false, /*是否提交了用户详细信息表单*/
        //    isGift: false, /*是否领取了小样*/
        //    isLuckyDraw: false /*是否抽奖*/
        //};

        this.user = userInfo;
        this.isTransformedOld = userInfo.isOld; //For new follow user, if operate the gift page, then transform Old user and display old page view
        this.disableClick = false;
    };
    //init
    controller.prototype.init = function(){
        var self = this;

        var timeStart = 0,
            step= 1,
            isTrueNext = false,
            isFalseNext = false;
        var loadingAni = setInterval(function(){
            if(timeStart>100){
                isFalseNext = true;
                if(isTrueNext){
                    self.startUp();
                }
                clearInterval(loadingAni);
                return;
            };
            if(timeStart==step){
                $('.animate-flower').addClass('fadenow');
            }
            $('.loading-num .num').html(timeStart);
            timeStart += step;
        },50);

        var baseurl = ''+'/src/dist/images/';
        var imagesArray = [
            baseurl + 'preload-flower.jpg',
            baseurl + 'preload-bg.jpg',
            baseurl + 'logo.png',
            baseurl + 'ani-1.png',
            baseurl + 'ani-2.png',
            baseurl + 'ani-3.png',
            baseurl + 'ani-5.png',
            baseurl + 'bg.jpg',
            baseurl + 'btn.png',
            baseurl + 'tag-new.png',
            baseurl + 'f-1.png',
            baseurl + 'fleurs-2.png',
            baseurl + 'fleurs.png',
            baseurl + 'foreground-1.png',
            baseurl + 'gift-flower.png',
            baseurl + 'guide-share.png',
            baseurl + 'landing-1.png',
            baseurl + 'pop-bg.png',
            baseurl + 'text.png'
        ];

        var i = 0,j= 0;
        new preLoader(imagesArray, {
            onProgress: function(){
                i++;
                //var progress = parseInt(i/imagesArray.length*100);
                //console.log(progress);
                //$('.preload .v-content').html(''+progress+'%');
                //console.log(i+'i');
            },
            onComplete: function(){
                isTrueNext  = true;
                if(isFalseNext){
                    self.startUp();
                }

            }
        });


    };

    controller.prototype.startUp = function(){
        var self = this;
        $('.preload').remove();
        $('.wrapper').addClass('fade');

        /* if the isOld is true and isLuckyDraw is true, directly go to the luckydraw result page */
        if(self.user.isOld && self.user.isLuckyDraw && self.user.isSubmit){
            Common.gotoPin(2); /*directly go to the luckydraw result page*/
            $('#pin-result .prize-item').html('<h3 class="title">「恭喜您」</h3>KENZO果冻霜正装（50ML）一份<br> Miss K 将火速为您寄送礼品！<span class="tip">（每个微信ID仅限中奖一次）</span>');
            $('.btn-getbigprize').addClass('hide');
        }else{
            Common.gotoPin(0); // landing page
            if(self.user.isOld){
                self.showLandingPage(2);
            }else{
                self.showLandingPage(1);
            }
        }
        //if(self.user.isOld){
        //    if(self.user.isLuckyDraw){
        //        Common.gotoPin(2);
        //    }else{
        //        Common.gotoPin(0);
        //    }
        //}

        //console.log(self.hasShared);
        self.bindEvent();
        self.showAllProvince();

        //test
        //Common.hashRoute();
        //self.gotoFormPage();
    };

    //bind Events
    controller.prototype.bindEvent = function(){
        var self = this;
        //show and hide terms pop
        //close terms popup
        $('body').on('touchstart','.btn-close',function(){
            $('.terms-pop').removeClass('show');
        });
        //    show terms pop
        $('.terms-link').on('touchstart',function(){
            /**/
            var termContent = [
                {
                    time:'2017年8月15日到2017年8月19日',
                    condition:'活动期间，首次关注KenzoParfums凯卓官方微信的用户即可参与申领，每个微信ID仅限申领一次，奖品共5000份。活动期间，每日上午10点起限量申领，每日份额详见活动主页（先到先得）',
                    prize:'奖品为KENZO舒缓白莲清爽保湿霜体验装（2ml）<br>根据用户填写的邮寄地址在中奖后的30个工作日内寄送'
                },
                {
                    time:'2017年8月15日到2017年8月19日',
                    condition:'活动期间，关注KenzoParfums凯卓官方微信的用户将活动分享给好友，即可参与抽奖（随机抽取）。每个微信ID仅限中奖一次，奖品限量100份。中奖名单将于活动结束后公布。',
                    prize:'奖品为KENZO舒缓白莲清爽保湿霜正装（50ml）<br>根据用户填写的邮寄地址在中奖后的30个工作日内寄送'
                }
            ];
            if(self.isTransformedOld){
                $('.activity-time').html(termContent[1].time);
                $('.activity-requirement').html(termContent[1].condition);
                $('.activity-prize').html(termContent[1].prize);
            }else{
                $('.activity-time').html(termContent[0].time);
                $('.activity-requirement').html(termContent[0].condition);
                $('.activity-prize').html(termContent[0].prize);
            }
            $('.terms-pop').addClass('show');

        });

        /*
         * If isTransformedOld is true, show share popup
         * If isTransformedOld is false and not fill form, you need fill form first
         * If isTransformedOld is false and filled form, you directly go result page
         * */
        $('.btn-luckydraw').on('touchstart',function(){
            if(self.isTransformedOld){
                $('.share-popup').addClass('show');
            }else{
                //if(self.user.isSubmit){
                //
                //}else{
                //    self.gotoFormPage();
                //}
                self.callGiftApi(); //go result page
            }
        });

        /*
         * submit the form
         * if isTransformedOld is true, submit it and then call lottery api
         * if isTransformedOld is false, submit it and then call gift api
         * */
        $('.btn-submit').on('touchstart',function(){
            if(self.validateForm()){
                //name mobile province city area address
                var inputNameVal = $('#input-name').val(),
                    inputMobileVal = $('#input-mobile').val(),
                    inputAddressVal = $('#input-address').val(),
                    inputMsgCodeVal = $('#input-validate-message-code').val(),
                    selectProvinceVal = $('#select-province').val(),
                    selectCityVal = $('#select-city').val(),
                    selectDistrictVal = $('#select-district').val();
                Api.submitForm({
                    name:inputNameVal,
                    mobile:inputMobileVal,
                    province:selectProvinceVal,
                    city:selectCityVal,
                    msgCode:inputMsgCodeVal,
                    area:selectDistrictVal,
                    address:inputAddressVal
                },function(data){
                    if(data.status==1){
                        self.user.isSubmit = data.userStatus.issubmit;
                        if(self.isTransformedOld){
                            //Call lottery
                            self.callLotteryApi();
                        }else{
                            //Call gift
                            Common.gotoPin(2);
                        }
                    }else{
                        Common.alertBox.add(data.msg);
                    }
                });
            }

        });

        //    switch the province
        var curProvinceIndex = 0;
        $('#select-province').on('change',function(){
            curProvinceIndex = document.getElementById('select-province').selectedIndex;
            self.showCity(curProvinceIndex);
        });

        $('#select-city').on('change',function(){
            var curCityIndex = document.getElementById('select-city').selectedIndex;
            self.showDistrict(curProvinceIndex,curCityIndex);
        });

        $('#select-district').on('change',function(){
            var districtInputEle = $('#input-text-district'),
                districtSelectEle = $('#select-district');
            var curCityIndex = document.getElementById('select-district').selectedIndex;
            districtInputEle.val(districtSelectEle.val());
        });


        //    share function
        weixinshare({
            title1: 'KENZO 关注有礼  | 全新果冻霜，夏日清爽礼赠',
            des: 'KENZO白莲果冻霜，让你清爽一夏~',
            link: window.location.origin,
            img: window.location.origin+'/src/dist/images/share.jpg'
        },function(){
            self.shareSuccess();

        });

        //    imitate share function on pc====test
        //    $('.share-popup .guide-share').on('touchstart',function(){
        //        self.shareSuccess();
        //    });

        //switch validate code
        $('.validate-code').on('touchstart', function(){
            self.getValidateCode();
        });

        /*
         * validate phonenumber first
         * Get message validate code,check image validate code
         * if image validate code is right
         * */
        $('.btn-get-msg-code').on('touchstart', function(){
            if(self.disableClick) return;
            if(!$('#input-mobile').val()){
                Common.errorMsgBox.add('手机号码不能为空');
            }else{
                var reg=/^1\d{10}$/;
                if(!(reg.test($('#input-mobile').val()))){
                    validate = false;
                    Common.errorMsgBox.add('手机号格式错误，请重新输入');
                }else{
                    if(!$('#input-validate-code').val()){
                        Common.alertBox.add('你的验证码不能为空');
                        return;
                    }
                    Api.checkImgValidateCode({
                        picture:$('#input-validate-code').val()
                    },function(data){
                        if(data.status == 1){
                            //start to count down and sent message to your phone
                            Api.sendMsgValidateCode({
                                mobile:$('#input-mobile').val()
                            },function(json){
                                if(json.status==1){
                                    //console.log('开始倒计时');
                                    self.countDown();
                                    self.disableClick = true;
                                }else{
                                    Common.alertBox.add(json.msg);
                                }
                            });
                        }else{
                            Common.alertBox.add('验证码输入错误，请重新输入');
                            self.getValidateCode();
                        }
                    });
                }
            }

        });

        /*If the user get the gift, then go to the lottery page*/
        $('.btn-getbigprize').on('touchstart', function(){
            self.isTransformedOld = 1;
            if(self.user.isLuckyDraw){
                Common.gotoPin(2); /*directly go to the luckydraw result page*/
                $('#pin-result .prize-item').html('<h3 class="title">「恭喜您」</h3>KENZO果冻霜正装（50ML）一份<br> Miss K 将火速为您寄送礼品！<span class="tip">（每个微信ID仅限中奖一次）</span>');
                $('.btn-getbigprize').addClass('hide');
            }else{
                self.showLandingPage(2);
            }

        });

        /*
         * For share tips overlay,click will disappear
         * */
        $('.share-popup').on('touchstart', function(e){
            if(e.target.className.indexOf('.share-popup')){
                $('.share-popup').removeClass('show');
            }
        });

    };

    controller.prototype.showLandingPage = function(page){
        Common.gotoPin(0);
        if(page == 1){
            $('.btn-luckydraw').text('即刻领取体验装');
            $('.limit-quantity').removeClass('hide');
        }else if(page == 2){
            $('.btn-luckydraw').text('即刻赢取礼赠');
            $('.limit-quantity').addClass('hide');
        }
    };
    /*
     * Countdown
     * Disabled click the button untill the end the countdown
     * */
    controller.prototype.countDown = function(){
        var self = this;
        self.disableClick = true;
        $('.btn-get-msg-code').addClass('disabled');
        var maxSeconds = 60;
        var ele = $('.btn-get-msg-code .second');
        var aaa = setInterval(function(){
            maxSeconds--;
            ele.text('('+maxSeconds+'s'+')');
            if(maxSeconds<1){
                self.disableClick = false;
                ele.text('');
                $('.btn-get-msg-code').removeClass('disabled');
                clearInterval(aaa);
            }
        },1000);
    };

    //call gift api and show different view
    controller.prototype.callGiftApi = function(){
        var self = this;
        var resultHtmlObj = [
            {
                name:'小样领取成功',
                rhtml:'<h3 class="title">「恭喜您」</h3>获得KENZO果冻霜* 体验装（2ml）一份<br> Miss K 将火速为您寄送礼品！<span class="tip">（每个微信ID仅限申领一次）</span>'
            },
            {
                name:'今天小样已经领取完毕，请明天再来',
                rhtml:'<h3 class="title">「很遗憾」</h3>小伙伴们手速太快，就像龙卷风<br>今日体验装份额已全部申领完毕！<br>没申领到的小伙伴别心急~<br>体验装免费申领将于明天10点准时重启<br>不见不散哦！'
            },
            {
                name:'小样已经全部领空',
                rhtml:'本次体验装申领活动（共5000份）已全部发放完毕！<br>没申领到的小伙伴们别心急~<br>请持续关注KENZO官方微信，更多福利等着你！<br>'
            }
        ];
        Api.getGift(function(json){
            //console.log(json);
            Common.gotoPin(2); //go result page
            self.user.isSubmit = json.userStatus.issubmit;
            switch (json.status){
                case 1:
                    //msg: '小样领取成功'
                    $('#pin-result .prize-item').html(resultHtmlObj[0].rhtml);
                    if(!self.user.isSubmit){
                        self.gotoFormPage();
                    }
                    break;
                case 2:
                    //msg: '今天小样已经领取完毕，请明天再来。',
                    $('#pin-result .prize-item').html(resultHtmlObj[1].rhtml);
                    break;
                case 3:
                    //msg: '小样已经全部领空。',
                    $('#pin-result .prize-item').html(resultHtmlObj[2].rhtml);
                    break;
                case 4:
                    //msg: '对不起，您已经领取过小样！',
                    $('#pin-result .prize-item').html(resultHtmlObj[0].rhtml);
                    if(!self.user.isSubmit){
                        self.gotoFormPage();
                    }
                    break;
                default :
                    Common.gotoPin(0);
                    Common.alertBox.add(json.msg);
            }
        });
    }
    //show the prize result, if prize, show prize msg, if not, show sorry msg
    controller.prototype.callLotteryApi = function(){
        var self = this;
        var resultHtmlObj = [
            {
                name:'',
                rhtml:'<h3 class="title">「恭喜您」</h3>KENZO果冻霜正装（50ML）一份<br> Miss K 将火速为您寄送礼品！<span class="tip">（每个微信ID仅限中奖一次）</span>'
            },
            {
                name:'您没有中奖',
                rhtml:'<h3 class="title">「很遗憾」</h3>您没有中奖<br>点击右上角，向好友发出幸运邀请<br>即可获得再一次的抽奖机会哦！'
            },
            {
                name:'小样已经全部领空',
                rhtml:'本次KENZO果冻霜正装（共100份）<br>的抽奖活动已结束<br>请持续关注KENZO官方微信，更多福利等着你！<br>'
            }
        ];

        Api.lottery(function(json){
            Common.gotoPin(2); //go result page
            $('.btn-getbigprize').addClass('hide');
            switch (json.status){
                case 0:
                    //msg: '遗憾未中奖',
                    $('#pin-result .prize-item').html(resultHtmlObj[1].rhtml);
                    break;
                case 1:
                    //msg: '恭喜中奖'
                    $('#pin-result .prize-item').html(resultHtmlObj[0].rhtml);

                    break;
                case 2:
                    //msg: '今天的奖品已经发没，请明天再来！',
                    $('#pin-result .prize-item').html(resultHtmlObj[1].rhtml);
                    break;
                case 3:
                    //msg: '您已获奖',
                    $('#pin-result .prize-item').html(resultHtmlObj[0].rhtml);
                    break;
                default :
                    Common.alertBox.add(json.msg);
            }
        });


    };

    controller.prototype.getValidateCode = function(){
        Api.getImgValidateCode(function(data){
            //console.log(data);
            if(data.status==1){
                $('.validate-code-img').html('<img src="data:image/jpeg;base64,'+data.picture+'" />');
                //var codeImg = new Image();
                //codeImg.onload = function(){
                //
                //}
                //codeImg.src = data.picture;
            }
        });
    };

    controller.prototype.gotoFormPage = function(){
        var self = this;
        Common.gotoPin(1);
        self.getValidateCode();
    }

    //share success
    controller.prototype.shareSuccess = function(){
        var self = this;
        if(self.isTransformedOld){
            $('.share-popup').removeClass('show');
            if(self.user.isSubmit){
                self.callLotteryApi();
            }else{
                self.gotoFormPage();
            }
        }
    };

    //province city and district
    controller.prototype.showAllProvince = function(){
        var self = this;
        //    list all province
        var provinces = '';
        var provinceSelectEle = $('#select-province'),
            provinceInputEle = $('#input-text-province');
        region.forEach(function(item){
            provinces = provinces+'<option value="'+item.name+'">'+item.name+'</option>';
        });
        provinceSelectEle.html(provinces);
        provinceInputEle.val(provinceSelectEle.val());
        self.showCity(0);
        self.showDistrict(0,0);
    };

    controller.prototype.showCity = function(curProvinceId){
        var self = this;
        //    show current cities
        var cities='';
        var provinceSelectEle = $('#select-province'),
            provinceInputEle = $('#input-text-province'),
            citySelectEle = $('#select-city'),
            cityInputEle = $('#input-text-city');
        var cityJson = region[curProvinceId].city;
        cityJson.forEach(function(item,index){
            cities = cities + '<option data-id="'+index+'" value="'+item.name+'">'+item.name+'</option>';
        });
        citySelectEle.html(cities);
        provinceInputEle.val(provinceSelectEle.val());
        cityInputEle.val(citySelectEle.val());
        self.showDistrict(curProvinceId,0);
    };

    controller.prototype.showDistrict = function(curProvinceId,curCityId){
        var self = this;
        var districtSelectEle = $('#select-district'),
            districtInputEle = $('#input-text-district'),
            citySelectEle = $('#select-city'),
            cityInputEle = $('#input-text-city');
        //    show current districts
        var districts = '';
        var districtJson = region[curProvinceId].city[curCityId].area;
        districtJson.forEach(function(item,index){
            districts = districts + '<option data-id="'+index+'" value="'+item+'">'+item+'</option>';
        });
        cityInputEle.val(citySelectEle.val());
        districtSelectEle.html(districts);
        districtInputEle.val(districtSelectEle.val());
    };

    //validation the form
    controller.prototype.validateForm = function(){
        var self = this;
        var validate = true,
            inputName = document.getElementById('input-name'),
            inputMobile = document.getElementById('input-mobile'),
            inputAddress = document.getElementById('input-address'),
            selectProvince = document.getElementById('select-province'),
            selectCity = document.getElementById('select-city'),
            selectDistrict = document.getElementById('select-district');

        if(!inputName.value){
            Common.errorMsgBox.add('请填写姓名');
            validate = false;
        };

        if(!inputMobile.value){
            Common.errorMsgBox.add('手机号码不能为空');
            //Common.errorMsg.add(inputMobile.parentElement,'手机号码不能为空');
            validate = false;
        }else{
            var reg=/^1\d{10}$/;
            if(!(reg.test(inputMobile.value))){
                validate = false;
                Common.errorMsgBox.add('手机号格式错误，请重新输入');
                //Common.errorMsg.add(inputMobile.parentElement,'手机号格式错误，请重新输入');
            }else{
                //Common.errorMsg.remove(inputMobile.parentElement);
            }
        }

        if(!selectProvince.value || selectProvince.value == '省份'){
            //Common.errorMsg.add(selectProvince.parentElement,'请选择省份');
            Common.errorMsgBox.add('请选择省份');
            validate = false;
        }else{
            //Common.errorMsg.remove(selectProvince.parentElement);
        };

        if(!selectCity.value || selectCity.value == '城市' || !selectDistrict.value || selectDistrict.value == '区县' ){
            //Common.errorMsg.add(selectCity.parentElement.parentElement,'请选择城市和区县');
            Common.errorMsgBox.add('请选择城市和区县');
            validate = false;
        }else{
            //Common.errorMsg.remove(selectCity.parentElement);
        };

        if(!inputAddress.value){
            //Common.errorMsg.add(inputAddress.parentElement,'请填写地址');
            Common.errorMsgBox.add('请填写地址');
            validate = false;
        }else{
            //Common.errorMsg.remove(inputAddress.parentElement);
        };

        if(validate){
            return true;
        }
        return false;
    };


    $(document).ready(function(){
//    show form
        var newFollow = new controller();
        newFollow.startUp();

    });

})();