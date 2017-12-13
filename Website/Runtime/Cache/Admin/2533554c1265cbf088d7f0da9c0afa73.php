<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>退费列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
    <script  src="/Public/public/js/layer/layer.js"></script>
</head>
<body>
    <div class="div_head">
        取消订单列表
        <span class="span">总计：<?php echo ($arr['count']); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="?" id='form1' method="get" name="form1">
                <div>
                    <span>
                        驾校简称：<input type="text" name='s_nickname' style="width: 100px"  value="<?php echo ($get['s_nickname']?$get['s_nickname']:''); ?>" />
                    </span>
                  <span style="padding-left: 5px">
                    支付方式：<select name="pay_type" style="width: 90px;font-size: 12px">
                        <option value="0" >全部</option>
                        <option value="1" <?php echo ($get['pay_type']==1?selected:''); ?>>支付宝</option>
                        <option value="2" <?php echo ($get['pay_type']==2?selected:''); ?>>微信</option>
                        <option value="3" <?php echo ($get['pay_type']==3?selected:''); ?>>门店</option>
                        <option value="4" <?php echo ($get['pay_type']==4?selected:''); ?>>快递</option>
                        <option value="5" <?php echo ($get['pay_type']==5?selected:''); ?>>驾校</option>
                    </select>
                    </span>
                     <span style="padding-left: 5px">
                            学员姓名：<input type="text" name='truename' style="width: 100px"  value="<?php echo ($get['truename']?$get['truename']:''); ?>"/>
                     </span>
                     <span style="padding-left: 5px">
                        取消时间：<input type="text" style="width: 120px;font-size: 12px"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" value="<?php echo ($get['cancel_time1']?$get['cancel_time1']:''); ?>" name="cancel_time1"/>
                        至
                        <input type="text" style="width: 120px;font-size: 12px" value="<?php echo ($get['cancel_time2']?$get['cancel_time2']:''); ?>"  onClick="WdatePicker({dateFmt:'yyyy-MM-dd HH:mm:ss',readOnly:true})" name="cancel_time2"/>
                    </span>
                </div>
                <div>
                    <span>
                       订单编号：<input type="text" name='ordcode' style="width: 100px"  value="<?php echo ($get['ordcode']?$get['ordcode']:''); ?>" />
                    </span>
                    <span style="padding-left: 5px">
                        取消原因：<select name="cancel_reason" style="width: 90px;font-size: 12px">
                            <option value="0">请选择</option>
                            <?php if(is_array($order_cancel)): $i = 0; $__LIST__ = $order_cancel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$val): $mod = ($i % 2 );++$i;?><option value="<?php echo ($val["id"]); ?>" <?php echo ($val['id']==$get['cancel_reason']?selected:''); ?>><?php echo ($val["reason"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </span>
                    <span style="padding-left: 5px">
                        跟单客服：<input type="text" name="customer" style="width: 100px;"  value="<?php echo ($get['customer']?$get['customer']:''); ?>"/>
                    </span>
                    <span style="padding-left: 5px">
                        <input value="查询" type="submit" id='btn' onclick="submitYouFrom('<?php echo U("Admin/Finance/cancel_order",array('pid'=>$get['pid'],'p'=>$get['p']));?>')"/>
                        <input value="清空" type="reset" />
                        <input value="导出" type="button" id="button" onclick="submitYouFrom('<?php echo U("Admin/Order/push",array('order_status'=>5));?>')"/>
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
        <input id="checkall" style="background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0;font-size: 12px;font-weight:bold;" type="button" value='全选' />
        <input type="button" value='批量修改' onclick="cancel_reason()" style="font-size:12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 70px;padding: 2px 0"/>
    </div>
    <script>
        function cancel_reason(){
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
                    layer.open({
                        type: 1,
                        title:'取消原因',
                        skin: 'border:1px solid #27B7F3', //加上边框
                        area: ['400px', '100px'], //宽高
                        content:"<div style='text-align: center;'><form method='post' action='<?php echo U("cancel_reason");?>'>" +
                        "<input type='hidden' value='<?php echo ($get["pid"]); ?>' name='pid'/>"+
                        "<input type='hidden' value='<?php echo ($get["p"]); ?>' name='p'/>"+
                        "<input type='hidden' value='"+res.info['str']+"' name='str'/>"+
                        "取消原因：" +
                        "<select name='cancel_reason' style='margin-top:10px;height: 30px'>"+
                        "<?php if(is_array($order_cancel)): $i = 0; $__LIST__ = $order_cancel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>"+
                        "<option value='<?php echo ($v["id"]); ?>'><?php echo ($v["reason"]); ?></option>"+
                        "<?php endforeach; endif; else: echo "" ;endif; ?>"+
                        "</select>" +
                        "<input type='submit' style='background-color:rgb(19, 181, 177);color: #ffffff;padding: 5px 20px;;border-radius: 3px;border:none;margin-left: 10px' value='确定'/>" +
                        "</form></div>"
                    });
                },'json');
            }else{
                layer.msg('请勾选后再操作', {
                    time: 20000, //20s后自动关闭
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
    <div style="margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr style="background-color:  rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="4%">用户名</th>
                <th width="3%">联系电话</th>
                <th width="4%">关联订单</th>
                <th width="4%">驾校</th>
                <th width="5%">课程</th>
                <th width="4%">基地</th>
                <th width="3%">支付方式</th>
                <th width="5%">取消时间</th>
                <th width="3%">取消人</th>
                <th width="3%">取消原因</th>
                <th width="2%">操作</th>
            </tr>
            <form action="" id="form2">
                <?php if(is_array($arr["list"])): $k = 0; $__LIST__ = $arr["list"];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                        <td><input class="id_arr"  type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>" /> <?php echo ($k+$arr['firstRow']); ?></td>
                        <td><?php echo ($v["name"]); ?></td>
                        <td><?php echo ($v["tel"]); ?></td>
                        <td><?php echo ($v["ordcode"]); ?></td>
                        <td><?php echo ($v["s_nickname"]); ?></td>
                        <td><?php echo ($v["class_name"]); ?></td>
                        <td><?php echo ($v["trname"]); ?></td>
                        <td><?php if($v["pay_type"] == 1): ?>支付宝
                            <?php elseif($v["pay_type"] == 2): ?>微信
                            <?php elseif($v["pay_type"] == 3): ?>门店
                            <?php elseif($v["pay_type"] == 4): ?>快递
                            <?php elseif($v["pay_type"] == 5): ?>驾校<?php endif; ?></td>
                        <td><?php echo ($v["cancel_time"]); ?></td>
                        <td><?php echo ($v["lastupdate"]); ?></td>
                        <td><?php echo ($v["cancel_reason"]); ?></td>
                        <td><a class="tablelink" onclick="edit_reason(<?php echo ($v["id"]); ?>)" href="javascript:void(0)">修改</a> </td>
                        <script>
                            function edit_reason(id){
                                layer.open({
                                    type: 1,
                                    title:'取消原因',
                                    skin: 'border:1px solid #27B7F3', //加上边框
                                    area: ['300px', '100px'], //宽高
                                    content:"<div style='text-align: center'><form method='post' action='<?php echo U("cancel_order");?>'>" +
                                    "<input type='hidden' value='"+id+"' name='id'/>"+
                                    "<input type='hidden' value='<?php echo ($get["pid"]); ?>' name='pid'/>"+
                                    "<input type='hidden' value='<?php echo ($get["p"]); ?>' name='p'/>"+
                                    "<input type='hidden' value='1' name='t'/>"+
                                    "取消原因：" +
                                    "<select name='cancel_reason' style='margin-top:10px;height: 30px'>"+
                                    "<?php if(is_array($order_cancel)): $i = 0; $__LIST__ = $order_cancel;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?>"+
                                    "<option value='<?php echo ($v["id"]); ?>'><?php echo ($v["reason"]); ?></option>"+
                                    "<?php endforeach; endif; else: echo "$empty" ;endif; ?>"+
                                    "</select>" +
                                    "<input type='submit' style='background-color:rgb(19, 181, 177);color: #ffffff;border-radius: 3px;border:none;padding:5px 15px;margin-left: 10px' value='确定'/>" +
                                    "</form></div>"
                                });
                            }
                        </script>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </form>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($arr['page']); ?>
    </div>
</div>
</body>
</html>