<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>章节练习</title>
    <link href="/Public/website/Mobile/theory_study/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/theory_study.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>

</head>

<body>

<div id="pagewrap">

    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/Exam/theory_study');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">
                    <?php if($mc == 1): ?>我的题库
                        <?php else: ?>
                        章节练习<?php endif; ?>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>

    <div class="main_box">
        <div class="main">
            <div class="theory_study">
                <div class="chapter_box">
                    <ul>
                        <?php if(is_array($sub)): $i = 0; $__LIST__ = $sub;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$sub): $mod = ($i % 2 );++$i; if($sub["chapter"] < 5): ?><li>
                                    <a href="<?php echo U('Mobile/Exam/chapter_practice',array('mt'=>$sub['type'],'ms'=>$sub['subject'],'mp'=>$sub['chapter'],'mc'=>$sub['mc']));?>"><div class="chapter_img"></div>
                                            <h2 class="chapter_h" ><?php echo ($sub["chapter"]); ?>. <?php echo ($sub["title"]); ?>(<?php echo ($sub["num"]); ?>)</h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </li><?php endif; ?>
                            <?php if($sub["chapter"] == 5 and $sub["num"] != 0 and $sub["subject"] == 1): ?><li>
                                    <a href="<?php echo U('Mobile/Exam/chapter_practice',array('mt'=>$sub['type'],'ms'=>$sub['subject'],'mp'=>$sub['chapter'],'mc'=>$sub['mc']));?>"><div class="chapter_img"></div>
                                        <h2 class="chapter_h" ><?php echo ($sub["chapter"]); ?>. <?php echo (session('city')); echo ($sub["title"]); ?>(<?php echo ($sub["num"]); ?>)</h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </li><?php endif; ?>

                            <?php if($sub["chapter"] == 5 and $sub["subject"] == 2): ?><li>
                                    <a href="<?php echo U('Mobile/Exam/chapter_practice',array('mt'=>$sub['type'],'ms'=>$sub['subject'],'mp'=>$sub['chapter'],'mc'=>$sub['mc']));?>"><div class="chapter_img"></div>
                                        <h2 class="chapter_h" ><?php echo ($sub["chapter"]); ?>.<?php echo ($sub["title"]); ?>(<?php echo ($sub["num"]); ?>)</h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </li><?php endif; ?>

                            <?php if($sub["chapter"] == 6 and $sub["num"] != 0 and $sub["subject"] == 1): ?><li>
                                    <a href="<?php echo U('Mobile/Exam/chapter_practice',array('mt'=>$sub['type'],'ms'=>$sub['subject'],'mp'=>$sub['chapter'],'mc'=>$sub['mc']));?>"><div class="chapter_img"></div>
                                        <h2 class="chapter_h" ><?php echo ($sub["chapter"]); ?>. <?php echo ($sub["title"]); ?>(<?php echo ($sub["num"]); ?>)</h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </li><?php endif; ?>

                            <?php if($sub["chapter"] == 6 and $sub["subject"] == 2): ?><li>
                                    <a href="<?php echo U('Mobile/Exam/chapter_practice',array('mt'=>$sub['type'],'ms'=>$sub['subject'],'mp'=>$sub['chapter'],'mc'=>$sub['mc']));?>"><div class="chapter_img"></div>
                                        <h2 class="chapter_h" ><?php echo ($sub["chapter"]); ?>. <?php echo ($sub["title"]); ?>(<?php echo ($sub["num"]); ?>)</h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </li><?php endif; ?>
                            <?php if($sub["chapter"] == 7 and $sub["num"] != 0 and $sub["subject"] == 1): ?><li>
                                    <a href="<?php echo U('Mobile/Exam/chapter_practice',array('mt'=>$sub['type'],'ms'=>$sub['subject'],'mp'=>$sub['chapter'],'mc'=>$sub['mc']));?>"><div class="chapter_img"></div>
                                        <h2 class="chapter_h" >6. <?php echo ($sub["title"]); ?>(<?php echo ($sub["num"]); ?>)</h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </li><?php endif; ?>

                            <?php if($sub["chapter"] == 7 and $sub["subject"] == 2): ?><li>
                                    <a href="<?php echo U('Mobile/Exam/chapter_practice',array('mt'=>$sub['type'],'ms'=>$sub['subject'],'mp'=>$sub['chapter'],'mc'=>$sub['mc']));?>"><div class="chapter_img"></div>
                                        <h2 class="chapter_h" >6. <?php echo ($sub["title"]); ?>(<?php echo ($sub["num"]); ?>)</h2>
                                        <div class="clearfix"></div>
                                    </a>
                                </li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>