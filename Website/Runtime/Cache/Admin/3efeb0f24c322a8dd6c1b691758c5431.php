<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>菜单列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
    <style>
        .table_a td,th{padding-bottom: 0;padding-top: 0;text-align: left}
        .table_a th{text-align: center}
    </style>
</head>
<body>
    <div class="div_head">
        菜单列表
        <?php if($get['add_nav'] != '0'): ?><a style="text-decoration: none;color:#fa7124;" href="<?php echo U($get['add_nav'],array('ppid'=>$get['pid']));?>">【菜单添加】</a>
            <?php else: ?>
            <a style="text-decoration: none;color:#fa7124;" href="javascript:alert('暂无权限')">【菜单添加】</a><?php endif; ?>
    </div>
    <div style="margin: 10px 5px;">
    <table class="table_a" width="100%">
        <thead>
        <tr style="background-color:rgb(19, 181, 177)">
            <th>排序</th>
            <th>菜单名</th>
            <th>链接</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
            <?php if(is_array($navList)): $i = 0; $__LIST__ = $navList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($i % 2 );++$i;?><tr style="color: #323232">
                    <td style="width: 80px;">
                        <input type="text" id="pri<?php echo ($value["id"]); ?>" value="<?php echo ($value["priority"]); ?>" onchange="setPriority(this,<?php echo ($value["id"]); ?>)"  style="height:30px;width: 40px;padding-left: 10px"/>
                    </td>
                    <td><?php echo str_repeat('&nbsp;',12*($value['level']-1));?>|--<?php echo ($value["navname"]); ?></td>
                    <td><?php echo ($value["navurl"]); ?></td>
                    <td>
                        <a href="<?php echo U('add_nav',array('pid'=>$value['id'],'pname'=>$value['navname'],'ppid'=>$get['pid']));?>" class="tablelink">添加子菜单</a>&nbsp;&nbsp;
                        <a href="<?php echo U('edit',array('id'=>$value['id'],'pid'=>$get['pid']));?>" class="tablelink">编辑</a>&nbsp;&nbsp;
                        <a href="#" id="<?php echo ($value['id']); ?>" pid="<?php echo ($get['pid']); ?>"  class="tablelink del">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
</div>
</body>
</html>
<script>
    //删除
    $('.del').click(function(){
        var id=$(this).attr('id');
        var pid=$(this).attr('pid');
        $.post("<?php echo U('del');?>",{id:id,pid:pid},function(res){
            if(res.status==1){
                layer.msg(res.info,{icon:6},function(){
                    location.href=res.url;
                })
            }else{
                layer.msg(res.info,{icon:5},function(){
                    location.href=res.url;
                });
            }
        })
    });
    //更改排序
    function setPriority(nav,id){
        var priority=$(nav).val();
        $.post("<?php echo U('setPriority');?>",{'priority':priority,'id':id},function(res){
            if(res.status==1){
                layer.tips(res.info, '#pri'+id, {
                    tips: [2, '#3EAFE0']
                });
            }
        })
    }
</script>