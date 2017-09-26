<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>订单列表</title>

    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
    <style>
        #page a,#page span{display: inline-block; width:15px;height:15px ;padding: 5px;margin: 2px;text-decoration: none;
            text-align: center; line-height: 15px;background: #f0ead8; color:#000000;  border: 1px solid #c2d2d7; }
        #page a:hover{background:#F27602;color:#FF0000;}
        #page span{ background:#F27602; color:#FF0000; font-weight: bold;}
        #page{ float: right; }
        .tablelink{ cursor: pointer;}
        .message,.blue{font-size: 15px}
        .tr_color{background-color: #9F88FF}
        .table_a td,th{border:1px solid #cdcdcd;font-size: 13px}
    </style>
</head>
<body>
    <div class="div_head" style="background-color: rgb(129, 191, 249);">
        <span>
            <span style="float: left;font-weight: bolder;color: #ffffff">订单列表</span>
            <span style=" margin-right: 8px; font-weight: bold;color: #ffffff">
                <a style="text-decoration: none;color:#ff143f;font-size: 15px" href="<?php echo U('Admin/Order/add_order');?>">【新建订单】</a>
            </span>
            <span style="color: #ffffff"><?php echo ($count1); ?>条未处理；<?php echo ($count2); ?>条待回访；157条结算未回访订单</span>
        </span>
    </div>
    <div></div>
    <div class="div_search" style="height: 60px;background-color:  rgb(129, 191, 249)">
        <span style="float:left;color: #ffffff;font-weight: bolder">
            <form action="?" id='form1' method="get" name="form1">
                城市<select name="cityname">
                        <option value="">全部</option>
                        <?php if(is_array($citys)): $i = 0; $__LIST__ = $citys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($cityname==$v['id']?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>&nbsp;&nbsp;&nbsp;
                订单类型<select name="order_type">
                    <option value="0" >全部</option>
                    <option value="1" <?php echo ($order_type==1?selected:''); ?>>驾校订单</option>
                    <option value="2" <?php echo ($order_type==2?selected:''); ?>>教练订单</option>
                    <option value="3" <?php echo ($order_type==3?selected:''); ?>>指导员订单</option>
                    <option value="4" <?php echo ($order_type==4?selected:''); ?>>预约订单</option>
                </select>&nbsp;&nbsp;&nbsp;
                订单状态<select name="status">
                    <option value="0" >全部</option>
                    <option value="1" <?php echo ($status==1?selected:''); ?>>待付款</option>
                    <option value="2" <?php echo ($status==2?selected:''); ?>>待确认</option>
                    <option value="3" <?php echo ($status==3?selected:''); ?>>待评价</option>
                    <option value="4" <?php echo ($status==4?selected:''); ?>>已完成</option>
                    <option value="5" <?php echo ($status==5?selected:''); ?>>已取消</option>
                </select>&nbsp;&nbsp;&nbsp;
                支付方式<select name="pay_type">
                    <option value="0" >全部</option>
                    <option value="1" <?php echo ($pay_type==1?selected:''); ?>>支付宝</option>
                    <option value="2" <?php echo ($pay_type==2?selected:''); ?>>微信</option>
                    <option value="3" <?php echo ($pay_type==3?selected:''); ?>>门店</option>
                </select>&nbsp;&nbsp;&nbsp;
                下单时间<input type="text" style="width: 6%"  onClick="WdatePicker()" value="<?php echo ($create_time1?$create_time1:''); ?>" name="create_time1"/>至<input type="text" style="width: 6%" value="<?php echo ($create_time2?$create_time2:''); ?>"  onClick="WdatePicker()" name="create_time2"/>
                &nbsp;&nbsp;&nbsp;跟单客服 <input type="text" name="customer" style="width: 6%"  value="<?php echo ($customer?$customer:''); ?>"/>
                &nbsp;&nbsp;&nbsp;订单号<input type="text" name='ordcode' style="width: 7%"  value="<?php echo ($ordcode?$ordcode:''); ?>" />
                &nbsp;&nbsp;&nbsp;
                驾校/教练/指导员<input type="text" name='s_nickname' style="width: 7%"  value="<?php echo ($s_nickname?$s_nickname:''); ?>" />
                <br>手机号<input type="text" name='tel' style="width: 7%"  value="<?php echo ($tel?$tel:''); ?>"/>
                &nbsp;&nbsp;&nbsp;学员名<input type="text" name='name' style="width: 7%"  value="<?php echo ($name?$name:''); ?>"/>
                &nbsp;&nbsp;&nbsp;驾照类型<select name="class_name">
                    <option value="0" >全部</option>
                    <option value="C1" <?php echo ($class_name=="C1"?selected:''); ?>>C1</option>
                    <option value="C2" <?php echo ($class_name=="C2"?selected:''); ?>>C2</option>
                    <option value="C3" <?php echo ($class_name=="C3"?selected:''); ?>>C3</option>
                    <option value="C4" <?php echo ($class_name=="C4"?selected:''); ?>>C4</option>
                    <option value="C5" <?php echo ($class_name=="C5"?selected:''); ?>>C5</option>
                    <option value="A1" <?php echo ($class_name=="A1"?selected:''); ?>>A1</option>
                    <option value="A2" <?php echo ($class_name=="A2"?selected:''); ?>>A2</option>
                    <option value="A3" <?php echo ($class_name=="A3"?selected:''); ?>>A3</option>
                    <option value="B1" <?php echo ($class_name=="B1"?selected:''); ?>>B1</option>
                    <option value="A2" <?php echo ($class_name=="A2"?selected:''); ?>>A2</option>
                    <option value="D" <?php echo ($class_name=="D"?selected:''); ?>>D</option>
                </select>
                &nbsp;&nbsp;&nbsp;学车基地<input type="text" name='trainaddress' style="width: 7%"  value="<?php echo ($trainaddress?$trainaddress:''); ?>"/>
                &nbsp;&nbsp;&nbsp;支付时间<input type="text" style="width: 6%"  onClick="WdatePicker()" value="<?php echo ($notify_time1?$notify_time1:''); ?>" name="notify_time1"/>至<input type="text" style="width: 6%" value="<?php echo ($notify_time2?$notify_time2:''); ?>"  onClick="WdatePicker()" name="notify_time2"/>
                &nbsp;&nbsp;&nbsp;回访时间<input type="text" style="width: 6%"  onClick="WdatePicker()" value="<?php echo ($return_time1?$return_time1:''); ?>" name="return_time1"/>至<input type="text" style="width: 6%" value="<?php echo ($return_time2?$return_time2:''); ?>"  onClick="WdatePicker()" name="return_time2"/>
                <input value="查询" type="submit" id='btn' onclick="submitYouFrom('http://www.517xc.cn/index.php/Admin/Order/order_list')"/>
                <input value="清空全部" type="reset"/>
                <input value="导出" type="button" id="button" onclick="submitYouFrom('http://www.517xc.cn/index.php/Admin/Order/push')"/>
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
    <table class="table_a" style="border:1px solid #a9a9a9" width="100%">
        <tbody>
            <tr style="font-weight: bold;background-color:  rgb(129, 191, 249);">
                <th width="2%">编号</th>
                <th width="2%">订单号</th>
                <th width="7%">下单时间</th>
                <th width="4%">用户名</th>
                <th width="3%">联系电话</th>
                <th width="2%">人数</th>
                <th width="5%">驾校/教练/指导员</th>
                <th width="7%">课程名</th>
                <th width="4%">基地</th>
                <th width="3%">支付方式</th>
                <th width="3%">支付状态</th>
                <th width="3%">订单状态</th>
                <th width="6%">支付时间</th>
                <th width="5%">跟单客服</th>
                <th width="5%">最新备注</th>
                <th width="5%">回访日期</th>
                <th width="3%">最后更新人</th>
                <th width="3%">状态</th>
                <th width="3%">操作</th>
            </tr>
            <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["ordcode"]); ?></td>
                    <td><?php echo date('Y-m-d H:i:s',$v['create_time']);?></td>
                    <td><?php echo ($v["name"]); ?>  <span style="float: right"><?php echo ($v['sex']==0?'男士':'女士'); ?></span></td>
                    <td><?php echo ($v["tel"]); ?></td>
                    <td><?php echo ($v["num"]); ?></td>
                    <td><?php if($v["school_id"] == 0): ?>517驾校
                        <?php else: ?>
                        <?php echo ($v["s_nickname"]); endif; ?></td>
                    <td><?php echo ($v["class_name"]); ?></td>
                    <td><?php echo ($v["trainaddress"]); ?></td>
                    <td>
                        <?php if($v["pay_type"] == 0): ?>未支付<?php endif; ?>
                        <?php if($v["pay_type"] == 1): ?>支付宝<?php endif; ?>
                        <?php if($v["pay_type"] == 2): ?>微信<?php endif; ?>
                        <?php if($v["pay_type"] == 3): ?>门店<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["status"] == 1): ?>待付款<?php endif; ?>
                        <?php if($v["status"] == 2): ?>已支付<?php endif; ?>
                        <?php if($v["status"] == 3): ?>待评价<?php endif; ?>
                        <?php if($v["status"] == 4): ?>已完成<?php endif; ?>
                        <?php if($v["status"] == 5): ?>已取消<?php endif; ?>
                    </td>
                    <td>
                        <?php if($v["status"] == 5): ?>已取消
                            <?php elseif($v["status"] == 2): ?>
                            待结算
                            <?php else: ?>
                            待回访<?php endif; ?>
                    </td>
                    <td><?php echo ($v["notify_time"]); ?></td>
                    <td>
                        <?php if($v["customer"] == '0'): ?>暂无
                            <?php else: ?>
                            <?php echo ($v["customer"]); endif; ?>
                    </td>
                    <td>
                         <?php echo ($v["customer_inform"]); ?>
                    </td>
                    <td>
                        <?php if($v["return_time"] == '0'): ?>未回访
                            <?php else: ?>
                            <?php echo ($v["return_time"]); endif; ?>
                    </td>
                    <td>
                            <?php echo ($v["lastupdate"]); ?>
                    </td>
                    <td>
                        <?php echo ($v['flag']==0?'未处理':'已处理'); ?>
                    </td>
                    <td style="text-align: center">
                        <a href="<?php echo U('Admin/Order/list_info?id='.$v['id']);?>">处理</a>　
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