<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>登录</title>
    <link href="/Public/website/Mobile/login/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/login/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/login/css/loginRegister/login.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/login/css/loginRegister/media-queries-login.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
    <script src="/Public/public/js/jquery.form.js"></script>
    <script src="/Public/public/js/jquery.validate.js"></script>
    <style>
        input.error { border: 1px solid #EA5200;background: #ffdbb3;}
        span.error{position: absolute;color:#ff0300;display: block;font-weight: bold;font-size: 14px;}
        span.ok {color: #289628;}
    </style>
<body>
<div class="login_box">
    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/Index/index');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">登录</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <form action="#" method="" id="form1">
                <div class="tell_box">
                    <input id="username" class="tell" type="text" name="username" placeholder="手机号码">
                </div>
                <div class="error_box">
                    <div id="error_box1"></div>
                </div>
                <div class="password_box">
                    <input id="password" class="password" type="password" name="password" placeholder="密码">
                </div>
                <div class="error_box" style="height: 80px;width: 80%;margin-left: 10%">
                    在未注册过账号的情况下，登录的账号与密码
                    <br>均是您下单时的手机号码，登陆后请尽快重置密码
                </div>
                <div class="login_button_box">
                    <div class="lb">
                        <button class="login_button">登录</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="button_box">
        <div class="button">
            <div class="b1" style="">
                <a href="register.html">注册新用?</a>
            </div>
            <div class="b2" style="">
                <a href='<?php echo U("Mobile/User/forgetPassword");?>'>忘记密码?</a>
            </div>
        </div>
    </div>
</div>

<script>


    $(function(){
        //validate表单验证
        var validate=$('#form1').validate({
            //设置验证规则
            rules:{
                username:{
                    required:true,
                    username:true,
                    remote:{url:'<?php echo U("Mobile/Login/checkPhone");?>', type:'post'}
                },
                password:{required:true}
            },


            messages: {
                username: {required: '用户名不能为空', remote:'请正确填写您的手机号'},
                password: {required: '密码不能为空'}
            },
            success: function(span) {
                span.addClass("ok").text('OK');
            },
            validClass:'ok',
            errorElement:'span'
        });
        // 手机号码验证
        jQuery.validator.addMethod("username", function(value, element) {
            var mobileReg = /^1[34578]{1}[0-9]{9}$/;
            return this.optional(element) || (mobileReg.test(value));
        }, "请正确填写您的手机号");


        $('.login_button').click(function(){
            //表单提交之前判断前端验证是否通过，只有通过时才提交表单
            if(validate.form()){
                $(this).attr('disabled',true);
                $.post("<?php echo U('Mobile/Login/login');?>",$('#form1').serialize(),function(res){
                    if(res.status==1){
                        layer.open({
                            content: res.info
                            ,skin: 'msg'
                            ,icon:2
                            ,style: 'background-color:#DAEAD3; font-color:#49EE18; border:none;' //自定风格
                            ,time: 2 //2秒后自动关闭
                            ,end:function(){
                                location.href=res.url;
                            }
                        });
                    }else{
                        layer.open({
                            content: res.info
                            ,skin: 'msg'
                            ,icon:2
                            ,style: 'background-color:white; color:red; border:none;' //自定风格
                            ,time: 2 //2秒后自动关闭
                            ,end:function(){
                                location.href=res.url;
                            }
                        });
                    }
                },'json');
                return false;
            }
        })
    })
</script>
</body>
</html>