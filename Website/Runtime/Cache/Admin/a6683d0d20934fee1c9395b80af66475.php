<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>退费列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="div_head">
        退费列表
        <span class="span">总计：<?php echo ($arr['count']); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                <div>
                    <span>
                        订单编号：<input type="text" name='ordcode' style="width: 100px"  value="<?php echo ($get['ordcode']?$get['ordcode']:''); ?>" />
                    </span>
                     <span style="padding-left: 5px">订单状态：
                        <select name="orderStatus" style="width: 70px;height: 20px;font-size: 11px;">
                            <option value="0" >全部</option>
                            <option value="1" <?php echo ($get['orderStatus']==1?selected:''); ?>>待处理</option>
                            <option value="2" <?php echo ($get['orderStatus']==2?selected:''); ?>>待回访</option>
                            <option value="3" <?php echo ($get['orderStatus']==3?selected:''); ?>>待结算</option>
                            <option value="4" <?php echo ($get['orderStatus']==4?selected:''); ?>>已完成</option>
                            <option value="5" <?php echo ($get['orderStatus']==5?selected:''); ?>>已取消</option>
                        </select>
                    </span>
                     <span  style="padding-left:5px">订单类型：
                        <select name="order_type" style="width: 75px;height: 20px;font-size: 11px;">
                            <option value="0" >全部</option>
                            <option value="1" <?php echo ($get['order_type']==1?selected:''); ?>>学车需求</option>
                            <option value="2" <?php echo ($get['order_type']==2?selected:''); ?>>在线订单</option>
                            <option value="3" <?php echo ($get['order_type']==3?selected:''); ?>>人工订单</option>
                            <option value="4" <?php echo ($get['order_type']==4?selected:''); ?>>其他类型</option>
                        </select>
                    </span>
                     <span style="padding-left:5px">
                        跟单客服：<input type="text" name="customer" style="width: 75px"  value="<?php echo ($get['customer']?$get['customer']:''); ?>"/>
                    </span>
                    <span style="padding-left:5px">
                        退款时间：<input type="text" style="width: 120px"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['return_fee1']?$get['return_fee1']:''); ?>" name="return_fee1"/>
                        至
                        <input type="text" style="width: 120px" value="<?php echo ($get['return_fee2']?$get['return_fee2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="return_fee2"/>
                    </span>
                     <span style="padding-left:5px">
                        支付时间：<input type="text" style="width: 120px"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['notify_time1']?$get['notify_time1']:''); ?>" name="notify_time1"/>
                        至
                        <input type="text" style="width: 120px" value="<?php echo ($get['notify_time2']?$get['notify_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="notify_time2"/>
                    </span>
                </div>
                <div>
                    <span>
                      驾校简称：<input type="text" name='s_nickname' style="width:100px"  value="<?php echo ($get['s_nickname']?$get['s_nickname']:''); ?>" />
                    </span>
                     <span style="padding-left: 5px">驾照类型：
                         <select name="class_name" style="width: 70px;height: 20px;font-size: 11px;">
                         <option value="0" >全部</option>
                         <option value="C1" <?php echo ($get['class_name']=="C1"?selected:''); ?>>C1</option>
                         <option value="C2" <?php echo ($get['class_name']=="C2"?selected:''); ?>>C2</option>
                         <option value="C3" <?php echo ($get['class_name']=="C3"?selected:''); ?>>C3</option>
                         <option value="C4" <?php echo ($get['class_name']=="C4"?selected:''); ?>>C4</option>
                         <option value="C5" <?php echo ($get['class_name']=="C5"?selected:''); ?>>C5</option>
                         <option value="A1" <?php echo ($get['class_name']=="A1"?selected:''); ?>>A1</option>
                         <option value="A2" <?php echo ($get['class_name']=="A2"?selected:''); ?>>A2</option>
                         <option value="A3" <?php echo ($get['class_name']=="A3"?selected:''); ?>>A3</option>
                         <option value="B1" <?php echo ($get['class_name']=="B1"?selected:''); ?>>B1</option>
                         <option value="A2" <?php echo ($get['class_name']=="A2"?selected:''); ?>>A2</option>
                         <option value="D" <?php echo ($get['class_name']=="D"?selected:''); ?>>D</option>
                     </select>
                    </span>
                    <span style="padding-left:5px">支付方式：
                        <select name="pay_type" style="width: 75px;height: 20px;font-size: 11px;">
                        <option value="0" >全部</option>
                        <option value="1" <?php echo ($get['pay_type']==1?selected:''); ?>>支付宝</option>
                        <option value="2" <?php echo ($get['pay_type']==2?selected:''); ?>>微信</option>
                        <option value="3" <?php echo ($get['pay_type']==3?selected:''); ?>>门店</option>
                        <option value="4" <?php echo ($get['pay_type']==4?selected:''); ?>>快递</option>
                        <option value="5" <?php echo ($get['pay_type']==5?selected:''); ?>>驾校</option>
                    </select>
                    </span>
                   <span style="padding-left:5px">
                         学员姓名：<input type="text" name='truename' style="width: 75px"  value="<?php echo ($get['truename']?$get['truename']:''); ?>"/>
                    </span>
                    <span style="padding-left:5px">
                        下单时间：<input type="text" style="width: 120px"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['create_time1']?$get['create_time1']:''); ?>" name="create_time1"/>
                        至
                        <input type="text" style="width: 120px" value="<?php echo ($get['create_time2']?$get['create_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="create_time2"/>
                    </span>
                    <span style="padding-left:5px">手机号：<input type="text" name='tel' style="width:100px"  value="<?php echo ($get['tel']?$get['tel']:''); ?>"/></span>
                    <span style="padding-left: 5px">
                        <input value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/Finance/return_account",array('pid'=>$get['pid'],'p'=>$get['p']));?>')"/>
                        <input value="导出" type="button" id="button" onclick="submitYouFrom('<?php echo U("Admin/Order/push",array('order_status'=>6));?>')"/>
                    </span>
                </div>
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
                <th width="3%">学生名称</th>
                <th width="3%">联系电话</th>
                <th width="4%">关联订单</th>
                <th width="3%">跟单客服</th>
                <th width="5%">驾校</th>
                <th width="5%">课程</th>
                <th width="3%">基地</th>
                <th width="3%">全包价</th>
                <th width="3%">佣金</th>
                <th width="3%">优惠</th>
                <th width="3%">支付方式</th>
                <th width="3%">应收</th>
                <th width="3%">实收</th>
                <th width="3%">实退</th>
                <th width="5%">退款时间</th>
                <th width="3%">最后更新人</th>
            </tr>
            <?php if(is_array($arr['list'])): $k = 0; $__LIST__ = $arr['list'];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$arr['firstRow']); ?></td>
                    <td><?php echo ($v["name"]); ?></td>
                    <td><?php echo ($v["tel"]); ?></td>
                    <td><?php echo ($v["ordcode"]); ?></td>
                    <td><?php echo ($v["customer"]); ?></td>
                    <td><?php echo ($v["s_nickname"]); ?></td>
                    <td><?php echo ($v["class_name"]); ?></td>
                    <td><?php echo ($v["trname"]); ?></td>
                    <td><?php echo ($v["wholeprice"]); ?></td>
                    <td><?php echo ($v["advanceprice"]); ?></td>
                    <td><?php echo ($v["sale_price"]); ?></td>
                    <td>
                        <?php if($v["pay_type"] == 1): ?>支付宝
                            <?php elseif($v["pay_type"] == 2): ?>微信
                            <?php elseif($v["pay_type"] == 3): ?>门店
                            <?php elseif($v["pay_type"] == 4): ?>快递
                            <?php elseif($v["pay_type"] == 5): ?>驾校<?php endif; ?>
                    </td>
                    <td><?php echo ($v['price']?$v['price']:$v['advanceprice']); ?></td>
                    <td><?php echo ($v["total_fee"]); ?></td>
                    <td><?php echo ($v["return_money"]); ?></td>
                    <td><?php echo ($v["return_fee"]); ?></td>
                    <td><?php echo ($v["lastupdate"]); ?></td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($arr['page']); ?>
    </div>
</div>
</body>
</html>