<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>管理员列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
</head>
<body>
    <div class="div_head">
       管理员列表
        <span class="span">总计：<?php echo ($count); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                管理员：<input type="text" name='username' style="width: 130px"  value="<?php echo ($get['username']?$get['username']:''); ?>" />
                <input style="font-size: 11px" value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/Admin/index",array('p'=>$get['p'],'pid'=>$get['pid']));?>')"/>
                <input style="font-size: 11px" value="清空全部" type="reset"/>
                <script type="text/javascript" language="javascript">
                    function submitYouFrom(path){
                        $('#form1').attr('action',path);
                        $('#form1').submit();
                    }
                </script>
            </form>
        </span>
    </div>
    <div style="margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr style="background-color:  rgb(19, 181, 177);">
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
                    <td>
                        <a class="tablelink" href="<?php echo U('edit',array('id'=>$v['id'],'p'=>$get['p'],'pid'=>$get['pid']));?>">编辑</a>&nbsp;&nbsp;
                        <a class="tablelink status" href="#" id="<?php echo ($v["id"]); ?>" p="<?php echo ($get['p']); ?>" pid="<?php echo ($get['pid']); ?>"><?php echo ($v['status']==0?'激活':'禁用'); ?></a>&nbsp;&nbsp;
                        <a id="<?php echo ($v["id"]); ?> " class="tablelink online" p="<?php echo ($get['p']); ?>" pid="<?php echo ($get['pid']); ?>"><?php echo ($v['online']==0?'':'下线'); ?></a>
                    </td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>
<script>
    $('.status').click(function(){
        var id=$(this).attr('id');
        var pid=$(this).attr('pid');
        var p=$(this).attr('p');
        $.post("<?php echo U('Admin/operate');?>", {id: id,pid:pid,p:p}, function (res) {
            if (res.status == 1) {
                layer.msg('管理员状态操作成功',{icon:6,time:2000},function(){
                    location=res.url;
                });
            } else {
                layer.msg('管理员状态操作失败',{icon:5,time:2000},function(){
                    location=res.url;
                });
            }
        }, 'json');
    });
    $('.online').click(function(){
        var id=$(this).attr('id');
        var pid=$(this).attr('pid');
        var p=$(this).attr('p');
        $.post("<?php echo U('Admin/kick');?>", {id: id,pid:pid,p:p}, function (res) {
            if (res.status == 1) {
                layer.msg('管理员登录状态操作成功',{icon:6,time:2000},function(){
                    location=res.url;
                });
            } else {
                layer.msg('管理员登录状态操作失败',{icon:5,time:2000},function(){
                    location=res.url
                });
            }
        }, 'json')
    })
</script>