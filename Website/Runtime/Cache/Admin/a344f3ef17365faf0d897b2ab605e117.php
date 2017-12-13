<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>已支付未处理列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="div_head">
        已支付未处理列表
        <span>
            <a class="span1" href="<?php echo U('Admin/Order/pay_list',array('pid'=>16,'p'=>$get['p']));?>"
               style="margin-left:200px;color: #FA7124;display: none">消息中心：<?php echo ($count['count1']); ?>条支付宝支付并未处理</a>
            <a class="span1" href="<?php echo U('Admin/Order/order_list',array('pid'=>16,'p'=>$get['p'],'order_status'=>2));?>"
                style="margin-left:30px;color: #FA7124;display: none"><?php echo ($count['count2']); ?>条待回访</a>
            <a class="span1" style="margin-left:30px;color: #FA7124;display: none" href="<?php echo U('Admin/Order/order_list',array('pid'=>16,'p'=>$get['p'],'order_status'=>3));?>"><?php echo ($count['count3']); ?>条待结算需回访</a>
            <script language="javascript">
                function codefans(){
                    var box=$(".span1");
                    box.show();
                }
                setTimeout("codefans()",1500);//2秒，可以改动
            </script>
        </span>
        <span class="span">总计：<?php echo ($arr['count']); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                <div>
                    <span>
                        驾校简称：<input type="text" name='s_nickname' style="width: 100px"  value="<?php echo ($get['s_nickname']?$get['s_nickname']:''); ?>" />
                    </span>
                    <span style="padding-left:5px">
                        所在城市：<select name="cityname" style="width: 60px;height: 20px;font-size: 12px">
                            <option value="">全部</option>
                            <?php if(is_array($citys)): $i = 0; $__LIST__ = $citys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($get['cityname']==$v['id']?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </span>
                    <span style="padding-left:5px">
                        订单状态：<select name="orderStatus" style="width: 81px;height: 20px;font-size: 12px">
                            <option value="0" >全部</option>
                            <option value="1" <?php echo ($get['orderStatus']==1?selected:''); ?>>待处理</option>
                            <option value="2" <?php echo ($get['orderStatus']==2?selected:''); ?>>待回访</option>
                            <option value="3" <?php echo ($get['orderStatus']==3?selected:''); ?>>待结算</option>
                            <option value="4" <?php echo ($get['orderStatus']==4?selected:''); ?>>已完成</option>
                            <option value="5" <?php echo ($get['orderStatus']==5?selected:''); ?>>已取消</option>
                        </select>
                    </span>
                    <span style="padding-left:5px">手机号：<input type="text" name='tel' style="width:80px"  value="<?php echo ($get['tel']?$get['tel']:''); ?>"/></span>
                    <span style="padding-left:5px">
                       支付方式：<select name="pay_type" style="width: 65px;height: 20px;font-size: 12px">
                            <option value="0" >全部</option>
                            <option value="1" <?php echo ($get['pay_type']==1?selected:''); ?>>支付宝</option>
                            <option value="2" <?php echo ($get['pay_type']==2?selected:''); ?>>微信</option>
                            <option value="3" <?php echo ($get['pay_type']==3?selected:''); ?>>门店</option>
                            <option value="4" <?php echo ($get['pay_type']==4?selected:''); ?>>快递</option>
                            <option value="5" <?php echo ($get['pay_type']==5?selected:''); ?>>驾校</option>
                        </select>
                    </span>
                    <span style="padding-left: 5px">订单编号：<input type="text" name='ordcode' style="width: 100px"  value="<?php echo ($get['ordcode']?$get['ordcode']:''); ?>" /></span>
                    <span style="padding-left: 5px">
                        跟单客服：<input type="text" name="customer" style="width:75px"  value="<?php echo ($get['customer']?$get['customer']:''); ?>"/>
                    </span>
                    <span style="padding-left: 5px">
                        下单时间：<input type="text" style="width: 120px;"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['create_time1']?$get['create_time1']:''); ?>" name="create_time1"/>
                        至
                        <input type="text" style="width: 120px;" value="<?php echo ($get['create_time2']?$get['create_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="create_time2"/>
                    </span>
                </div>
                <div>
                    <span>学车基地：<input type="text" name='trainaddress' style="width: 100px"  value="<?php echo ($get['trainaddress']?$get['trainaddress']:''); ?>"/></span>
                    <span style="padding-left: 5px">
                        驾照类型：<select name="class_name" style="width: 60px;height: 20px;font-size: 12px;">
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
                    <span style="padding-left: 5px">
                        订单类型：<select name="order_type" style="width: 80px;height: 20px;font-size: 12px;">
                         <option value="0" >全部</option>
                         <option value="1" <?php echo ($get['order_type']==1?selected:''); ?>>学车需求</option>
                         <option value="2" <?php echo ($get['order_type']==2?selected:''); ?>>在线订单</option>
                         <option value="3" <?php echo ($get['order_type']==3?selected:''); ?>>人工订单</option>
                         <option value="4" <?php echo ($get['order_type']==4?selected:''); ?>>其他类型</option>
                        </select>
                    </span>
                    <span style="padding-left: 5px">学员名：<input type="text" name='truename' style="width: 80px"  value="<?php echo ($get['truename']?$get['truename']:''); ?>"/></span>
                    <span style="padding-left: 5px">
                        支付时间：<input type="text" style="width: 120px;"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['notify_time1']?$get['notify_time1']:''); ?>" name="notify_time1"/>
                        至
                        <input type="text" style="width: 120px;" value="<?php echo ($get['notify_time2']?$get['notify_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="notify_time2"/>
                    </span>
                     <span style="padding-left: 5px">
                        回访时间：<input type="text" style="width: 120px;"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['return_time1']?$get['return_time1']:''); ?>" name="return_time1"/>
                        至
                        <input type="text" style="width: 120px" value="<?php echo ($get['return_time2']?$get['return_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="return_time2"/>
                    </span>
                     <span style="padding-left: 5px">
                        <input style="font-size: 11px" value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/Order/pay_list",array('pid'=>$get['pid'],'p'=>$get['p']));?>')"/>
                        <input style="font-size: 11px" value="导出" type="button" id="button" onclick="submitYouFrom('<?php echo U("Admin/Order/push",array('status'=>2,'order_status'=>1));?>')"/>
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
            <tr style="background-color: rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="2%">订单号</th>
                <th width="6%">下单时间</th>
                <th width="4%">用户名</th>
                <th width="3%">联系电话</th>
                <th width="2%">人数</th>
                <th width="5%">驾校</th>
                <th width="6%">课程名</th>
                <th width="4%">基地</th>
                <th width="3%">支付方式</th>
                <th width="3%">支付状态</th>
                <th width="6%">支付时间</th>
                <th width="5%">跟单客服</th>
                <th width="5%">最新备注</th>
                <th width="6%">回访日期</th>
                <th width="3%">最后更新人</th>
                <th width="3%">订单状态</th>
                <th width="3%">操作</th>
            </tr>
            <?php if(is_array($arr['list'] )): $k = 0; $__LIST__ = $arr['list'] ;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$arr['firstRow']); ?></td>
                    <td><?php echo ($v["ordcode"]); ?></td>
                    <td><?php echo ($v['create_time']); ?></td>
                    <td><?php echo ($v["name"]); ?></td>
                    <td><?php echo ($v["tel"]); ?></td>
                    <td><?php echo ($v["num"]); ?></td>
                    <td><?php echo ($v["s_nickname"]); ?></td>
                    <td><?php echo ($v["class_name"]); ?></td>
                    <td><?php echo ($v["trname"]); ?></td>
                    <td>
                        <?php if($v["pay_type"] == 0): ?>未支付<?php endif; ?>
                        <?php if($v["pay_type"] == 1): ?>支付宝<?php endif; ?>
                        <?php if($v["pay_type"] == 2): ?>微信<?php endif; ?>
                        <?php if($v["pay_type"] == 3): ?>门店<?php endif; ?>
                        <?php if($v["pay_type"] == 4): ?>快递<?php endif; ?>
                        <?php if($v["pay_type"] == 5): ?>驾校<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["status"] == 1): ?>待支付<?php endif; ?>
                        <?php if($v["status"] == 2): ?>已支付<?php endif; ?>
                        <?php if($v["status"] == 3): ?>待评价<?php endif; ?>
                        <?php if($v["status"] == 4): ?>待追加<?php endif; ?>
                        <?php if($v["status"] == 5): ?>已取消<?php endif; ?>
                        <?php if($v["status"] == 6): ?>已完成<?php endif; ?>
                    </td>
                    <td><?php echo ($v["notify_time"]); ?></td>
                    <td><?php echo ($v["customer"]); ?></td>
                    <td><?php echo ($v["customer_inform"]); ?></td>
                    <td><?php echo ($v["return_time"]); ?></td>
                    <td><?php echo ($v["lastupdate"]); ?></td>
                    <td>
                        <?php if($v["order_status"] == 1): ?>待处理<?php endif; ?>
                        <?php if($v["order_status"] == 2): ?>待回访<?php endif; ?>
                        <?php if($v["order_status"] == 3): ?>待结算<?php endif; ?>
                        <?php if($v["order_status"] == 4): ?>已完成<?php endif; ?>
                        <?php if($v["order_status"] == 5): ?>已取消<?php endif; ?>
                        <?php if($v["order_status"] == 6): ?>已退款<?php endif; ?>
                    </td>
                    <td>
                        <a class="tablelink" href="<?php echo U('Admin/Order/list_info',array('id'=>$v['id'],'p'=>$get['p'],'pid'=>$get['pid']));?>">处理</a>　
                    </td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($arr['page']); ?>
    </div>
</div>
</body>
</html>