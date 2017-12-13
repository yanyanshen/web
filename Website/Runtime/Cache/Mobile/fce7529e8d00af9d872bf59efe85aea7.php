<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>追加评价</title>
    <link href="/Public/website/Mobile/evaluate/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/evaluate/css/evaluate.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/Public/website/Mobile/evaluate/css/style.css">
    <link rel="stylesheet" type="text/css" href="/Public/website/Mobile/evaluate/starability-minified/normalize.css" />
    <link rel="stylesheet" type="text/css" href="/Public/website/Mobile/evaluate/starability-minified/htmleaf-demo.css">
    <link rel="stylesheet" type="text/css" href="/Public/website/Mobile/evaluate/starability-minified/starability-all.min.css"/>
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
</head>
<body>
<div id="pagewrap">
    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/User/order_center');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">追加评价</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="evaluate_box">
                <form class="form_box" id="form1">
                    <input type="hidden" name="oid" value="<?php echo ($oid); ?>"/>
                    <input type="hidden" name="eid" value="<?php echo ($info["id"]); ?>"/>
                    <textarea id="t" class="evaluate_input" name="content">请输入追加信息(注意：不能添加表情)</textarea>
                    <div class="submit_box">
                        <input type="button" class="submit_eval cd-popup-trigger" value="提交评价"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    var t = document.getElementById('t');
    t.onfocus = function(){
        if(this.innerHTML == '请输入追加信息(注意：不能添加表情)'){this.innerHTML = ''}
    };
    t.onblur = function(){
        if(this.innerHTML == ''){
            this.innerHTML = '请输入追加信息(注意：不能添加表情)'
        }
    };
    jQuery(document).ready(function($){
        //查看弹出
        $('.cd-popup-trigger').on('click', function(event){
            $(this).attr('disabled',true);
            $.post("<?php echo U('Mobile/Evaluate/evaluate_until');?>",$('#form1').serialize(),function(res){
                if(res.status == 0){
                    layer.open({
                        content: res.info
                        ,style: "background-color:#E7F0FA; color:white;font-size:16px; border:none;" //自定风格
                        ,time: 2
                        ,end: function(){
                            location.href = res.url;
                        }
                    });
                }else{
                    layer.open({
                        content: res.info
                        ,style: "background-color:#E7F0FA; color:white;font-size:16px; border:none;" //自定风格
                        ,time: 2
                        ,end: function(){
                            location.href = res.url;
                        }
                    });
                }
            },'json');
        });
    });
</script>
</body>
</html>