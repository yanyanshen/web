<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>选择培训课程</title>
    <link href="/Public/website/Mobile/order/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/order/css/theory_study.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>

</head>

<body>

<div id="pagewrap">
    <form action="<?php echo U('Mobile/Order/apply_order');?>" method="post">
        <input type="hidden" value="<?php echo ($id); ?>" name="id"/>
        <div class="header_box" style="position: fixed;left: 0;top: 0;">
            <div class="header">
                <ul>
                    <li class="back"><a href="<?php echo ($url); ?>"><img src="/Public/public/images/back.png"></a></li>
                    <li class="header_text">选择培训课程</li>
                    <li class="sort">
                        <a href="javascript:;" style="color: #fa7124;">
                        </a>
                        <input type="submit" style="color: #fa7124;" value="完成" />
                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>
        <div class="main_box" style="margin-top: 60px;">
            <div class="main">
                <div class="subject_sort">
                    <div class="subject">
                        <h1 class="subject_top">培训课程</h1>
                        <ul class="subject_box">
                            <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li>
                                    <input type="radio" value="<?php echo ($v["id"]); ?>"  checked="checked"  name="sub_button">
                                    <label >
                                        <?php echo ($v["name"]); ?>
                                        <?php if($v["week"] == 1): ?>（本周特价）<?php endif; ?>
                                        <?php if($v["recommand"] == 1): ?>（推荐）<?php endif; ?>
                                        <?php if($v["hot"] == 1): ?>（热门）<?php endif; ?>
                                    </label>
                                </li><?php endforeach; endif; else: echo "" ;endif; ?>
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
<script>
    $(function() {
        $('label').click(function(){
            var radioId = $(this).attr('name');
            $('label').removeAttr('class') && $(this).attr('class', 'checked');
            $('input[type="radio"]').removeAttr('checked') && $('#' + radioId).attr('checked', 'checked');
        });
    });
</script>