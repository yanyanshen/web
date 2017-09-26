<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>管理组列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
    <style>
        .table_a td,th{border:1px solid rgba(39, 164, 237, 0.22);font-size: 13px;}
        .table_a  td{  border: dotted 1px rgba(39, 164, 237, 0.22);}
    </style>
</head>
<body>
    <div class="div_head" style="background-color: rgb(129, 191, 249);">
        <span>
            <span style="float: left;font-weight: bolder;color: #ffffff">管理组列表</span>
            <span style=" margin-right: 8px; font-weight: bold;color: #ffffff">
                <a style="text-decoration: none;color:#ff143f;font-size: 15px" href="<?php echo U('Admin/AuthGroup/add_group');?>">【添加管理组】</a>
            </span>
        </span>
    </div>
    <div style="font-size: 13px; margin: 10px 5px;">
        <table class="table_a" style="border:1px solid rgb(129, 191, 249)" width="100%">
            <tbody>
                <tr style="font-weight: bold;height: 35px;background-color:  rgb(129, 191, 249);color: #ffffff">
                    <th>编号</th>
                    <th>管理组名称</th>
                    <th>成员</th>
                    <th>操作</th>
                </tr>
                <?php if(is_array($groupList)): $k = 0; $__LIST__ = $groupList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$value): $mod = ($k % 2 );++$k;?><tr>
                        <td><?php echo ($k); ?></td>
                        <td><?php echo ($value["title"]); ?></td>
                        <td><?php echo ($value["member"]); ?></td>
                        <td>
                            <a href="<?php echo U('add_member',array('gid'=>$value['id']));?>" class="tablelink">添加组员</a> ｜
                            <a href="<?php echo U('allocateRule',array('gid'=>$value['id'],'member'=>$value['member']));?>" class="tablelink">分配权限</a> ｜
                            <a href="<?php echo U('add_group',array('id'=>$value['id']));?>" class="tablelink">编辑</a> ｜
                            <a href="#" id="<?php echo ($value["id"]); ?>" class="tablelink del">删除</a>
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
        $.post("<?php echo U('AuthGroup/del');?>",{id:id},function(res){
            if(res.status==1){
                layer.msg('删除成功',{icon:6,time:2000},function(){
                    location="<?php echo U('AuthGroup/index');?>";
                })
            }else{
                layer.msg('删除失败',{icon:5,time:2000},function(){
                    location="<?php echo U('AuthGroup/index');?>";
                })
            }
        })
    });
</script>