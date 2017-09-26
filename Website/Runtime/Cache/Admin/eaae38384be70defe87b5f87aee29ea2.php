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
        input{margin-bottom: 6px;}
        lable.error{font-size: 14px;font-weight: bold;color: #FF0000;}
        lable.ok{font-size: 14px;font-weight: bold;color: #38D63B;}
        label{padding: 10px 20px 10px 0}
        li{margin-top: 30px;list-style: none}
        .dfinput{margin-left: 10px;border:solid 2px rgba(39, 183, 243, 0.87);border-radius: 3px;width: 340px;padding: 10px 0 10px 15px}
        b{color: red}
    </style>
</head>
<body>
<div class="div_head" style="background-color: rgb(129, 191, 249);">
    <span>
        <span style="float: left;font-weight: bolder;color: #ffffff">添加菜单</span>
        <span style=" margin-right: 8px; font-weight: bold;color: #ffffff">
            <a style="text-decoration: none;color:#ff143f;font-size: 15px" href="<?php echo U('index');?>">【返回】</a>
        </span>
    </span>
</div>
<div style="font-size: 13px;margin: 10px 5px">
    <form action="<?php echo U('Admin/AdminNav/add_nav');?>" id="form1" method="post">
        <input name="pid" type="hidden" class="dfinput" value="<?php echo ((isset($pid) && ($pid !== ""))?($pid):0); ?>"/>
        <ul>
            <li><label>上级菜单<b>*</b></label>
                <input type="text" class="dfinput" placeholder="<?php echo ((isset($pname) && ($pname !== ""))?($pname):'上级菜单'); ?>"  readonly/>
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
                <label style="padding: 10px 90px 10px 0"></label>
                <input style="width: 137px;height: 35px;line-height: 35px;background-color: rgb(60,149,200);border: none;border-radius: 4px;color: #ffffff " type="submit" class="btn" value="确定"/>
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
                navname:{
                    required:true
                },
                navurl:{
                    required:true
                }
            },
            messages:{
                navname:{required:' * 菜单名称不能为空！'},
                navurl:{required:' * 菜单链接不能为空！'}
            },
            success:function(lable){
                lable.addClass('ok').text(' * 通过验证');
            },
            validClass:'ok',
            errorElement:'lable'
        });
        //异步提交表单
        $('#form1').submit(function(){
            if(validate.form()){
                $.post("<?php echo U('Admin/AdminNav/add_nav');?>",$('#form1').serialize(),function(res){
                if(res.status==1){
                    layer.msg(
                            res.info,
                            {icon:1},
                            function(){
                                location.href=res.url;
                            }
                    );
                }else{
                    layer.msg(res.info);
                }
            });
            return false;
            }
        });
    })
</script>