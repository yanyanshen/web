<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>欢迎登录后台管理系统</title>
    <link href="/Public/website/Admin/ment/css/style.css" rel="stylesheet" type="text/css" />
    <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
    <script src="/Public/public/js/jquery.validate.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
    <style type="text/css">
        input{
            margin-bottom: 8px;
        }
        div.error{
            position: absolute;
            font-size: 14px;
            font-weight: bold;
            color: #FF0000;
        }
        div.ok{
            position: absolute;
            font-size: 14px;
            font-weight: bold;
            color: #38D63B;
        }
        #changePwd{
            cursor: pointer;
        }
    </style>

    <script language="javascript">
        $(function(){
            $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            $(window).resize(function(){
                $('.loginbox').css({'position':'absolute','left':($(window).width()-692)/2});
            });
            var validate=$('#form1').validate({
                rules:{
                    username:{
                        required:true,
                        rangelength:[5,12],
                        remote:{
                            url:"<?php echo U('chkAdmin');?>",
                            type:'post'
                        }
                    },
                    password:{
                        required:true,
                        rangelength:[5,12]
                    },
                    verify:{
                        required:true,
                        remote:{
                            url:"<?php echo U('chkVerify');?>",
                            type:'post'
                        }
                    }
                },
                messages:{
                    username:{
                        required:'用户名不能为空！',
                        rangelength:'用户名长度必须在5到12位之间！',
                        remote:'用户名不存在！'
                    },
                    password:{
                        required:'密码不能为空！',
                        rangelength:'密码长度必须在5到12位之间！'
                    },
                    verify:{
                        required:'验证码不能为空!',
                        remote:'验证码不正确!'
                    }
                },
                success:function(div){
                    div.addClass('ok').text('通过验证')
                },
                validClass:'ok',
                errorElement:'div'
            });
            $(window).keydown(function(event){
                if(event.keyCode==13){
                    $('#form1').submit();
                }
            });
            $('.loginbtn').click(function(){
                $('#form1').submit();
            });
            $('#form1').submit(function(){
                $(this).attr('disabled',true);
                if(validate.form()){
                    $.post("<?php echo U('Admin/Login/login');?>",$('#form1').serialize(),function(res){
                        if(res.status==1){
                            layer.msg('登陆成功',{time:2000,icon:6},function(){
                                window.location.href="<?php echo U('Admin/Index/index');?>";
                            })
                        }else{
                            layer.msg(res.info,{time:2000,icon:5},function() {
                                window.location.href="<?php echo U('Admin/Login/login');?>";
                            })
                        }
                    },'json');
                    return false;
                }
            })
        });
    </script>

</head>

<body style="background-color:rgba(0, 207, 0, 0.16); background-image:url(/Public/website/Admin/ment/images/light.png); background-repeat:no-repeat; background-position:center top; overflow:hidden;" id="body">
<div id="mainBody">
    <div id="cloud1" class="cloud"></div>
    <div id="cloud2" class="cloud"></div>
</div>
<div class="logintop">
    <span>欢迎登录吾要去学车后台管理系统</span>
    <ul>
        <li><a href="<?php echo U('Home/Index/index');?>">回首页</a></li>
        <li><a href="#">帮助</a></li>
        <li><a href="#">关于</a></li>
    </ul>
</div>

<div class="loginbody">
    <span class="systemlogo"></span>
    <div class="loginbox loginbox1">
        <form action="<?php echo U('login');?>" method="post" id="form1">
            <ul>
                <li><input name="username" type="text" class="loginuser" placeholder="用户名" onclick="JavaScript:this.value=''"/></li>
                <li><input name="password" type="password" class="loginpwd" placeholder="密码" onclick="JavaScript:this.value=''"/></li>
                <li class="yzm">
                    <span><input name="verify" type="text" placeholder="验证码" onclick="JavaScript:this.value=''"/></span>
                    <cite><img src="<?php echo U('verify');?>" width="118" height="46" style="cursor:pointer" onclick="this.src='<?php echo U('verify',rand());?>' "/></cite>
                </li>
                <li class="">
                    <input name="" type="button" class="loginbtn" value="登录" />
                    <label><input name="remember" type="checkbox" value="" id="remember"/>记住密码</label>
                    <label><a href="<?php echo U('forgetPwd');?>">忘记密码？</a></label>
                </li>
            </ul>
        </form>
    </div>
</div>
</body>
</html>