<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>添加管理员</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
    <script src="/Public/public/js/jquery.validate.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
    <style>
        lable.error{ font-size: 12px;color: #FA7124;}
        lable.ok{ font-size: 12px;color: #38D63B;}

        label{padding: 10px 20px 10px 0;}
        b{color: #FA7124}
        li{ margin-top: 15px;list-style: none;}

        .dfinput{margin-left: 10px;border:solid 1px  rgb(220, 220, 220);border-radius: 3px;
            width: 340px;padding: 10px 0 10px 5px;background: #ffffff;
        }
    </style>
</head>
<body>
<div class="div_head">
    添加管理员
</div>
<div style="margin: 10px 5px">
    <form action="<?php echo U('Admin/Admin/add_admin');?>" id="form1" method="post">
        <input type="hidden" name="pid" pid="<?php echo ($get['pid']); ?>"/>
        <ul style="margin-left: 10px;padding: 0">
            <li>
                <label style="padding: 10px 30px 10px 0">添加类型<b>*</b></label>
                <select class="dfinput" name="permissions" style="width: 345px">
                    <option value="1">超级管理员</option>
                    <option value="2" selected>普通管理员</option>
                </select>
            </li>
            <li><label style="padding: 10px 30px 10px 0">联系方式<b>*</b></label><input name="mobile" type="text" class="dfinput" placeholder="请填写联系方式" /></li>
            <li><label>管理员账号<b>*</b></label><input name="username" type="text" class="dfinput" placeholder="请填写管理员账号" /></li>
            <li><label>管理员密码<b>*</b></label><input name="password" id="password" type="password" class="dfinput" placeholder="请填写管理员密码" /></li>
            <li><label style="padding: 10px 32px 10px 0">确认密码<b>*</b></label><input name="repwd" type="password" class="dfinput" placeholder="请确认密码" /></li>
            <li>
                <label style="padding: 10px 93px 10px 0"></label>
                <input style="width: 137px;height: 35px;line-height: 35px;background-color:  rgb(19, 181, 177);border: none;border-radius: 4px;color: #ffffff " type="button" class="btn" value="确定"/>
            </li>
        </ul>
    </form>
</div>
</body>
</html>
<script>
    $(function(){
        var validate=$('#form1').validate({
            rules:{username:{required:true, rangelength:[5,12],
                    remote:{url:"<?php echo U('chkUsername');?>", type:'post'}
                },
                password:{required:true, rangelength:[5,12]},
                repwd:{required:true, equalTo:'#password'},
                mobile:{required:true,mobile:true}
            },
            messages:{
                username:{required:' * 必填项！', rangelength:' * 账号长度必须在5到18位之间！', remote:' * 用户名已存在！'},
                password:{required:' * 必填项！', rangelength:' * 密码长度必须在5到18位之间！'},
                repwd:{required:' * 必填项！', equalTo:' * 两次密码输入不一致!'},
                mobile:{required:' * 必填项！'}
            },
            success:function(lable){
                lable.addClass('ok').text(' * ok');
            },
            validClass:'ok',
            errorElement:'lable'
        });
        // 手机号码验证
        jQuery.validator.addMethod("mobile", function(value, element) {
            var mobileReg = /^1[34578]{1}[0-9]{9}$/;
            return this.optional(element) || (mobileReg.test(value));
        }, " * 手机格式错误");
        $('#form1').submit();
        $(window).keydown(function(event){
            if(event.keyCode==13){
                $('#form1').submit();
            }
        });
        $('.btn').click(function(){
            if(validate.form()){
                $.post("<?php echo U('Admin/add_admin');?>",$('#form1').serialize(),function(res){
                    if(res.status){
                        layer.msg(res.info,{time:2000,icon:6},function(){
                            window.location.href=res.url;
                        })
                    }else{
                        layer.msg(res.info,{time:2000,icon:5},function(){
                            window.location.href=res.url;
                        })
                    }
                },'json');
                return false;
            }
        })
    })
</script>