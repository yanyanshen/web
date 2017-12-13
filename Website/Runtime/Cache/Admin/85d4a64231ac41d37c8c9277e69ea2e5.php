<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>订单来源报表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="div_head">
        订单来源报表
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get">
                时间：<input type="text" style="width: 125px;font-size: 12px"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['create_time']?$get['create_time']:''); ?>" name="create_time"/>
                至 <input type="text" style="width: 125px;font-size: 12px" value="<?php echo ($get['create_time1']?$get['create_time1']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="create_time1"/>
                <input value="查询" style="font-size: 11px" type="submit" onclick="submitYouForm('<?php echo U("Admin/Order/order_source",array('pid'=>$get['pid']));?>')"/>
                <input value="上月" style="font-size: 11px" type="submit" onclick="submitYouForm('<?php echo U("Admin/Order/order_source",array('t'=>1,'pid'=>$get['pid']));?>')"/>
                <script>
                    function submitYouForm(path){
                        $("#form1").attr('action',path);
                        $("#form1").submit();
                    }
                </script>
            </form>
        </span>
    </div>
    <div style="margin: 10px 5px;">
    <table class="table_a"  width="100%">
        <tbody>
            <tr style="background-color:  rgb(19, 181, 177);">
                <th width="6%">订单来源</th>
                <th width="6%">下单数</th>
                <th width="6%">成单数</th>
                <th width="6%">成单率</th>
                <th width="6%">结算量</th>
                <th width="6%">结算率</th>
                <th width="6%">取消数</th>
                <th width="6%">取效率</th>
            </tr>
            <?php if(is_array($order_source)): $i = 0; $__LIST__ = $order_source;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                    <td style="text-align: center"><?php echo ($v['name']); ?></td>
                    <td><?php echo ($v['order_num']?$v['order_num']:0); ?></td>
                    <td><?php echo ($v['completed_num']?$v['completed_num']:0); ?></td>
                    <td><?php echo ($v['completed_lv']); ?></td>
                    <td><?php echo ($v['end_num']?$v['end_num']:0); ?></td>
                    <td><?php echo ($v['end_lv']); ?></td>
                    <td><?php echo ($v['cancel_num']?$v['cancel_num']:0); ?></td>
                    <td><?php echo ($v['cancel_lv']); ?></td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        <tr>
            <td style="text-align: center">合计</td>
            <td><?php echo ($data['order_num']?$data['order_num']:0); ?></td>
            <td><?php echo ($data['completed_num']?$data['completed_num']:0); ?></td>
            <td><?php echo ($data['completed_lv']?$data['completed_lv']:0); ?></td>
            <td><?php echo ($data['end_num']?$data['end_num']:0); ?></td>
            <td><?php echo ($data['end_lv']?$data['end_lv']:0); ?></td>
            <td><?php echo ($data['cancel_num']?$data['cancel_num']:0); ?></td>
            <td><?php echo ($data['cancel_lv']?$data['cancel_lv']:0); ?></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>