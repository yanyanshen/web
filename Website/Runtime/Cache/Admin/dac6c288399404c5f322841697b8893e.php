<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>驾校列表</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
        <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
        <script src="/Public/public/js/layer/layer.js"></script>
        <style>
            input{  height: 23px;padding: 3px;margin-top:5px;margin-bottom:5px;line-height: 23px}
        </style>
    </head>
    <body>
    <form action="" method="post" id="form1">
    <div style="height:20px;text-align: right;border:1px solid red">
        <input type="submit" id="submit" value="确认" style="float: right;margin-right: 20px"/>
        <input type="hidden" name="id" value="<?php echo ($id); ?>" id="jl_id"/>
        <input type="hidden" name="pid" value="<?php echo ($get['pid']); ?>" />
        <input type="hidden" name="type" value="<?php echo ($get['type']); ?>" />
        <input type="hidden" value="<?php echo ($get['p']); ?>" name="p"/>
    </div>
        <div style="width: 100%;text-align: center;">
            <?php if(is_array($school)): $i = 0; $__LIST__ = $school;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$school): $mod = ($i % 2 );++$i;?><ul>
                    <li style="list-style: none;float: left;margin-left: 0px;text-align: center;width: 170px">
                        <input type="radio" name="school_id" style="float: left;margin-top:5px" <?php echo ($info['school_id']==$school['id']?checked:''); ?> value="<?php echo ($school["id"]); ?>"/>
                        <p style="float: left;"><?php echo ($school['nickname']); ?></p>
                    </li>
                </ul><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </div>
    </form>
    </body>
</html>

<script>
    $(function(){
        $('#submit').click(function(){
            $(this).attr('disabled',true);
                $.post("<?php echo U('Admin/Coach/edit_school');?>",$('#form1').serialize(),function(res){
                    if(res.status){
                        parent.location=res.url;
                    }
                },'json');
            return false;
        })
    })
</script>