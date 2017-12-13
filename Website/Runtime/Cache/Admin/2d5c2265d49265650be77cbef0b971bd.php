<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>权限列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
    <style>
        .table_a td{text-align: left}
    </style>
</head>
<body>
    <div class="div_head">
        权限列表
        <?php if(get['add_rule'] == '0'): ?><a style="text-decoration: none;color:#fa7124;" href="javascript:alert('暂无权限')">【权限添加】</a>
            <?php else: ?>
            <a style="text-decoration: none;color:#fa7124;" href="<?php echo U($get['add_rule'],array('ppid'=>$get['pid']));?>">【权限添加】</a><?php endif; ?>
    </div>
    <div style="margin: 10px 5px;">
        <table class="table_a" width="100%">
        <thead>
        <tr style="background-color:  rgb(19, 181, 177);">
            <th>权限名称</th>
            <th>权限规则</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($ruleList)): $i = 0; $__LIST__ = $ruleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><tr style="color: #646464">
                <td><?php echo str_repeat('&nbsp;',12*($value['level']-1));?>|--<?php echo ($value["title"]); ?></td>
                <td><?php echo ($value["name"]); ?></td>
                <td>
                    <a href="<?php echo U('add_rule',array('pid'=>$value['id'],'pname'=>$value['title'],'ppid'=>$get['pid']));?>" class="tablelink">添加子权限</a> |
                    <a href="<?php echo U('edit',array('id'=>$value['id'],'pid'=>$get['pid']));?>" class="tablelink">编辑</a> |
                    <a href="#" class="tablelink del" id="<?php echo ($value['id']); ?>" pid="<?php echo ($get['pid']); ?>">删除</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
    </div>
    <div id="page"><?php echo ($ruleList['page']); ?></div>
</body>
</html>
<script>
    $('.del').click(function(){
        var id=$(this).attr('id');
        var pid=$(this).attr('pid');
        $.post("<?php echo U('AuthRule/del');?>",{id:id,pid:pid},function(res){
            if(res.status==1){
                layer.msg('删除成功',{icon:6,time:2000},function(){
                    location=res.url;
                })
            }else{
                layer.msg('删除失败',{icon:5,time:2000})
            }
        })
    })
</script>