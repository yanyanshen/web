<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>订单详情</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
       	 <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
          <link rel="stylesheet" href="http://www.jq22.com/jquery/bootstrap-3.3.4.css">
		  <link rel="stylesheet" href="/Public/website/Admin/ment/bootstrap/css/bootstrap-select.min.css">
		  <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
		  <script src="/Public/website/Admin/ment/js/bootstrap.min.js"></script>
		  <script src="/Public/website/Admin/ment/js/bootstrap-select.min.js"></script>
		  <script src="/Public/public/js/layer/layer.js"></script>
        <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
        <script src="/Public/public/js/jquery.validate.js"></script>
        <script>
        	$("document").ready(function(){
                $("#jx").change(function(){
                    id = $("#jx option:selected").val();
                    data={"id":id};
                    returntrain(data);
                });
                $("#jl1").change(function(){
                    id = $("#jx option:selected").val();
                    data={"id":id};
                    returntrain(data);
                });
                $("#jl2").change(function(){
                    id = $("#jx option:selected").val();
                    data={"id":id};
                    returntrain(data);
                });
                $("#jl3").change(function(){
                    id = $("#jx option:selected").val();
                    data={"id":id};
                    returntrain(data);
                });
                $("#zdy").change(function(){
                    id = $("#jx option:selected").val();
                    data={"id":id};
                    returntrain(data);
                });
                function returntrain(data){
                    $.ajax({
                        type: "POST",
                        url: 'returntrain',
                        data:JSON.stringify(data),
                        dataType: "json",//指定返回数据的类型
                        success: function (message) {
                            $('#train').html('');
                            $('#train').append("<option value='0'>请选择</option>");
                            $('#class').html('');
                            $('#class').append("<option value='0'>请选择</option>");
                            for(var i in message['train']){
                                $('#train').append("<option value="+message['train'][i]['trname']+">"+message['train'][i]['trname']+"</option>");
                            }
                            for(var i in message['trainclass']){
                                $('#class').append("<option value="+message['trainclass'][i]['id']+">"+message['trainclass'][i]['name']+"</option>");
                            }
                        },
                        error: function (message) {
                            alert(JSON.stringify(message));
                        }
                    });
                }
        		$("#class").change(function(){
                    alert($("#class option:selected").val())
        			$.post(
        				"<?php echo U('returnprices');?>",
        				{
                            class_name:$("#class option:selected").val()
        				},function(data,status){
        					data1=eval("("+data+")");
        					//alert(data);
        					//循环前先清空
        					$("#off").val('7500');
        					$("#who").val('6000');
        					$("#off").val(data1['officeprice']);
        					$("#who").val(data1['wholeprice']);
        			});
        		});
        		 $("input:text").not("[readonly]").css("background",'#F0F0F0');
        	});
 		</script>
        <style>
            table tr{border:1px solid rgb(194, 230, 245);color: #000004 }
            .table_a{border:2px solid rgba(105, 190, 249, 0.60);width:100%;border-radius: 15px}
            input{  margin-bottom: 8px;  }
            div.error{  font-size: 14px;  font-weight: bold;  color: #FF0000;  }
            div.ok{  font-size: 14px;  font-weight: bold;  color: #38D63B;  }
        </style>
    </head>
    <body>
        <div class="div_head">
            <span>
                <span style="float:left">订单详情</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <!--<?php if($list["status"] == 1): ?>-->
                        <!--<a href="<?php echo U('cencel_list?id='.$id);?>" style="text-decoration: none">-->
                            <!--【取消订单】-->
                        <!--</a>-->
                        <!--<?php else: ?>-->
                        <!--<a href="javascript:;" style="text-decoration: none">-->
                            <!--【删除订单】-->
                        <!--</a>-->
                    <!--<?php endif; ?>-->
                    <a style="text-decoration: none" href="<?php echo U('order_list');?>">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>

        <div style="font-size: 13px;margin: 10px 5px">
            <form action="<?php echo U('order_update');?>" method="post">
                <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                <table class="table_a">
                    <tr>
                        <td style="font-weight: bolder" colspan='8'>订单概况</td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">订单号:</td>
                        <td><input type="text" name="ordcode" value="<?php echo ($list['ordcode']); ?>" readonly/></td>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">订单类型:</td>
                        <td>
                            <?php if($list['order_type'] == 1): ?>驾校订单<?php endif; ?>
                            <?php if($list['order_type'] == 2): ?>教练订单<?php endif; ?>
                            <?php if($list['order_type'] == 3): ?>指导员订单<?php endif; ?>
                            <?php if($list['order_type'] == 4): ?>预约订单<?php endif; ?>
                            <?php if($list['order_type'] == 5): ?>人工订单<?php endif; ?>
                            <!--<select name="order_type">-->
                                <!--<option value=1 <?php echo ($list['order_type']==1?'selected':''); ?>>驾校订单</option>-->
                                <!--<option value=2 <?php echo ($list['order_type']==2?'selected':''); ?>>教练订单</option>-->
                                <!--<option value=3 <?php echo ($list['order_type']==3?'selected':''); ?>>指导员订单</option>-->
                                <!--<option value=4 <?php echo ($list['order_type']==4?'selected':''); ?>>预约订单</option>-->
                                <!--<option value=5 <?php echo ($list['order_type']==4?'selected':''); ?>>人工订单</option>-->
                            <!--</select>-->
                        </td>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">订单状态:</td>
                        <td>
                            <?php if($list['status'] == 1): ?>待支付
                                <?php elseif($list['status'] == 2): ?>
                                待评价
                                <?php elseif($list['status'] == 3): ?>
                                待确认
                                <?php elseif($list['status'] == 4): ?>
                                已完成
                                <?php elseif($list['status'] == 5): ?>
                                已取消<?php endif; ?>
                            <!--<select name="status" >-->
                                <!--<option value='1' <?php echo ($list['status']==1?'selected':''); ?>>待支付</option>-->
                                <!--<option value='2' <?php echo ($list['status']==2?'selected':''); ?>>待评价</option>-->
                                <!--<option value='3' <?php echo ($list['status']==3?'selected':''); ?>>待确认</option>-->
                                <!--<option value='4' <?php echo ($list['status']==4?'selected':''); ?>>已完成</option>-->
                                <!--<option value='5' <?php echo ($list['status']==5?'selected':''); ?>>已取消</option>-->
                            <!--</select>-->
                        </td>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">下次回访:</td>
                        <td>
                            <?php if($list['return_time'] == '0'): ?>未设置
                                <?php else: ?>
                                <?php echo ($list['return_time']); endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">下单时间:</td>
                        <td><?php echo date('Y-m-d H:i:s',$list['create_time']);?></td>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">支付方式:</td>
                        <td>
                            <?php if($list['pay_type'] == 1): ?>支付宝
                                <?php elseif($list['pay_type'] == 2): ?>微信
                                <?php else: ?>未支付<?php endif; ?>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">支付状态:</td>
                        <td><?php echo ($list['status']==1?'待支付':'已支付'); ?></td>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">跟单客服:</td>
                        <td>
                            <select name="customer" >
                                <?php if(is_array($customers)): $i = 0; $__LIST__ = $customers;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["username"]); ?>" <?php echo ($v['username']==$list['customer']?'selected':""); ?>><?php echo ($v["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="8">
                            <!--<input type="submit" value='保存更新' />　-->
                            <input style="background-color:rgb(189, 206, 238);border-radius: 3px;border:none" type="submit" value='操作日志' />　
                            <input style="margin-left: 15%;background-color:rgb(189, 206, 238);border-radius: 3px;border:none" type="submit" value='发送短信' />　
                            <input style="margin-left: 25%;background-color:rgb(189, 206, 238);border-radius: 3px ;border:none" type="submit" value='发送短信凭证' />　
                            <input style="float: right;margin-right: 2%;;background-color:rgb(189, 206, 238);border-radius: 3px;border:none"  type="submit" value='取消' />
                         </td>
                    </tr>
                </table>
            </form><br>
 <!-- ------------------------------------form2------------------------------------------------ -->
            <form action="<?php echo U('stu_update');?>" method="post">
                <table class="table_a">
                    <tr>
                        <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                        <td colspan='8'>用户信息</td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">客户姓名:</td>
                        <td><?php echo ($user["truename"]); ?></td>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">客户电话:</td>
                        <td><?php echo ($user["account"]); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">学员姓名:</td>
                        <td colspan="3"><?php echo ($list["name"]); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">学员电话:</td>
                        <td colspan="3"><?php echo ($list["tel"]); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">所在位置:</td>
                        <td colspan="3"><?php echo ($list["address"]); ?></td>
                    </tr>
                    <tr>
                        <td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">备注信息:</td>
                        <td colspan="3"><?php echo ($list["inform"]); ?></td>
                    </tr>
                    <tr>
                        <td colspan='8'><input  style="background-color:rgb(189, 206, 238);border-radius: 3px;border:none" type="button" onclick="stu_update()" value='修改学员信息' /></td>
                    </tr>

            	  </table>
            </form><br>
<!-- ------------------------------------form3------------------------------------------------ -->
			<form action="<?php echo U('class_update');?>" method="post">
                <table class="table_a">
					<tr>
					<input type="hidden" name="id" value="<?php echo ($id); ?>"/>
					<input type="hidden" name="ordcode" value="<?php echo ($list["ordcode"]); ?>"/>
						<td colspan='14'>意向课程</td>
					</tr>
					<tr>
						<td width="6%" style="background-color: rgb(233,233,233);font-weight: bolder">已报驾校:</td>
						<td>
							<select id ='jx' name="jx" style="width: 150px;height: 30px">
								<option value="0">517驾校</option>
					       		<?php if(is_array($school)): $i = 0; $__LIST__ = $school;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					        </select>
						</td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">普通教练:</td>
						<td>
							<select id="jl0" name="jl0" style="width: 150px;height: 30px">
							    <option value="0">请选择</option>
					       		<?php if(is_array($coach0)): $i = 0; $__LIST__ = $coach0;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					        </select>
						</td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">教练小老板:</td>
						<td>
							<select id='jl1' name="jl1" style="width: 150px;height: 30px">
					       		<option value="0">请选择</option>
					       		<?php if(is_array($coach2)): $i = 0; $__LIST__ = $coach2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					        </select>
						</td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">打工教练:</td>
						<td>
							<select name="jl2" style="width: 150px">
					       		<option value="0">请选择</option>
					       		<?php if(is_array($coach3)): $i = 0; $__LIST__ = $coach3;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					        </select>
						</td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">私人教练:</td>
						<td>
							<select id='jl3' name="jl3" style="width: 150px;height: 30px">
					       		<option value="0">请选择</option>
					       		<?php if(is_array($coach1)): $i = 0; $__LIST__ = $coach1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					        </select>
						</td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">指导员:</td>
						<td>
							<select id='zdy' name="zd" style="width: 150px;height: 30px">
					       		<option value="0">请选择</option>
					       		<?php if(is_array($guider)): $i = 0; $__LIST__ = $guider;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
					        </select>
						</td>
					</tr>
					<tr>
					    <td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">已报课程:</td>
						<td>
							<select name="class_name" id="class" style="width: 150px;height: 30px">
                                <option value="0">C1照全包</option>
								<?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['class_name']==$v['name']?'selected':''); ?>><?php echo ($v["name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
							</select>
						</td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">已选基地:</td>
						<td>
                            <select name="trainaddress" id="train" style="width: 150px;height: 30px">
                                <option value='517基地' >517基地</option>
                                <?php if(is_array($train)): $i = 0; $__LIST__ = $train;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["trname"]); ?>" <?php echo ($list['trname']==$v['trainaddress']?'selected':''); ?>><?php echo ($v["trname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                            </select>
						</td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">联系人/电话:</td>
						<td><input type="text" name="connect" value="<?php echo ($list["connect"]); ?>"/></td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">门市价:</td>
						<td><input type="text" value="<?php echo ($price['officeprice']==''?7500:$price['officeprice']); ?>" id='off' readonly/></td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder;width: 6%">全包价:</td>
						<td><input type="text"  value="<?php echo ($price['wholeprice']==''?6000:$price['wholeprice']); ?>" id='who' readonly/></td>
					</tr>
					<tr>
                		<td colspan='14'><input style="background-color:rgb(189, 206, 238);border-radius: 3px;border:none" type="submit" value='保存更新' /></td>
               		</tr>
				</table>
			</form><br />
<!-- ------------------------------------form4------------------------------------------------ -->
			<form action="<?php echo U('zhifu');?>" method="post">
			<input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                <table class="table_a">
					<tr>
						<td  colspan='10' >付款信息</td>
					</tr>
					<tr>
						<td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">支付方式:</td>
						<td><select name="pay_type">
                            <option value="0" >未支付</option>
                            <option value="1" <?php echo ($list['pay_type']==1?'selected':''); ?>>支付宝</option>
                            <option value="2" <?php echo ($list['pay_type']==2?'selected':''); ?>>微信</option>
                            <option value="3" <?php echo ($list['pay_type']==3?'selected':''); ?>>门店</option>
                        </select>
						<td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">支付状态:</td>
						<td>
                            <select name="status">
                                <option value="0" >未支付</option>
                                <option value="1" <?php echo ($list['status']==1?'selected':''); ?>>待支付</option>
                                <option value="2" <?php echo ($list['status']==2?'selected':''); ?>>已支付</option>
                                <option value="3" <?php echo ($list['status']==3?'selected':''); ?>>待评价</option>
                                <option value="4" <?php echo ($list['status']==4?'selected':''); ?>>已评价</option>
                                <option value="5" <?php echo ($list['status']==5?'selected':''); ?>>已取消</option>
                            </select>
                        </td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">报名人数:</td>
						<td><input type="text" value="<?php echo ($list['num']); ?>"  readonly/></td>
						
					</tr>
					<tr>
						<td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">下单价格:</td>
						<td><input type="text" value="<?php echo ($list['price']); ?>" readonly/></td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">报名方式</td>
						<td><input type="text" value="<?php echo ($list['type']==1?'全款':'预付款'); ?>"  readonly/></td>
						<td style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">实际支付金额:</td>
						<td><input type="text" value="<?php echo ($list['total_fee']); ?>" readonly /></td>
					</tr>
                    <tr>
                        <td colspan='8'><input  style="background-color:rgb(189, 206, 238);border-radius: 3px;border:none" type="submit"  value='修改支付信息' /></td>
                    </tr>
				</table>
			</form><br />
			<!-- ------------------------------------form5------------------------------------------------ -->
        	<form action="<?php echo U('#');?>" method="post">
                <table class="table_a">
					<tr>
						<td colspan=10>来源信息</td>
					</tr>
					<tr>
						<td  style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">来源:</td>
						<td>
                            <?php if($list["order_source"] == 0): ?>百度广告<?php endif; ?>
                            <?php if($list["order_source"] == 1): ?>广点通<?php endif; ?>
                            <?php if($list["order_source"] == 2): ?>呼损<?php endif; ?>
                            <?php if($list["order_source"] == 3): ?>百度<?php endif; ?>
                            <?php if($list["order_source"] == 4): ?>神马<?php endif; ?>
                            <?php if($list["order_source"] == 5): ?>360搜索<?php endif; ?>
                            <?php if($list["order_source"] == 6): ?>搜狗<?php endif; ?>
                            <?php if($list["order_source"] == 7): ?>商桥<?php endif; ?>
                            <?php if($list["order_source"] == 8): ?>线上其他<?php endif; ?>
                            <?php if($list["order_source"] == 9): ?>地铁广告<?php endif; ?>
                            <?php if($list["order_source"] == 10): ?>地铁客服<?php endif; ?>
                            <?php if($list["order_source"] == 11): ?>淘宝<?php endif; ?>
                            <?php if($list["order_source"] == 12): ?>单页<?php endif; ?>
                            <?php if($list["order_source"] == 13): ?>册子<?php endif; ?>
                            <?php if($list["order_source"] == 14): ?>线下其他<?php endif; ?>
                            <?php if($list["order_source"] == 15): ?>移动端<?php endif; ?>
                        </td>
						<td  style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">竞价关键字:</td>
						<td></td>
						<td  style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">搜索词:</td>
						<td></td>
						<td  style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">referee:</td>
						<td></td>
						<td  style="background-color: rgb(233,233,233);font-weight: bolder" width="6%">下单站点:</td>
						<td></td>
					</tr>
				</table>
			</form><br>
		<!-- ------------------------------------form6------------------------------------------------ -->
			<form action="<?php echo U('returndate');?>" method="post">
					<input type="hidden" name="ordcode" value="<?php echo ($list["ordcode"]); ?>"/>
                	<input type="hidden" name="id" value="<?php echo ($list["id"]); ?>"/>
				<div class="left1"  style="width: 20%">
                    <table class="table_a">
						<tr>
							<td>
								添加回访记录
							</td>
						</tr>
						<tr>
							<td>
								<textarea name="content" id="" cols="60%" rows="7"></textarea>
							</td>
						</tr>
						<tr>
							<td>
								设置回访日期: <input   id='input1' onClick="WdatePicker()" name="return_time"/>　
                                <input type="submit" style="background-color:rgb(189, 206, 238);border-radius: 3px;border:none" type="text" value="添加"/>
							</td>
						</tr>
					</table>
				</div>
			</form>
				<div class="right1" style="width: 65%">
                    <table class="table_a">
						<tr>
							<td colspan=5>全部跟单记录</td>
						</tr>
						<tr>
							<td width="4%">序号</td>
							<td width="10%">跟单时间</td>
							<td width="20%">详情</td>
							<td width="10%">下次回访日期</td>
							<td width="5%">回访人</td>
						</tr>
						<?php if(is_array($jilu)): $i = 0; $__LIST__ = $jilu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr> 
								<td  style="border:1px solid rgb(189, 206, 238);"><?php echo ($v["id"]); ?></td>
								<td  style="border:1px solid rgb(189, 206, 238);"><?php echo ($v["create_time"]); ?></td>
								<td  style="border:1px solid rgb(189, 206, 238);"><?php echo ($v["content"]); ?></td>
								<td  style="border:1px solid rgb(189, 206, 238);"><?php echo ($v["return_time"]); ?></td>
								<td  style="border:1px solid rgb(189, 206, 238);"><?php echo ($v["operator"]); ?></td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</table>
				</div>
			<!-- --------------------------------驾校------------------------------------- -->
			<datalist id="school_list" name="school_list"></datalist>
       </div>
             <div style="margin:0 auto;width:100%;clear:both;text-align:center">
             </div>
    </body>
</html>
<script>
    function stu_update(){
        layer.open({
            type: 1,
            title:'修改学员信息',
            skin: 'layui-layer-rim', //加上边框
            area: ['420px', '410px'], //宽高
            content: '<div><form id="stu_update" method="post" action="http://www.517xc.cn/index.php/Admin/Order/stu_update">' +
            '<input type="hidden" value="<?php echo ($list["id"]); ?>" name="id"/>'+
            '<div style="text-align: center;margin:10px"><span style="background-color: rgb(233,233,233);font-weight: bolder;border-radius: 3px;padding: 5px;margin: 15px">学员姓名：</span><input type="text" name="name"/></div>'+
            '<div style="text-align: center;margin:10px"><span style="background-color: rgb(233,233,233);font-weight: bolder;border-radius: 3px;padding: 5px;margin: 15px">学员电话：</span><input type="text" name="tel"/></div>'+
            '<div style="text-align: center;margin:10px"><span style="background-color: rgb(233,233,233);font-weight: bolder;border-radius: 3px;padding: 5px;margin: 15px">所在位置：</span><input type="text" name="address"/></div>'+
            '<div style="text-align: center;margin:10px"><span style="background-color: rgb(233,233,233);font-weight: bolder;border-radius: 3px;padding: 5px">备注信息：</span><textarea cols="41" rows="4" name="inform"></textarea></div>'+
            '<div style="text-align: center"><input type="submit" id="aa"  style="background-color:rgb(189, 206, 238);border-radius: 3px;border:none;padding: 10px" value="点击保存"/></div>'+
            '</form></div>'
        });
        var validate=$('#stu_update').validate({
            rules:{
                name:{required:true},
                tel:{required:true, tel:true}
            },
            messages:{
                name:{required:'客户名称不能为空！'},
                tel:{required:'联系方式不能为空！'}
            },
            success:function(div){
                div.addClass('ok').text('通过验证')
            },
            validClass:'ok',
            errorElement:'div'
        });
        jQuery.validator.addMethod("tel", function(value, element) {
            var mobileReg = /^1[34578]{1}[0-9]{9}$/;
            return this.optional(element) || (mobileReg.test(value));
        }, "请正确填写您的手机号");
    }
</script>