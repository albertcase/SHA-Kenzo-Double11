/*All the api collection*/
Api = {
    //submit user info
    //{
    //    name: '张三',
    //        tel: '13112345678',
    //    province: '上海',
    //    city: '上海',
    //    area: '黄浦区',
    //    address: '湖滨路'
    //}
    submitForm:function(obj,callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/submit',
            type:'POST',
            dataType:'json',
            data:obj,
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
                //status=1 有库存
            }
        });

        //return callback({
        //    status:0,
        //    msg:'fillform'
        //})


    },

    getGift:function(callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/gift',
            type:'POST',
            dataType:'json',
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'zhognjiang'
        //})


    },
    //抽奖API
    lottery:function(callback){
        Common.msgBox.add('抽奖中...');
        $.ajax({
            url:'/api/lottery',
            type:'POST',
            dataType:'json',
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },

    getImgValidateCode:function(callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/picturecode',
            type:'POST',
            dataType:'json',
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },

    checkImgValidateCode:function(obj,callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/checkpicture',
            type:'POST',
            dataType:'json',
            data:obj,
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },


    //sent message validate code
    //mobile
    sendMsgValidateCode:function(obj,callback){
        Common.msgBox.add('loading...');
        $.ajax({
            url:'/api/phonecode',
            type:'POST',
            dataType:'json',
            data:obj,
            success:function(data){
                Common.msgBox.remove();
                return callback(data);
            }
        });

        //return callback({
        //    status:1,
        //    msg:'提交成功'
        //});


    },


};