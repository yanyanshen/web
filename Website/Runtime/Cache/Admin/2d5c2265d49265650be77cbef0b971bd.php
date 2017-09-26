<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>权限列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
    <style>
        #page a,#page span{display: inline-block; width:15px;height:15px ;padding: 5px;margin: 2px;text-decoration: none;
            text-align: center; line-height: 15px;background: #f0ead8; color:#000000;  border: 1px solid #c2d2d7; }
        #page a:hover{background:#F27602;color:#FF0000;}
        #page span{ background:#F27602; color:#FF0000; font-weight: bold;}
        .table_a td,th{border:1px solid rgba(39, 164, 237, 0.22);font-size: 13px;}
        .table_a  td{  border: dotted 1px rgba(39, 164, 237, 0.22);}
    </style>
</head>
<body>
    <div class="div_head" style="background-color: rgb(129, 191, 249);">
        <span>
            <span style="float: left;font-weight: bolder;color: #ffffff">权限列表</span>
            <span style=" margin-right: 8px; font-weight: bold;color: #ffffff">
                <a style="text-decoration: none;color:#ff143f;font-size: 15px" href="<?php echo U('Admin/AuthRule/add_rule');?>">【添加权限】</a>
            </span>
        </span>
    </div>
    <div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" style="border:1px solid rgba(119, 163, 218, 0.79)" width="100%">
        <thead>
        <tr style="height:35px;color:#ffffff;font-weight: bold;background-color:  rgb(129, 191, 249);">
            <th>权限名称</th>
            <th>权限规则</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(is_array($ruleList)): $i = 0; $__LIST__ = $ruleList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><tr>
                <td><?php echo str_repeat('&nbsp;',12*($value['level']-1));?>|--<?php echo ($value["title"]); ?></td>
                <td><?php echo ($value["name"]); ?></td>
                <td>
                    <a href="<?php echo U('add_rule',array('pid'=>$value['id'],'pname'=>$value['title']));?>" class="tablelink">添加子权限</a> |
                    <a href="<?php echo U('edit',array('id'=>$value['id']));?>" class="tablelink">编辑</a> |
                    <a href="#" class="tablelink del" id="<?php echo ($value['id']); ?>">删除</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<script>
    $('.del').click(function(){
        var id=$(this).attr('id');
        $.post("<?php echo U('AuthRule/del');?>",{id:id},function(res){
            if(res.status==1){
                layer.msg('删除成功',{icon:6,time:2000},function(){
                    location="<?php echo U('AuthRule/index');?>";
                })
            }else{
                layer.msg('删除失败',{icon:5,time:2000},function(){
                    location="<?php echo U('AuthRule/index');?>";
                })
            }
        })
    })
</script>