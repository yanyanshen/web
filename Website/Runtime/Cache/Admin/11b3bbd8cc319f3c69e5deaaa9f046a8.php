<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>新建订单</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
    <link rel="stylesheet" href="http://www.jq22.com/jquery/bootstrap-3.3.4.css">
    <link rel="stylesheet" href="/Public/website/Admin/ment/bootstrap/css/bootstrap-select.min.css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/website/Admin/ment/js/bootstrap.min.js"></script>
    <script src="/Public/website/Admin/ment/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
    <script src="/Public/public/js/jquery.validate.js"></script>
    <script language="javascript">
       $(function(){
            var validate=$('#form1').validate({
                rules:{
                    phone:{required:true, phone:true},
                    truename:{required:true}
                },
                messages:{
                    phone:{required:'联系方式不能为空！',remote:'此手机号已有订单'},
                    truename:{required:'客户名不能为空!'}
                },
                success:function(span){
                    span.addClass('ok').text('通过验证')
                },
                validClass:'ok',
                errorElement:'span'
            });

            jQuery.validator.addMethod("phone", function(value, element) {
                var mobileReg = /^1[34578]{1}[0-9]{9}$/;
                return this.optional(element) || (mobileReg.test(value));
            }, "请正确填写您的手机号");

        });
        $("document").ready(function(){
            $("#jx").change(function(){
                id = $("#jx option:selected").val();
                data={"id":id};
                returntrain(data);
            });
            $("#jl").change(function(){
                id = $("#jl option:selected").val();
                data={"id":id};
                returntrain(data);
            });
            $("#zd").change(function(){
                id = $("#zd option:selected").val();
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
                        $('#train').append("<option value='517基地'>517基地</option>");
                        $('#class').html('');
                        $('#class').append("<option value='C1照全包'>C1照全包</option>");
                        for(var i in message['train']){
                            $('#train').append("<option value="+message['train'][i]['trname']+">"+message['train'][i]['trname']+"</option>");
                        }
                        for(var i in message['trainclass']){
                            $('#class').append("<option value="+message['trainclass'][i]['name']+">"+message['trainclass'][i]['name']+"</option>");
                        }
                    },
                    error: function (message) {
                        alert(JSON.stringify(message));
                    }
                });
            }
        });
    </script>
    <style>
        table td{  height: 35px;border:1px solid #92d2ff }
        .td {color: #000000;font-weight: bolder}
        input{  margin-bottom: 8px;  }
        span.error{  font-size: 14px;  font-weight: bold;  color: #FF0000;  }
        span.ok{  font-size: 14px;  font-weight: bold;  color: #38D63B;  }
    </style>
</head>
<body>
<div class="div_head">
    <span>
        <span style="float:left;font-weight: bolder">新建订单</span>
        <span style="float:right;margin-right: 8px;font-weight: bold">
            <a style="text-decoration: none" href="<?php echo U('order_list');?>">【返回】</a>
        </span>
    </span>
</div>
<div></div>
<div style="font-size: 13px;margin: 10px 5px">
    <form action="<?php echo U('Admin/Order/add_order');?>" id="form1" method="post">
        <table style="border:1px solid rgb(194, 230, 245)" width="100%" class="table_a">
            <tr style="height: 25px;color: #536aff;font-weight: bolder">
                <td>客户信息:</td>
                <td>用户信息:</td>
            </tr>
            <tr>
                <td class="td ">
                    <div  id="copy">
                        客户姓名：<input type="text" id="account" name="truename" value=""/>
                        <select id="sex" name="user_sex" style="height: 25px">
                            <option value="0">男</option>
                            <option value="1">女</option>
                        </select><br>
                        联系电话：<input type="text" id="tel" name="phone" value=""/>
                        <input type="reset" value="清除"/>
                    </div>
                    <span onclick="fuzhi_stu()" style="color: #536aff;cursor: pointer;">复制学员 =></span>
                    <script>
                        function fuzhi_stu(){
                            var account = $("#account").val();
                            var tel = $("#tel").val();
                            var sex = $("#sex").val();
                            var str = '';
                            str += '<div>学员姓名：<input type="text" value="'+account+'" name="account[]"/>';
                            str += ' <select style="height: 25px" name="sex[]"> ';
                            if(sex == 0){
                                str += '<option value="0" selected>男</option> ';
                                str += '<option value="1">女</option>';
                            }else{
                                str += '<option value="0">男</option> ';
                                str += '<option value="1" selected>女</option>';
                            }
                            str += '</select>联系电话：<input type="text" value="'+tel+'" name="tel[]"/>' +
                                    '<span class="delete_stu" style="color:#536aff;cursor: pointer; ">删除</span> </div>'
                            $(".add_stu").prepend(str);
                            $('.delete_stu').on('click',function(){
                                var a = $(this);
                                a.parent('div').hide();
                                a.parent('div').html('');
                            });
//                            $("#account").val('');
//                            $("#tel").val('');
                        }
                    </script>
                </td>
                <td class="td  add_stu">
                    <!--<div>-->
                        <!--学员姓名：<input type="text" value="" name="account[]"/>-->
                        <!--<select style="height: 25px" name="sex[]"> <option value="0">男</option> <option value="1">女</option></select>-->
                         <!--联系电话：<input type="text" value="" name="tel[]"/><span class="delete_stu"  style="color:#536aff;cursor: pointer; ">删除</span>-->
                    <!--</div>-->
                    <span onclick="add_stu()" style="color: #536aff;cursor: pointer;">+添加学员</span><br>
                    <script>
                        function add_stu(){
                            $(".add_stu").prepend(' <div>学员姓名：<input type="text" value="" name="account[]"/>' +
                           '<select style="height: 25px" name="sex[]"> <option value="0">男</option> <option value="1">女</option></select>' +
                           ' 联系电话：<input type="text" value="" name="tel[]"/>' +
                           '<span class="delete_stu" style="color:#536aff;cursor: pointer; ">删除</span> </div>');
                            $('.delete_stu').on('click',function(){
                                var a = $(this);
                                a.parent('div').hide();
                                a.parent('div').html('');
                            });
                        }
                    </script>
                    所在位置：
                    <select name="cityid" id="city">
                    <?php if(is_array($citys)): $i = 0; $__LIST__ = $citys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($cityid==$v['id']?'selected':''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                    区/县<select name="countyname" id="county" >
                    <?php if(is_array($countys)): $i = 0; $__LIST__ = $countys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["countyname"]); ?>" <?php echo ($countyid==$v['id']?'selected':''); ?>><?php echo ($v["countyname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                    <input type="text" name="address" />
                </td>
            </tr>
            <tr style="height: 15px"></tr>
            <tr style="height: 25px;color: #536aff;font-weight: bolder"><td colspan="2">意向课程：</td></tr>
            <tr>
                <td colspan="2"  class="td">选择订单类型：
                    <select name="order_type" id="order_type">
                        <option value=1 >驾校订单</option>
                        <option value=2 >教练订单</option>
                        <option value=3 >指导员订单</option>
                        <option value=4 >计时预约订单</option>
                        <option value=5 >人工订单</option>
                    </select>
                    驾校：<select id ='jx' name="jx"  data-live-search="true" >
                        <option value="0">517驾校</option>
                        <?php if(is_array($school)): $i = 0; $__LIST__ = $school;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    教练：<select id ='jl' name="jl"  data-live-search="true" >
                        <option value="0">请选择</option>
                        <?php if(is_array($coach)): $i = 0; $__LIST__ = $coach;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    指导员：<select id ='zd' name="zd" data-live-search="true">
                        <option value="0">请选择</option>
                        <?php if(is_array($guider)): $i = 0; $__LIST__ = $guider;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($list['school_id']==$v['id']?'selected':''); ?>><?php echo ($v["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="td">选择基地：
                    <select name="trainaddress" id="train">
                        <option value='517基地' >517基地</option>
                    </select>

                </td>
            </tr>
            <tr>
                <td colspan="2" class="td">选择课程：
                    <select name="class_name" id="class">
                        <option value='C1照全包' >C1照全包</option>
                    </select>
                </td>
            </tr>
            <tr style="height: 15px"></tr>
            <tr style="height: 25px;color: #536aff;font-weight: bolder"><td colspan="2">付款信息：</td></tr>
            <tr>
                <td colspan="2" class="td">下单类型：
                    <select name="type">
                        <option value=1 >全款</option>
                        <option value=2 selected>预付款</option>
                    </select>
                    下单价格：
                    <input type="text" name="price" value="0"/>
                    实际支付：
                    <input type="text" name="total_fee" value="0"/>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="td">支付类型：
                    <select name="pay_type">
                        <option value='0' >未支付</option>
                        <option value='1' >支付宝</option>
                        <option value='2' >微信</option>
                        <option value='3' >门店</option>
                        <!--<option value=3 >银联</option>-->
                    </select>
                </td>
            </tr>
            <tr style="height: 15px"></tr>
            <tr style="height: 25px;color: #536aff;font-weight: bolder;"><td  colspan="2" >订单来源：</td></tr>
            <tr style="height: 25px;font-weight: bolder">
                <td colspan="2">来源：
                    <input type="radio" value="0" name="order_source"/>百度广告
                    <input type="radio" value="1" name="order_source"/>广点通
                    <input type="radio" value="2" name="order_source"/>呼损
                    <input type="radio" value="3" name="order_source"/>百度
                    <input type="radio" value="4" name="order_source"/>神马
                    <input type="radio" value="5" name="order_source"/>360搜索
                    <input type="radio" value="6" name="order_source"/>搜狗
                    <input type="radio" value="7" name="order_source"/>商桥
                    <input type="radio" value="8" name="order_source"/>线上其他
                    <input type="radio" value="9" name="order_source"/>地铁广告
                    <input type="radio" value="10" name="order_source"/>地铁客服
                    <input type="radio" value="11" name="order_source"/>淘宝
                    <input type="radio" value="12" name="order_source"/>单页
                    <input type="radio" value="13" name="order_source"/>册子
                    <input type="radio" value="14" name="order_source" checked/>线下其他
                    <input type="radio" value="15" name="order_source"/>移动端
                </td>
            </tr>
            <tr style="height: 15px"></tr>
            <tr style="height: 25px;color: #536aff;font-weight: bolder"><td  colspan="2" >订单备注：</td></tr>
            <tr>
                <td  colspan="2" >
                    <label for=""  style="margin-bottom: 20px">备注：</label>
                    <textarea name="customer_inform" id="" cols="40" rows="2"></textarea><br>
                    设置回访日期: <input type="text" onClick="WdatePicker()" name="return_time"/>　
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input id="add_order" type="submit" value="添加">
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
<script>
    $("#city").change(function(){
        $("#cityname").val($("#city option:selected").val());
        $(".cityname").val($("#city option:selected").text());
        $.post("<?php echo U('LandMark/returncounty');?>", {cityid:$("#city option:selected").val()}, function(data,status){
            $("#county").html("");
            for(i=0;i<data.info.length;i++){
                $("#countyname").val(data.info[0].countyname);
                $(".countyname").val(data.info[0].countyname);
                $("#county").append("<option value="+data.info[i].countyname+">"+data.info[i].countyname+"</option>");//在后面追加
            }
        });
    });
</script>