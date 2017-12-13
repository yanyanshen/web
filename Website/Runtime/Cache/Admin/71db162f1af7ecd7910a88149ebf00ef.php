<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>修改密码</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
    <script src="/Public/public/js/jquery.validate.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
    <style>
        lable.error{font-size: 12px;color: #FA7124;}
        lable.ok{font-size: 12px;color: #38D63B;}
        label{padding: 10px 20px 10px 0}
        li{ margin-top: 15px;list-style: none}
        b{color: #FA7124}

        .dfinput{margin-left: 10px;border:solid 1px rgb(220, 220, 220);border-radius: 3px;
            width: 340px;padding: 10px 0 10px 5px;
        }
    </style>
</head>
<body>
<div class="div_head">
    修改密码
</div>
<div style="margin: 10px 5px">
    <form action="<?php echo U('Admin/Admin/set_password');?>" id="form1" method="post">
        <input type="hidden" value="<?php echo ($get['pid']); ?>" name="pid"/>
        <ul style="margin-left: 10px;padding: 0">
            <li>
                <label style="padding: 10px 30px 10px 0">账号类型<b>*</b></label>
                <select style="width: 345px" class="dfinput" name="permissions" disabled>
                    <option value="1" <?php echo ($admin["permissions==1?'selected':''"]); ?>>超级管理员</option>
                    <option value="2"  <?php echo ($admin["permissions==2?'selected':''"]); ?>>普通管理员</option>
                </select>
            </li>
            <li>
                <label style="padding: 10px 30px 10px 0">您的账号<b>*</b></label>
                <input readonly  type="text" class="dfinput" placeholder="<?php echo (session('admin_name')); ?>" />
            </li>
            <li>
                <label style="padding: 10px 30px 10px 0">您的密码<b>*</b></label>
                <input name="password" id="password" type="password" class="dfinput" placeholder="请填写新密码" />
            </li>
            <li>
                <label style="padding: 10px 30px 10px 0">确认密码<b>*</b></label>
                <input name="repwd" type="password" class="dfinput" placeholder="确认新密码" />
            </li>
            <li>
                <label style="padding: 10px 93px 10px 0"></label>
                <input style="width: 137px;height: 35px;line-height: 35px;background-color:  rgb(19, 181, 177);border: none;border-radius: 4px;color: #ffffff " type="submit" class="btn" value="确定"/>
            </li>
        </ul>
    </form>
</div>
</body>
</html>
<script>
    $(function(){
        var validate=$('#form1').validate({
            rules:{
                password:{required:true, rangelength:[5,12]},
                repwd:{required:true, equalTo:'#password'}
            },
            messages:{
                password:{required:' * 必填项！', rangelength:' * 密码长度必须在5到18位之间！'},
                repwd:{required:' * 必填项!', equalTo:' * 两次密码输入不一致!'}
            },
            success:function(lable){
                lable.addClass('ok').text(' * ok');
            },
            validClass:'ok',
            errorElement:'lable'
        });
        $('#form1').submit();
        $('#form1').submit(function(){
            if(validate.form()){
                $.post("<?php echo U('Admin/set_password');?>",$('#form1').serialize(),function(res){
                    if(res.status==1){
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