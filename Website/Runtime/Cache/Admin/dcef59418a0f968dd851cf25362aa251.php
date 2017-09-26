<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>编辑管理员</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
    <script src="/Public/public/js/jquery.validate.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
    <style>
        label{padding: 10px 20px 10px 0}
        li{ margin-top: 30px;list-style: none}
        .dfinput{margin-left: 10px;
            border:solid 2px rgba(39, 183, 243, 0.87);border-radius: 3px;
            width: 340px;padding: 10px 0 10px 5px}
        b{color: red}
    </style>
</head>
<body>
<div class="div_head">
    <span>
        <span style="float:left;font-weight: bolder">编辑管理员</span>
        <span style="float:right;margin-right: 8px;font-weight: bold">
            <a style="text-decoration: none" href="<?php echo U('index');?>">【返回】</a>
        </span>
    </span>
</div>
<div></div>
<div style="font-size: 13px;margin: 10px 5px">
    <form action="" id="form1" method="post">
        <input type="hidden" value="<?php echo ($adminInfo["id"]); ?>" name="id"/>
        <ul >
            <li>
                <label>所属组<b>*</b></label>
                <div style="width: 320px;display: inline-block;padding-left: 11px">
                    <?php if(is_array($groupList)): $i = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><div style="display: inline-block;margin-left:10px;width: 150px;margin-bottom: 5px">
                            <input type="text" value="<?php echo ($value["title"]); ?>" style="border:none;width: 90px;font-size: 15px" readonly/>
                            <input   style="width:18px;font-size: 17px" name="group_id[]" <?php echo in_array($value['id'],$adminInfo['gid'])?'checked':'';?> id="<?php echo ($value["title"]); ?>" type="checkbox" value="<?php echo ($value["id"]); ?>" class="dfinput"/>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </li>
            <li><label>用户名<b>*</b></label>
                <input name="username" value="<?php echo ($adminInfo["username"]); ?>" type="text" class="dfinput" placeholder="请填写用户名"/>
            </li>
            <li><label>密　码<b>*</b></label>
                <input name="password" type="password" class="dfinput" value="" placeholder="不填写则保持原密码不变"/>
            </li>
            <li>
                <label style="padding: 10px 80px 10px 0"></label>
                <input style="width: 137px;height: 35px;line-height: 35px;background-color: rgb(60,149,200);border: none;border-radius: 4px;color: #ffffff " type="button" class="btn" value="确定"/>
            </li>
        </ul>
    </form>
</div>
</body>
</html>
<script>
    //异步提交表单
    $('.btn').click(function(){
        $.post("<?php echo U('edit');?>",$('#form1').serialize(),function(res){
            if(res.status==1){
                layer.msg(res.info, {icon:1},function(){
                    location=res.url;
                });
            }else{
                layer.msg(res.info);
            }
        });
        return false;
    })
</script>