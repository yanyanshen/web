<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>驾照类型</title>
    <link href="/Public/website/Mobile/theory_study/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/theory_study.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<div id="pagewrap">
    <form action="<?php echo U('Mobile/Exam/theory_study');?>" method="post">
        <div class="header_box" style="position: fixed;left: 0;top: 0;">
            <div class="header">
                <ul>
                    <li class="back">
                        <a href="<?php echo U('Mobile/Exam/theory_study');?>">
                           <img src="/Public/public/images/back.png">
                        </a>
                    </li>
                    <li class="header_text">驾照类型</li>
                    <li class="sort">
                        <input type="submit" value="完成">
                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
        <div class="main_box" style="margin-top: 60px;">
            <div class="main">
                <div class="subject_sort">
                    <div class="subject">
                        <h1 class="subject_top">考试科目</h1>
                        <ul class="subject_box">
                            <li>
                                <input type="radio" value="科目一" name="sub_button" checked>
                                <label>科目一</label>
                            </li>
                            <li>
                                <input type="radio" value="科目四" name="sub_button">
                                <label>科目四</label>
                            </li>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                    <div class="subject">
                        <h1 class="subject_top">驾照类型</h1>
                        <ul class="subject_box">
                            <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;?><li>
                                    <?php if($type["id"] == 1): ?><input type="radio" value="<?php echo ($type["jztype"]); ?>" name="sub_button1" checked>
                                        <?php else: ?>
                                        <input type="radio" value="<?php echo ($type["jztype"]); ?>" name="sub_button1"><?php endif; ?>
                                    <label><?php echo ($type["jztype"]); ?></label>
                                </li><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                            <div class="clearfix"></div>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
</body>
</html>