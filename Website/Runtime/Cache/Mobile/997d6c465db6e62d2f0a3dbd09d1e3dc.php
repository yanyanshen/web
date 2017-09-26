<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>马上报名</title>
    <link href="/Public/website/Mobile/order/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/apply.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/loginRegister/login.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/loginRegister/media-queries-login.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/jquery.form.js"></script>
    <script src="/Public/public/js/jquery.validate.js"></script>
    <style>
        input.error { background: #ffdbb3;}
        span.error{position: absolute;color:#ff0300;display: block;font-weight: bold;font-size: 12px;  }
        span.ok {color: #289628;}
    </style>
</head>
<script>
    $(function(){
        //validate表单验证
        var validate=$('#form1').validate({
            //设置验证规则
            rules:{
                tel:{
                    required:true,
                    tel:true
                },
                name:{ required:true},
                address:{ required:true}
            },
            messages: {
                tel: {required: '手机号不能为空'},
                name: {required: '用户名不能为为空'},
                address: {required: '地址不能为空'}
            },
            success: function(span) {
                span.addClass("ok").text('OK');
            },
            validClass:'ok',
            errorElement:'span'
        });
        // 手机号码验证
        jQuery.validator.addMethod("tel", function(value, element) {
            var mobileReg = /^1[34578]{1}[0-9]{9}$/;
            return this.optional(element) || (mobileReg.test(value));
        }, "请正确填写您的手机号");
    })
</script>
<body>
<div id="pagewrap">
    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back">
                    <a href="<?php echo ($url); ?>">
                    <img src="/Public/public/images/back.png">
                    </a>
                </li>
                <li class="header_text">马上报名</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <form class="apply_form" action="<?php echo U('Mobile/Order/pay');?>" method="post" id="form1">
        <div class="main_box">
            <div class="main">
                <input type="hidden" name="class_id" value="<?php echo ($class_id); ?>"/>
                <input type="hidden" name="id" value="<?php echo ($id); ?>"/>
                <div class="apply">
                    <label class="label">真实姓名</label>
                    <input class="user" type="text" name="name" placeholder="请输入真实姓名" required>
                </div>
                <div class="apply">
                    <label class="label">性别</label>
                    <input type="radio" name="sex"  value="0" required checked>男&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="sex"  value="1">女
                </div>
                <div class="apply">
                    <label class="label">报名人数</label>
                    <input class="user" type="text" name="num" value="1" placeholder="1" >
                </div>
                <div class="apply">
                    <label class="label">联系电话</label>
                    <input class="tel" type="text" name="tel" placeholder="请输入电话号码" required>
                </div>
                <div class="apply">
                    <label class="label">驾校名称</label>
                    <input class="user" style="background: none" type="text" name="nickname" value="<?php echo ($nickname); ?>" disabled="disabled">
                </div>
                <?php if(!empty($gui_coa)): ?><div class="apply">
                        <label class="label">教练/指导员：</label>
                        <input class="user" style="background: none" type="text" name="gui_coa" value="<?php echo ($gui_coa); ?>" disabled="disabled">
                    </div><?php endif; ?>
                <div class="apply">
                    <label class="label">培训课程</label>
                    <a class="user" href="<?php echo U('Mobile/Order/choose_course',array('id'=>$id));?>">
                        <?php echo ($name['name']); ?>
                        <?php if($name["week"] == 1): ?>（本周特价）<?php endif; ?>
                        <?php if($name["recommand"] == 1): ?>（推荐）<?php endif; ?>
                        <?php if($name["hot"] == 1): ?>（热门）<?php endif; ?>
                    </a>
                </div>
                <div class="apply" style="height: 80px">
                    <label class="apply_order">报名方式</label>
                    <ul class="apply_od">
                        <li>
                            <input type="radio" name="type" value="1" required checked>
                            <label>付全款报名 <span><?php echo ($name['wholeprice']); ?>元</span></label>
                        </li>
                        <li>
                            <input type="radio" name="type" value="2" required>
                            <label>预付费报名 <span><?php echo ($name['advanceprice']); ?>元</span></label>
                        </li>
                        <div class="clearfix"></div>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="apply">
                    <label class="label">地址</label>
                    <input class="city_position" type="text" name="address" placeholder="请输入所在地址" required>
                </div>
                <div class="apply">
                    <label class="ap_note">备注</label>
                    <input class="message" type="text" name="inform" placeholder="更多">
                </div>
            </div>
        </div>

    <footer id="footer">
        <div class="apply_submit">
            <input type="submit"   id="btn2" value="马上报名">
        </div>
    </footer>
    </form>
</div>


</body>
</html>