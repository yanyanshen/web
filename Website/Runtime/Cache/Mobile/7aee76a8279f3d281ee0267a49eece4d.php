<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>理论学习</title>
    <link href="/Public/website/Mobile/theory_study/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/theory_study.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
</head>

<body>

<div id="pagewrap">

    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/Index/index');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">理论学习</li>
                <li class="sort">
                    <a href="<?php echo U('Mobile/Exam/driver_type');?>">
                        <?php echo ($mt?$mt:'C1'); ?> <?php echo ($ms?$ms:'科目一'); ?>
                        <span style="display: none;" id="span1"><?php echo ($mtid?$mtid:1); ?></span>
                        <span style="display: none;"  id="span2"><?php echo ($msid?$msid:1); ?></span>
                    </a>
                    <img src="/Public/website/Mobile/theory_study/images/bottom.png">
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>

    <div class="main_box">
        <div class="main">
        <div class="theory_study">
            <div class="simulation">
                <div class="simulation_a"><a id="theory1" href="javascript:;">
                    <img src="/Public/website/Mobile/theory_study/images/simulation.png" alt=""/><h2>全真模拟</h2></a>
                </div>
                <script>
                    $(function(){
                        $('#theory1').click(function(){
                            var mt=$("#span1").text();
                            var ms=$("#span2").text();
                            location.href="<?php echo U('Mobile/Simulate/test_system');?>?mt="+mt+"&ms="+ms;
                        })
                    })
                </script>
            </div>
            <div class="study_box">
                <ul>
                    <li>
                        <a id="theory2" href="javascript:;">
                            <img src="/Public/website/Mobile/theory_study/images/chapter.png" alt=""/>
                            <h2>章节练习</h2>
                        </a>
                    </li>
                    <script>
                        $(function(){
                            $('#theory2').click(function(){
                                var mt=$("#span1").text();
                                var ms=$("#span2").text();
                                location.href="<?php echo U('Mobile/Exam/chapter');?>?mt="+mt+"&ms="+ms;
                            })
                        })
                    </script>
                    <li>
                        <a id="theory3" href="javascript:;">
                            <img src="/Public/website/Mobile/theory_study/images/analyze.png" alt=""/>
                            <h2>试题分析</h2>
                        </a>
                    </li>
                    <script>
                        $(function(){
                            $('#theory3').click(function(){
                                var mt=$("#span1").text();
                                var ms=$("#span2").text();
                                location.href="<?php echo U('Mobile/Exam/test_analysis');?>?mt="+mt+"&ms="+ms;
                            })
                        })
                    </script>
                    <li>
                        <a id="theory4" href="javascript:;">
                            <img src="/Public/website/Mobile/theory_study/images/worry.png" alt=""/>
                            <h2>我的错题</h2>
                        </a>
                    </li>
                    <script>
                        $(function(){
                            $('#theory4').click(function(){
                                var ms=$("#span2").text();
                                location.href="<?php echo U('Mobile/Exam/wrong_topic');?>?ms="+ms;
                            })
                        })
                    </script>
                    <li>
                        <a id="theory5" href="javascript:;">
                            <img src="/Public/website/Mobile/theory_study/images/user_topic.png" alt=""/>
                            <h2>我的题库</h2>
                        </a>
                    </li>
                    <script>
                        $(function(){
                            $('#theory5').click(function(){
                                var mt=$("#span1").text();
                                var ms=$("#span2").text();
                                location.href="<?php echo U('Mobile/Exam/chapter');?>?mt="+mt+"&ms="+ms+"&mc="+1;
                            })
                        })
                    </script>
                    <div class="clearfix"></div>
                </ul>
            </div>
        </div>

        <footer id="footer">
            <ul>
                <li class="foot_box">
                    <a href="<?php echo U('Mobile/Order/apply');?>">
                        <p style="padding: 8% 3%">预约报名</p>
                    </a>
                </li>
                <li class="foot_box">
                    <a href="">
                        <p style="padding: 8% 3%">免费咨询</p>
                    </a>
                </li>
            </ul>
        </footer>

        <div class="call_box">
            <a href="tel:4008040517">
                <img src="/Public/website/Mobile/theory_study/images/phone.png">
            </a>
        </div>
        <div class="sms_box">
            <a href="">
                <img src="/Public/website/Mobile/theory_study/images/sms.png">
            </a>
            <!--<a href="sms:18688888888">发短�?/a>-->
        </div>
    </div>
    </div>
</div>

</body>
</html>