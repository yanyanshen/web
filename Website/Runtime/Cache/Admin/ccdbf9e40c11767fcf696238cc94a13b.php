<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>管理组列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
</head>
<body>
    <div class="div_head">
        管理组列表
        <a style="text-decoration: none;color:#FA7124;" href="<?php echo U('Admin/AuthGroup/add_group',array('pid'=>$get['pid'],'p'=>$get['p']));?>" >【管理组添加】</a>
    </div>
    <div style="margin: 10px 5px;">
        <table class="table_a" width="100%">
            <tbody>
                <tr style="background-color:  rgb(19, 181, 177);">
                    <th>编号</th>
                    <th>管理组名称</th>
                    <th>成员</th>
                    <th style="width: 400px">操作</th>
                </tr>
                <?php if(is_array($groupList)): $k = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($k % 2 );++$k;?><tr>
                        <td><?php echo ($k); ?></td>
                        <td><?php echo ($value["title"]); ?></td>
                        <td><?php echo ($value["member"]); ?></td>
                        <td>
                            <a href="<?php echo U('add_member',array('gid'=>$value['id'],'pid'=>$get['pid']));?>" class="tablelink">添加组员</a> ｜
                            <a href="<?php echo U('allocaterule',array('gid'=>$value['id'],'member'=>$value['member'],'pid'=>$get['pid']));?>" class="tablelink">分配权限</a> ｜
                            <a href="<?php echo U('add_group',array('id'=>$value['id'],'pid'=>$get['pid']));?>" class="tablelink">编辑</a> ｜
                            <a href="#" id="<?php echo ($value["id"]); ?>" pid="<?php echo ($get['pid']); ?>" class="tablelink del">删除</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
<script>
    $('.del').click(function(){
        var id = $(this).attr('id');
        var pid = $(this).attr('pid');
        $.post("<?php echo U('AuthGroup/del');?>",{id:id,pid:pid},function(res){
            if(res.status==1){
                layer.msg(res.info,{icon:6,time:2000},function(){
                    location=res.url;
                })
            }else{
                layer.msg(res.info,{icon:5,time:2000},function(){
                    location=res.url;
                })
            }
        })
    });
</script>