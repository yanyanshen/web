<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>订单日志</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="div_head">
        管理员订单日志(一个月内)<a style="text-decoration: none;color:#FA7124" href="<?php echo ($get['url']); ?>">【返回】</a>
        <span class="span">总计：<?php echo ($count); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                <input type="hidden" name="uid" value="<?php echo ($get['uid']); ?>"/>
                <input type="hidden" name="t" value="<?php echo ($get['t']); ?>"/>
                <input type="hidden" name="p" value="<?php echo ($get['p']); ?>"/>
                <input type="hidden" name="pid" value="<?php echo ($get['pid']); ?>"/>
                时间：<input name="ntime" type="text" style="width: 100px"  onClick="WdatePicker()" value="<?php echo ($get['ntime']?$get['ntime']:''); ?>" />
                至
                <input type="text" style="width: 100px" value="<?php echo ($get['ntime1']?$get['ntime1']:''); ?>"  onClick="WdatePicker()" name="ntime1"/>
                <input value="查询" style="font-size: 11px" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/AdminLog/admin_log_detail");?>' "/>
                <input value="导出" style="font-size: 11px" type="button" id="button" onclick="submitYouFrom('<?php echo U("Admin/AdminLog/push",array('t'=>$get['t']));?>')"/>
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
            <tr style="background-color: rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="2%">ordcode</th>
                <th width="4%">管理员</th>
                <th width="5%">done</th>
                <th width="5%">创建时间</th>
                <th width="3%">loginip</th>
            </tr>
            <?php if(is_array($adminLog)): $k = 0; $__LIST__ = $adminLog;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v['ordcode']); ?></td>
                    <td>
                        <div style="display:inline-block;width: 70px; "><?php echo ($v["username"]); ?></div>
                    </td>
                    <td><?php echo ($v['done']); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['ntime']);?></td>
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