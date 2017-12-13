<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>分配权限</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
    <style>
        .table_a  td{ text-align: left;color: #646464}
    </style>
</head>
<body>
<div class="div_head">
    分配权限
</div>
<div style="font-size: 11px; margin: 10px 5px;">
    <form action="<?php echo U('allocateRule');?>" method="post" id="form1">
        <input type="hidden" name='id' value="<?php echo ($_GET['gid']); ?>"/>
        <input type="hidden" name='pid' value="<?php echo ($get['pid']); ?>"/>
        <table class="table_a" width="100%">
        <thead>
            <tr style="background-color:rgb(19, 181, 177);">
                <th colspan="2" style="color: #ffffff;">为 <?php echo ($_GET['member']); ?> 分配权限</th>
            </tr>
        </thead>
        <tbody>
        <?php if(is_array($ruleList)): $i = 0; $__LIST__ = $ruleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i;?><tr class="chkList" style="height: 5px">
                <td width="10%" >
                    <label for="<?php echo ($v1["id"]); ?>"><?php echo ($v1["title"]); ?>
                        <input id="<?php echo ($v1["id"]); ?>" type="checkbox" value="<?php echo ($v1["id"]); ?>" name="rules[]" onclick="checkAll(this)"  <?php echo in_array($v1['id'],$groupInfo['rules'])?"checked":'';?> />
                    </label>
                </td>
                <td>
                    <?php if(!empty($v1["child"])): if(is_array($v1["child"])): $i = 0; $__LIST__ = $v1["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($i % 2 );++$i;?><table width="99%" style="margin: 5px;">
                                <tr class="chkList">
                                    <td width="10%">
                                        <label for="<?php echo ($v2["id"]); ?>"><?php echo ($v2["title"]); ?>
                                            <input id="<?php echo ($v2["id"]); ?>" type="checkbox" value="<?php echo ($v2["id"]); ?>" name="rules[]" onclick="checkAll(this)"  <?php echo in_array($v2['id'],$groupInfo['rules'])?"checked":'';?>  />
                                        </label>
                                    </td>
                                    <td style="border-left: none;height: 20px">
                                        <?php if(!empty($v2["child"])): if(is_array($v2["child"])): $i = 0; $__LIST__ = $v2["child"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v3): $mod = ($i % 2 );++$i;?><label for="<?php echo ($v3["id"]); ?>"><?php echo ($v3["title"]); ?>
                                                    <input id="<?php echo ($v3["id"]); ?>" type="checkbox" value="<?php echo ($v3["id"]); ?>" name="rules[]"  <?php echo in_array($v3['id'],$groupInfo['rules'])?"checked":'';?>  />
                                                </label><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                                    </td>
                                </tr>
                            </table><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <tr>
                <td colspan="2" style="padding:15px;">
                    <input style="width: 137px;height: 35px;line-height: 35px;background-color: rgb(19, 181, 177);border: none;border-radius: 4px;color: #ffffff " type="submit" value="确定分配" class="btn"/>
                </td>
            </tr>
        </tbody>
    </table>
    </form>
</div>
</body>
</html>
<script>
    function checkAll(obj){
        $(obj).parents('.chkList').eq(0).find("input[type='checkbox']").prop('checked',$(obj).prop('checked'))
    }

    $('#form1').submit(function(){
        $.post("<?php echo U('allocateRule');?>",$(this).serialize(),function(res){
            if(res.status==1){
                layer.msg(res.info, {icon:1}, function(){
                    location.href=res.url;
                });
            }else{
                layer.msg(res.info,{icon:5});
            }
        });
        return false;
    })
</script>