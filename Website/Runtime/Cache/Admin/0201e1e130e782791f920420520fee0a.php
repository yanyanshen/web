<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>订单统计报表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="div_head">
        订单统计报表
    </div>
    <div class="div_search">
        <span>
            <form action="<?php echo U('Admin/Order/order_statistics',array('pid'=>$get['pid']));?>" id='form1' method="get">
                <span>
                    城市：<select name="cityname" id="" style="height: 20px;font-size: 11px;width: 70px">
                        <option value="0">请选择</option>
                        <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$city): $mod = ($i % 2 );++$i;?><option value="<?php echo ($city['id']); ?>" <?php echo ($get['cityname']==$city['id']?'selected':''); ?>><?php echo ($city['cityname']); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </span>
                <span style="margin-left: 15px">
                    时间：<input type="text" style="font-size: 12px" onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['create_time']?$get['create_time']:''); ?>" name="create_time"/>
                        至 <input type="text" style="font-size: 12px"  value="<?php echo ($get['create_time1']?$get['create_time1']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="create_time1"/>
                    <input value="查询" style="font-size: 11px" type="submit"/>
                </span>
            </form>
        </span>
    </div>
    <div style="font-size: 12px; margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr  style="background-color:  rgb(19, 181, 177);">
                <th width="6%">时间</th>
                <th width="6%">下单量</th>
                <th width="6%">成单量</th>
                <th width="6%">成单率</th>
                <th width="6%">结算量</th>
                <th width="6%">结算率</th>
                <th width="6%">支付宝</th>
            </tr>
            <tr>
                <td style="text-align: center"><?php echo ($create_time); ?> ~ <?php echo ($create_time1); ?></td>
                <td><?php echo ($order_statistics['order_num']); ?></td>
                <td><?php echo ($order_statistics['completed_num']); ?></td>
                <td><?php echo ($order_statistics['completed_lv']); ?></td>

                <td><?php echo ($order_statistics['end_num']); ?></td>
                <td><?php echo ($order_statistics['end_lv']); ?></td>
                <td><?php echo ($order_statistics['pay_type']); ?></td>
            </tr>
            <tr style="height: 20px"><td colspan="7"></td></tr>
        <tr style="height: 20px;border: 1px solid rgb(129, 191, 249)">
            <td style="text-align: center">合计：</td>
            <td>下单总数：<?php echo ($order_statistics['order_num']?$order_statistics['order_num']:0); ?></td>
            <td>成单总数：<?php echo ($order_statistics['completed_num']?$order_statistics['completed_num']:0); ?></td>
            <td>成单转化率：<?php echo ($order_statistics['completed_lv']?$order_statistics['completed_lv']:0); ?></td>
            <td>结算总数：<?php echo ($order_statistics['end_num']?$order_statistics['end_num']:0); ?></td>
            <td>结算转化率：<?php echo ($order_statistics['end_lv']?$order_statistics['end_lv']:0); ?></td>
            <td>支付宝支付订单数：<?php echo ($order_statistics['pay_type']?$order_statistics['pay_type']:0); ?></td>
        </tr>
        </tbody>
    </table>
</div>
</body>
</html>