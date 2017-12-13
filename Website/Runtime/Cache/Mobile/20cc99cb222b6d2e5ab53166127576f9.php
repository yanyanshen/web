<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>培训课程详情</title>
    <link href="/Public/website/Mobile/course_details/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/course_details/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/course_details/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/course_details/css/course_details.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<div id="pagewrap">
    <div class="header_box">
        <div class="header">
            <ul>
                <a href="<?php echo U('Mobile/Detail/index',array('id'=>$info['type_id']));?>">
                    <li class="back" style="padding-right: 50px">
                        <img src="/Public/public/images/back.png">
                    </li>
                </a>
                <li class="header_text">培训课程详情</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="course_details">
                <div class="course">
                    <h1><?php echo ($info['name']); ?></h1>
                    <p><?php echo ($info['name']); ?></p>
                    <ul>
                        <li>车型：<?php echo ($info["cartype"]); ?></li>
                        <li>官方价：<?php echo ($info["officeprice"]); ?>元</li>
                    </ul>
                    <ul style="margin-left: 30px;">
                        <li>班别：<?php echo ($info["class_type"]); ?></li>
                        <li>优惠价：<span style="color: #fa7124;font-weight: bold;"><?php echo ($info["wholeprice"]); ?>元</span></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="course_box">
                <h1>课程详情</h1>
                <div>
                    <p class="course_top">费用明细</p>
                    <ul class="money_1">
                        <li class="money_all">总学费</li>
                        <li class="include">包含</li>
                    </ul>
                    <ul class="money_1" style="width: 69%">
                        <li class="money_num"><?php echo ($info["wholeprice"]); ?>元</li>
                        <li>
                            <p class="include_text">
                                <?php echo ($info["include"]); ?>
                            </p>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div>
                    <p class="course_top">培训服务</p>
                    <ul class="money_3" style="text-align: center">
                        <li class="service">驾照类型</li>
                        <li class="service">教练车型</li>
                        <li class="service">排队时间</li>
                        <li class="service">学车课时</li>
                        <li class="service">接送方式</li>
                        <li class="service">练车方式</li>
                    </ul>
                    <ul class="money_4">
                        <li class="service_text"><?php echo ($info["jztype"]); ?></li>
                        <li class="service_text"><?php echo ($info["cartype"]); ?></li>
                        <li class="service_text"><?php echo ($info["waittime"]); ?></li>
                        <li class="service_text">科二：<?php echo ($info["class_time2"]); ?>课时 科三：<?php echo ($info["class_time3"]); ?>课时</li>
                        <li class="service_text">
                            <?php if($info["shuttle_way"] == 0): ?>不接送
                                <?php else: ?>
                                班车接送<?php endif; ?>
                        </li>
                        <li class="service_text">
                            <?php echo ($info["way"]); ?>
                        </li>
                    </ul>
                   <div class="clearfix"></div>
                </div>
            </div>
            <div class="text_box">
                <h1>我们的承诺</h1>
                <div class="text">
                    <p>1、支付成功，立即进入交规考试排队系统，为您节省约1周等待时间；<br>
                        2、517学车网全包价为驾校总部最低价，差价双倍退还；<br>
                        3、支付成功24小时内驾校教练与您确认体检安排；<br>
                        4、提供第三方监督及投诉处理体系，学车全程权益保障；<br>
                        5、全透明价格，学车全程无任何其他费用；<br>
                        6、杜绝索要"红包、请客、保险费"等不正当费用。
                    </p>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer">
        <div class="apply_submit">
            <a href="<?php echo U('Mobile/Detail/index',array('id'=>$info['type_id']));?>#detail">
                <input type="submit"  name="btn2" id="btn2" style="-webkit-appearance: none" value="马上报名">
            </a>
        </div>
    </footer>



</div>


</body>
</html>