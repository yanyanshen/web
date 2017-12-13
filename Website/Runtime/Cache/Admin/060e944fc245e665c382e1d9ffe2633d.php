<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>用户日志</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <div class="div_head">
        用户日志
        <span class="span">总计：<?php echo ($count); ?></span>
    </div>
    <div class="div_search" >
        <span>
            <form action="?" id='form1' method="get" name="form1">
                姓名：<input type="text" name='username' style="width: 120px"  value="<?php echo ($get['username']?$get['username']:''); ?>" />
                <input style="font-size: 11px" value="查询" type="submit" id="b"  onclick="submitYouFrom('<?php echo U("Admin/UserLog/index",array('pid'=>$get['pid']));?>')"/>
                <input style="font-size: 11px" value="清空" type="reset" id="b" />
                <script type="text/javascript" language="javascript">
                    function submitYouFrom(path){
                        $('#form1').attr('action',path);
                        $('#form1').submit();
                    }
                </script>
            </form>
        </span>
    </div>
    <div style=" margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr style="background-color:  rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="5%">用户名</th>
                <th width="5%">done</th>
                <th width="5%">url</th>
                <th width="5%">添加时间</th>
                <th width="5%">最后登录时间</th>
                <th width="3%">lastip</th>
            </tr>
            <?php if(is_array($UserLog)): $k = 0; $__LIST__ = $UserLog;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["truename"]); ?></td>
                    <td><?php echo ($v["done"]); ?></td>
                    <td><?php echo ($v["url"]); ?></td>
                    <td><?php echo ($v['ntime']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['lasttime']);?></td>
                    <td><?php echo ($v['lastip']); ?></td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>