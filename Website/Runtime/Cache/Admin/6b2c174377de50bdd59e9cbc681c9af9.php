<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>管理员列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
    <style>
        #page a,#page span{display: inline-block; width:15px;height:15px ;padding: 5px;margin: 2px;text-decoration: none;
            text-align: center; line-height: 15px;background: #f0ead8; color:#000000;  border: 1px solid #c2d2d7; }
        #page a:hover{background:#F27602;color:#FF0000;}
        #page span{ background:#F27602; color:#FF0000; font-weight: bold;}
        #page{ float: right; }
        .table_a td,th{border:1px solid rgba(39, 164, 237, 0.22);font-size: 13px;}
        .table_a td{border: dotted 1px rgba(39, 164, 237, 0.22);font-size: 13px;}
    </style>
</head>
<body>
    <div class="div_head" style="background-color: rgb(129, 191, 249);">
        <span>
            <span style="float: left;font-weight: bolder;color: #ffffff">管理员列表</span>
        </span>
    </div>
    <div class="div_search" style="height: 35px;background-color:  rgb(129, 191, 249)">
        <span style="float:left;color: #ffffff;font-weight: bolder">
            <form action="?" id='form1' method="get" name="form1">
                管理员<input type="text" name='username' style="width: 40%"  value="<?php echo ($username?$username:''); ?>" />
                <input value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/Admin/index");?>')"/>
                <input value="清空全部" type="reset"/>
                <!--<input value="导出" type="button" id="button" onclick="submitYouFrom('http://www.517xc.cn/index.php/Admin/Order/push')"/>-->
                <script type="text/javascript" language="javascript">
                    function submitYouFrom(path){
                        $('#form1').attr('action',path);
                        $('#form1').submit();
                    }
                </script>
            </form>
        </span>
        <span style="float:right">总计：<?php echo ($count); ?>　　</span>
    </div>
    <div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" style="border:1px solid rgb(129, 191, 249)" width="100%">
        <tbody>
            <tr style="font-weight: bold;background-color:  rgb(129, 191, 249);height: 35px;color: #ffffff">
                <th width="2%">编号</th>
                <th width="2%">管理员</th>
                <th width="5%">添加时间</th>
                <th width="5%">编辑时间</th>
                <th width="5%">最近的登录</th>
                <th width="5%">身份</th>
                <th width="5%">所属组</th>
                <th width="5%">登录状态</th>
                <th width="4%">账号状态</th>
                <th width="5%">操作</th>
            </tr>
            <?php if(is_array($adminList)): $k = 0; $__LIST__ = $adminList;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["username"]); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['addtime']);?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['edittime']);?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['lastlogin']);?></td>
                    <?php if($v["permissions"] == 1): ?><td>超级管理员</td>
                        <?php else: ?>
                        <td>普通管理员</td><?php endif; ?>
                    <td><?php echo ($v["group"]); ?></td>
                    <td><?php echo ($v['online']==0?'未登录':'在线'); ?></td>
                    <td><?php echo ($v['status']==0?'禁用':'激活'); ?></td>
                    <td style="text-align: center">
                        <a href="#" id="<?php echo ($v["id"]); ?>" class="status"><?php echo ($v['status']==0?'激活':'禁用'); ?></a>&nbsp;&nbsp;
                        <a href="<?php echo U('edit',array('id'=>$v['id']));?>">编辑</a>&nbsp;&nbsp;
                        <a id="<?php echo ($v["id"]); ?> " class="online" style="cursor: pointer"><?php echo ($v['online']==0?'':'下线'); ?></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page" style="float: left">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>
<script>
    $('.status').click(function(){
        var id=$(this).attr('id');
        $.post("<?php echo U('Admin/operate');?>", {id: id}, function (res) {
            if (res.status == 1) {
                layer.msg('管理员状态操作成功',{icon:6,time:2000},function(){
                    location="<?php echo U('Admin/index');?>";
                });
            } else {
                layer.msg('管理员状态操作失败',{icon:5,time:2000},function(){
                    location="<?php echo U('Admin/index');?>"
                });
            }
        }, 'json');
    });
    $('.online').click(function(){
        var id=$(this).attr('id');
        $.post("<?php echo U('Admin/kick');?>", {id: id}, function (res) {
            if (res.status == 1) {
                layer.msg('管理员登录状态操作成功',{icon:6,time:2000},function(){
                    location="<?php echo U('Admin/index');?>";
                });
            } else {
                layer.msg('管理员登录状态操作失败',{icon:5,time:2000},function(){
                    location="<?php echo U('Admin/index');?>"
                });
            }
        }, 'json')
    })
</script>