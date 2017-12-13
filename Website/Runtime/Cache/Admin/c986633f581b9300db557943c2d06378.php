<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>待结算订单列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
</head>
<body>
    <div class="div_head">
        待结算订单列表
        <span class="span">总计：<?php echo ($arr['count']); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                <div>
                    <span>
                        订单编号：<input type="text" name='ordcode' style="width: 100px"  value="<?php echo ($get['ordcode']?$get['ordcode']:''); ?>" />
                    </span>
                   <span style="padding-left:5px">
                         学员名：<input type="text" name='truename' style="width: 80px"  value="<?php echo ($get['truename']?$get['truename']:''); ?>"/>
                    </span>
                    <span  style="padding-left:5px">
                        订单类型：<select name="order_type" style="width: 75px;font-size: 11px;height: 20px">
                            <option value="0" >全部</option>
                            <option value="1" <?php echo ($get['order_type']==1?selected:''); ?>>学车需求</option>
                            <option value="2" <?php echo ($get['order_type']==2?selected:''); ?>>在线订单</option>
                            <option value="3" <?php echo ($get['order_type']==3?selected:''); ?>>人工订单</option>
                            <option value="4" <?php echo ($get['order_type']==4?selected:''); ?>>其他类型</option>
                        </select>
                    </span>
                    <span style="padding-left:5px">支付方式：<select name="pay_type" style="width: 77px;font-size: 11px;height: 20px">
                        <option value="0" >全部</option>
                        <option value="1" <?php echo ($get['pay_type']==1?selected:''); ?>>支付宝</option>
                        <option value="2" <?php echo ($get['pay_type']==2?selected:''); ?>>微信</option>
                        <option value="3" <?php echo ($get['pay_type']==3?selected:''); ?>>门店</option>
                        <option value="4" <?php echo ($get['pay_type']==4?selected:''); ?>>快递</option>
                        <option value="5" <?php echo ($get['pay_type']==5?selected:''); ?>>驾校</option>
                    </select>
                    </span>
                    <span style="padding-left:5px">
                        下单时间：<input type="text" style="width: 120px"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['create_time1']?$get['create_time1']:''); ?>" name="create_time1"/>
                        至
                        <input type="text" style="width: 120px" value="<?php echo ($get['create_time2']?$get['create_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="create_time2"/>
                    </span>
                </div>
                <div style="font-size: 11px">
                    <span>
                        驾校简称：<input type="text" name='s_nickname' style="width: 100px"  value="<?php echo ($get['s_nickname']?$get['s_nickname']:''); ?>" />
                    </span>
                     <span style="padding-left: 5px">手机号：<input type="text" name='tel' style="width:80px"  value="<?php echo ($get['tel']?$get['tel']:''); ?>"/></span>
                     <span style="padding-left:5px;">
                        驾照类型：<select name="class_name" style="width: 75px;font-size: 11px;height: 20px">
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
                    <span style="padding-left:5px">
                        跟单客服：<input type="text" name="customer" style="width: 75px"  value="<?php echo ($get['customer']?$get['customer']:''); ?>"/>
                    </span>
                    <span style="padding-left:5px">
                        支付时间：<input type="text" style="width: 120px"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['notify_time1']?$get['notify_time1']:''); ?>" name="notify_time1"/>
                        至
                        <input type="text" style="width: 120px" value="<?php echo ($get['notify_time2']?$get['notify_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="notify_time2"/>
                    </span>
                    <span style="padding-left:5px">
                        <input value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/Finance/wait_account",array('pid'=>$get['pid'],'p'=>$get['p']));?>')"/>
                        <input value="导出" type="button" id="button" onclick="submitYouFrom('<?php echo U("Admin/Order/push",array('order_status'=>3));?>')"/>
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
        <div style="margin-left: 6px">
            <input id="checkall" style="font-size: 12px;font-weight: bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0;" type="button" value='全选' />
            <input type="button" value='批量退费' onclick="batch_operate('退费')" style="font-size: 12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 70px;padding: 2px 0"/>
            <input type="button" value='批量结算' onclick="batch_operate('结算')" style="font-size: 12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 70px;padding: 2px 0"/>
            <input type="button" value='批量取消' onclick="batch_operate('取消')" style="font-size: 12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 70px;padding: 2px 0"/>
            <script>
                function batch_operate(type){
                    var id_arr = document.getElementsByName("id[]");
                    var flag = false ;
                    for(var i in id_arr){
                        if(id_arr[i].checked){
                            flag = true ;
                            break ;
                        }
                    }
                    if(flag){
                        $.post("<?php echo U('Admin/Finance/batch_operate');?>",$("#form2").serialize(),function(res){
                            if(type == '取消'){
                                layer.open({
                                    type: 1,
                                    title: '取消',
                                    skin: 'border:1px solid #27B7F3', //加上边框
                                    area: ['400px', '100px'], //宽高
                                    content: "<div style='text-align: center'><form method='post' action='<?php echo U("batch_operate");?>'>" +
                                    "<input type='hidden' value='<?php echo ($get["pid"]); ?>' name='pid'/>" +
                                    "<input type='hidden' value='<?php echo ($get["p"]); ?>' name='p'/>" +
                                    "<input type='hidden' value='" + type + "' name='type'/>" +
                                    "<input type='hidden' value='" + res.info['str'] + "' name='str'/>" +
                                    "请选择取消原因：<select style='margin-top:10px;height: 30px' name='cancel_reason'>" +
                                    "<?php if(is_array($reason)): $i = 0; $__LIST__ = $reason;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>" +
                                    "<option value='<?php echo ($v["id"]); ?>'><?php echo ($v["reason"]); ?></option>" +
                                    "<?php endforeach; endif; else: echo "" ;endif; ?></select>" +
                                    "<input type='submit' style='background-color:rgb(19, 181, 177);padding: 5px 15px;color: #ffffff;border-radius: 3px;border:none;margin-left: 10px' value='确定'/>" +
                                    "</form></div>"
                                })
                            }else if(type == '结算'){
                                layer.msg('确定要结算吗？',{
                                    time:0,
                                    btn:['确定','取消'],
                                    yes:function(){
                                        location.href = "<?php echo U('Admin/Finance/batch_operate');?>?pid=<?php echo ($get['pid']); ?>&p=<?php echo ($get['p']); ?>&str="+res.info['str']+"&type="+type
                                    }
                                });
                            }else if(type == '退费'){
                                layer.open({
                                    type: 1,
                                    title: '退费',
                                    skin: 'border:1px solid #27B7F3', //加上边框
                                    area: ['400px', '100px'], //宽高
                                    content: "<div style='text-align: center'><form method='post' action='<?php echo U("batch_operate");?>'>" +
                                    "<input type='hidden' value='<?php echo ($get["pid"]); ?>' name='pid'/>" +
                                    "<input type='hidden' value='<?php echo ($get["p"]); ?>' name='p'/>" +
                                    "<input type='hidden' value='" + res.info['str'] + "' name='str'/>" +
                                    "<input type='hidden' value='" + type + "' name='type'/>" +
                                    "实退金额：<input type='text'  name='return_money'  placeholder='请填写实退金额'   class='dfinput' style='margin-top:10px' value=''/>" +
                                    "<input type='submit' style='background-color:rgb(19, 181, 177);padding: 5px 15px;color:#ffffff;border-radius: 3px;border:none;margin-left: 10px' value='确定'/>" +
                                    "</form></div>"
                                });
                            }
                        },'json');
                    }else{
                        layer.msg('请勾选后再操作', {
                            time: 2000, //20s后自动关闭
                            btn: ['知道了']
                        });
                    }
                }
                $("document").ready(function(){
                    $("#checkall").click(function(){
                        if($(this).val()=='全选'){
                            $("input[type='checkbox']").prop('checked', true);
                            $("#checkall").val("取消全选");
                        }else{
                            $("input[type='checkbox']").prop('checked', false);
                            $("#checkall").val("全选");
                        }
                    });
                });
            </script>
        </div>
        <div style=" margin: 5px 5px;">
            <table class="table_a">
                <tbody>
                <tr style="background-color:  rgb(19, 181, 177);">
                    <th width="2%">编号</th>
                    <th width="3%">学生姓名</th>
                    <th width="2%">联系电话</th>
                    <th width="3%">关联订单</th>
                    <th width="5%">下单时间</th>
                    <th width="4%">驾校</th>
                    <th width="5%">意向课程</th>
                    <th width="2%">全包价</th>
                    <th width="2%">佣金</th>
                    <th width="3%">优惠</th>
                    <th width="2%">应收</th>
                    <th width="3%">支付方式</th>
                    <th width="5%">支付时间</th>
                    <th width="2%">实收</th>
                    <th width="4%">商户订单号</th>
                    <th width="2%">跟单客服</th>
                    <th width="5%">财务处理</th>
                </tr>
                <form action="" id="form2">
                    <?php if(is_array($arr['list'])): $k = 0; $__LIST__ = $arr['list'];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                            <td> <input  type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>" /> <?php echo ($k+$arr['firstRow']); ?></td>
                            <td><?php echo ($v["name"]); ?></td>
                            <td><?php echo ($v["tel"]); ?></td>
                            <td><?php echo ($v["ordcode"]); ?></td>
                            <td><?php echo ($v['create_time']); ?></td>
                            <td><?php echo ($v["s_nickname"]); ?></td>
                            <td><?php echo ($v["class_name"]); ?></td>
                            <td><?php echo ($v["wholeprice"]); ?></td>
                            <td><?php echo ($v["advanceprice"]); ?></td>
                            <td><?php echo ($v["sale_price"]); ?></td>
                            <td><?php echo ($v['price']?$v['price']:$v['advanceprice']); ?></td>
                            <td>
                                <?php if($v['pay_type'] == 0): ?>未支付<?php endif; ?>
                                <?php if($v['pay_type'] == 1): ?>支付宝<?php endif; ?>
                                <?php if($v['pay_type'] == 2): ?>微信<?php endif; ?>
                                <?php if($v['pay_type'] == 3): ?>门店<?php endif; ?>
                                <?php if($v['pay_type'] == 4): ?>快递<?php endif; ?>
                                <?php if($v['pay_type'] == 5): ?>驾校<?php endif; ?>
                            </td>
                            <td><?php echo ($v["notify_time"]); ?></td>
                            <td><?php echo ($v['total_fee']); ?></td>
                            <td><?php echo ($v['trade_no']); ?></td>
                            <td><?php echo ($v["customer"]); ?></td>
                            <td>
                                <a class="tablelink" onclick="edit_pass(<?php echo ($v["id"]); ?>)" href="javascript:void(0)">退费</a>
                                <span>|</span>
                                <a class="tablelink" onclick="end_account(<?php echo ($v["id"]); ?>,<?php echo ($get['pid']); ?>,<?php echo ($get['p']?$get['p']:1); ?>)" href="javascript:void(0)">结算</a>
                                <span>|</span>
                                <a class="tablelink" onclick="cancel_order(<?php echo ($v["id"]); ?>)" href="javascript:void(0)">
                                    取消
                                </a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                </form>
                <script>
                    function edit_pass(id){
                        layer.open({
                            type: 1, title:'退费',
                            skin: 'border:1px solid #27B7F3', //加上边框
                            area: ['400px', '100px'], //宽高
                            content:"<div style='text-align: center'><form method='post' action='<?php echo U("wait_account");?>'>" +
                            "<input type='hidden' value='1' name='t'/>"+
                            "<input type='hidden' value='<?php echo ($get["pid"]); ?>' name='pid'/>"+
                            "<input type='hidden' value='<?php echo ($get["p"]); ?>' name='p'/>"+
                            "<input type='hidden' value='"+id+"' name='id'/>"+
                            "实退金额：<input type='text'  name='return_money'  placeholder='请填写实退金额'   class='dfinput' style='margin-top:10px' value=''/>" +
                            "<input type='submit' style='background-color:rgb(19, 181, 177);padding: 5px 15px;color: #ffffff;border-radius: 3px;border:none;margin-left: 10px' value='确定'/>" +
                            "</form></div>"
                        });
                    }
                    function end_account(id,pid,p){
                        layer.msg('确定要结算吗？',{
                            time:0,
                            btn:['确定','取消'],
                            yes:function(){
                                location.href = "<?php echo U('Admin/Finance/end_account');?>?id="+id+'&pid='+pid+'&p='+p
                            }
                        });
                    }
                    function cancel_order(id){
                        layer.open({
                            type: 1, title:'订单取消',
                            skin: 'border:1px solid #27B7F3', //加上边框
                            area: ['400px', '100px'], //宽高
                            content:"<div style='text-align: center'><form method='post' action='<?php echo U("wait_account");?>'>" +
                            "<input type='hidden' value='3' name='t'/>"+
                            "<input type='hidden' value='<?php echo ($get["pid"]); ?>' name='pid'/>"+
                            "<input type='hidden' value='<?php echo ($get["p"]); ?>' name='p'/>"+
                            "<input type='hidden' value='"+id+"' name='id'/>"+
                            "请选择取消原因：<select style='margin-top:10px;height: 30px' name='cancel_reason'>"+
                            "<?php if(is_array($reason)): $i = 0; $__LIST__ = $reason;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>"+
                            "<option value='<?php echo ($v["id"]); ?>'><?php echo ($v["reason"]); ?></option>" +
                            "<?php endforeach; endif; else: echo "" ;endif; ?></select>"+
                            "<input type='submit' style='background-color:rgb(19, 181, 177);color: #ffffff;padding: 5px 20px;border-radius: 3px;border:none;margin-left: 10px' value='确定'/>" +
                            "</form></div>"
                        });
                    }
                </script>
                </tbody>
            </table>
            <div id="page">
                <?php echo ($arr['page']); ?>
            </div>
        </div>
</body>
</html>