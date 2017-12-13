<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>添加菜单</title>
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
        li{margin-top: 15px;list-style: none}
        .dfinput{margin-left: 10px;border:solid 1px rgb(220, 220,220);border-radius: 3px;width: 340px;padding: 10px 0 10px 15px;}
        b{color: #FA7124}
    </style>
</head>
<body>
<div class="div_head">
    添加菜单
    <a style="text-decoration: none;color:#FA7124" href="<?php echo ($get['url']); ?>">【返回】</a>
</div>
<div style="margin: 10px 5px">
    <form action="<?php echo U('Admin/AdminNav/add_nav');?>" id="form1" method="post">
        <input name="pid" type="hidden" class="dfinput" value="<?php echo ((isset($get['pid']) && ($get['pid'] !== ""))?($get['pid']):0); ?>"/>
        <input name="ppid" type="hidden" class="dfinput" value="<?php echo ((isset($get['ppid']) && ($get['ppid'] !== ""))?($get['ppid']):0); ?>"/>
        <ul style="padding: 0;margin-left: 10px">
            <li><label>上级菜单<b>*</b></label>
                <input type="text" class="dfinput" value="<?php echo ((isset($get['pname']) && ($get['pname'] !== ""))?($get['pname']):'上级菜单'); ?>" disabled/>
            </li>
            <li><label>菜单名称<b>*</b></label>
                <input name="navname" type="text" class="dfinput" placeholder="请填写菜单名称" />
            </li>
            <li><label>菜单链接<b>*</b></label>
                <input name="navurl"  class="dfinput" placeholder="请填写菜单链接" />
            </li>
            <li><label style="padding: 10px 8px 10px 0">菜单优先级<b>*</b></label>
                <input name="priority" class="dfinput" placeholder="请填写菜单优先级" />
            </li>
            <li>
                <label style="padding: 10px 83px 10px 0"></label>
                <input style="width: 137px;height: 35px;line-height: 35px;background-color: rgb(19, 181, 177);border: none;border-radius: 4px;color: #ffffff " type="submit" class="btn" value="确定"/>
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
                navname:{required:true},
                navurl:{required:true}
            },
            messages:{navname:{required:' * 必填项！'}, navurl:{required:' * 必填项！'}},
            success:function(lable){
                lable.addClass('ok').text(' * ok');
            },
            validClass:'ok',
            errorElement:'lable'
        });
        $("#form1").submit();
        //异步提交表单
        $('#form1').submit(function(){
            if(validate.form()){
                $.post("<?php echo U('Admin/AdminNav/add_nav');?>",$('#form1').serialize(),function(res){
                if(res.status==1){
                    layer.msg(res.info, {icon:6,time:2000}, function(){
                                location.href=res.url;
                            }
                        );
                }else{
                    layer.msg(res.info,{icon:5,time:2000}, function(){
                        location.href=res.url;
                    });
                }
            });
            return false;
            }
        });
    })
</script>