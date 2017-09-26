<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>个人中心</title>
    <link href="/Public/website/Mobile/user/user_center/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/loginRegister/user_center.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/loginRegister/login.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/loginRegister/media-queries-login.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>

</head>

<body>

<div id="pagewrap">


    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/Index/index');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">个人中心</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="user_top">
                <div class="user_header"><img src="/Public/website/Mobile/user/user_center/images/header1.jpg"></div>
                <div class="user_name"><h1><?php echo ($user["truename"]); ?></h1></div>
                <div class="user_tel"><h2 id="tel"><?php echo ($user["account"]); ?></h2></div>
            </div>
            <div class="user_order">
                <div class="order_center">
                    <div class="order_img"><img src="/Public/website/Mobile/user/user_center/images/order.png"></div>
                    <a href="<?php echo U('Mobile/User/order_center');?>">订单中心</a>
                    <div class="order_back"><img src="/Public/website/Mobile/user/user_center/images/back1.png"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="order_center">
                    <div class="order_img"><img src="/Public/website/Mobile/user/user_center/images/record.png"></div>
                    <a href="<?php echo U('Mobile/User/order_apply');?>">预约报名记录</a>
                    <div class="order_back"><img src="/Public/website/Mobile/user/user_center/images/back1.png"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="order_center">
                    <div class="order_img"><img src="/Public/website/Mobile/user/user_center/images/guide.png"></div>
                    <a href="<?php echo U('Mobile/User/study_guide');?>">学车指南</a>
                    <div class="order_back"><img src="/Public/website/Mobile/user/user_center/images/back1.png"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="user_bottom">
                <div class="order_center">
                    <div class="order_img"><img src="/Public/website/Mobile/user/user_center/images/aboultUs.png"></div>
                    <a href="<?php echo U('Mobile/User/AboutUs');?>">关于我们</a>
                    <div class="order_back"><img src="/Public/website/Mobile/user/user_center/images/back1.png"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="order_center">
                    <div class="order_img"><img src="/Public/website/Mobile/user/user_center/images/privacy.png"></div>
                    <a href="<?php echo U('Mobile/User/privacy');?>">隐私条款</a>
                    <div class="order_back"><img src="/Public/website/Mobile/user/user_center/images/back1.png"></div>
                    <div class="clearfix"></div>
                </div>
                <div class="order_center">
                    <div class="order_img"><img src="/Public/website/Mobile/user/user_center/images/liability.png"></div>
                    <a href="">免责声明</a>
                    <div class="order_back"><img src="/Public/website/Mobile/user/user_center/images/back1.png"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="user_set">
                <div class="order_center">
                    <div class="order_img"><img src="/Public/website/Mobile/user/user_center/images/setUp.png"></div>
                    <a href="<?php echo U('Mobile/User/setUp');?>">设置</a>
                    <div class="order_back"><img src="/Public/website/Mobile/user/user_center/images/back1.png"></div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>



    <footer id="footer">
        <ul>
            <li class="foot_box">
                <a href="<?php echo U('Mobile/Order/apply');?>">
                    <p>预约报名</p>
                </a>
            </li>
            <li class="foot_box">
                <a href="">
                    <p>免费咨询</p>
                </a>
            </li>
        </ul>
    </footer>



</div>


</body>
</html>