<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>管理员日志</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="div_head">
        日志管理
        <span class="span">总计：<?php echo ($count); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                管理员：<input type="text" name='username' style="width: 100px"  value="<?php echo ($get['username']?$get['username']:''); ?>" />
                <input style="font-size: 11px" value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/AdminLog/index",array('pid'=>$get['pid']));?>')"/>
                <input  style="font-size: 11px" value="清空" type="reset" id="btn"/>
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
                <th width="5%">管理员</th>
                <th width="4%">身份</th>
                <th width="5%">添加时间</th>
                <th width="5%">编辑时间</th>
                <th width="5%">最后登录时间</th>
                <th width="3%">lastip</th>
                <th width="2%">登录次数</th>
            </tr>
            <?php if(is_array($adminLog)): $k = 0; $__LIST__ = $adminLog;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td>
                        <div style="display:inline-block;width: 70px; "><?php echo ($v["username"]); ?></div>
                        <a style="color:rgb(121,199,249);text-decoration: none;" href="<?php echo U('Admin/AdminLog/admin_log_detail');?>?uid=<?php echo ($v['id']); ?>&t=0&pid=<?php echo ($get['pid']); ?>&pp=<?php echo ($get['p']); ?>">查看日志</a>
                        <a style="color:rgb(121,199,249);text-decoration: none;" href="<?php echo U('Admin/AdminLog/admin_log_detail');?>?uid=<?php echo ($v['id']); ?>&t=1&pid=<?php echo ($get['pid']); ?>&pp=<?php echo ($get['p']); ?>">订单日志</a>
                    </td>
                    <?php if($v["permissions"] == 1): ?><td>超级管理员</td>
                        <?php else: ?>
                        <td>普通管理员</td><?php endif; ?>
                    <td><?php echo date('Y-m-d H:i:s',$v['addtime']);?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['edittime']);?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['lastlogin']);?></td>
                    <td><?php echo ($v['lastip']); ?></td>
                    <td><?php echo ($v['login_num']); ?></td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>