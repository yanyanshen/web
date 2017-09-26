<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>预约报名记录</title>
    <link href="/Public/website/Mobile/user/user_center/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/order_apply.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
</head>

<body>

<div id="pagewrap">

    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/User/user_center');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">预约报名记录</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="list_box">
                <?php if(is_array($apply_info)): $i = 0; $__LIST__ = $apply_info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="list_apply">
                        <ul>
                            <li class="li_name"><?php echo ($v['truename']); ?></li>
                            <li class="li_sex"><?php echo ($v['sex']==0?'男':'女'); ?></li>
                            <li class="li_num"><?php echo ($v['phone']); ?></li>
                            <li class="li_date"><?php echo date('Y.m.d',$v['time']);?></li>
                            <div class="clearfix"></div>
                        </ul>
                        <div class="address">地址：<span class="address_span"><?php echo ($v['address']); ?></span></div>
                    </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </div>
        </div>
    </div>

</div>


</body>
</html>