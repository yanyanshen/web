<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>百科</title>
    <link href="/Public/website/Mobile/cyclope/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/cyclope/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/cyclope/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/cyclope/css/baike.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="pagewrap">
    <div class="header_box">
        <div class="header">
            <ul>
                <a href="<?php echo U('Mobile/Index/index');?>">
                    <li class="back" style="padding-right: 50px">
                        <img src="/Public/public/images/back.png">
                    </li>
                </a>

                <li class="header_text">百科</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>

    <div class="main_box">
        <div class="main">
            <div class="baike-box">
                <div class="hot-topic">
                    <ul><li>热门话题</li></ul>
                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Mobile/Cyclope/baike_detail',array('id'=>$v['id'],'kemu'=>$v['type']));?>">
                            <div class="topic1">
                                <div class="topic-img"><img src="<?php echo ($v['picurl']); ?>"></div>
                                <p style="text-align: center"><?php echo (mb_substr($v['title'],0,8,utf8)); ?>...</p>
                            </div>
                        </a><?php endforeach; endif; else: echo "" ;endif; ?>
                    <div class="clearfix"></div>
                </div>
                <div class="hot-sort1">
                    <ul><li>热门分类</li></ul>
                    <a href="<?php echo U('Mobile/Cyclope/kemu');?>?kemu=1">
                        <div class="sort-h">
                            <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike01.png"></div>
                            <p>科目一</p>
                        </div>
                    </a>
                    <a href="<?php echo U('Mobile/Cyclope/kemu');?>?kemu=2">
                        <div class="sort-h">
                            <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike02.png"></div>
                            <p>科目二</p>
                        </div>
                    </a>
                    <a href="<?php echo U('Mobile/Cyclope/kemu');?>?kemu=3">
                        <div class="sort-h">
                            <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike03.png"></div>
                            <p>科目三</p>
                        </div>
                    </a>
                    <a href="<?php echo U('Mobile/Cyclope/kemu');?>?kemu=4">
                        <div class="sort-h">
                            <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike04.png"></div>
                            <p>科目四</p>
                        </div>
                    </a>
                    <div class="sort-h">
                        <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike05.png"></div>
                        <p>学车趣事</p>
                    </div>
                    <div class="sort-h">
                        <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike06.png"></div>
                        <p>学车技巧</p>
                    </div>
                    <div class="sort-h">
                        <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike07.png"></div>
                        <p>教练秘诀</p>
                    </div>
                    <div class="sort-h">
                        <div class="sort-img"><img src="/Public/website/Mobile/cyclope/images/baike08.png"></div>
                        <p>新手上路</p>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="hot-new" style="margin-bottom: 10px">
                    <ul><li>热门资讯</li></ul>
                    <?php if(is_array($Hnew)): $i = 0; $__LIST__ = $Hnew;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="Hnew">
                            <a href="<?php echo U('Mobile/Cyclope/baike_detail',array('id'=>$v['id'],'kemu'=>$v['type']));?>">
                                <ul>
                                    <li class="new-img">
                                        <img src="<?php echo ($v['picurl']); ?>" alt=""/>
                                    </li>
                                    <li class="new-title">
                                        <h1><?php echo ($v["title"]); ?></h1>
                                        <ul>
                                            <li class="new-browse">浏览量：<span><?php echo ($v['count']); ?></span></li>
                                            <li class="new-time"><?php echo date('Y-m-d',$v['ntime']);?></li>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </li>
                                    <div class="clearfix"></div>
                                </ul>
                            </a>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
    </div>

    <footer id="footer">
        <ul>
            <a href="<?php echo U('Mobile/Index/index');?>">
                <li class="foot">
                    <img src="/Public/website/Mobile/cyclope/images/icon-footer1-a.png">
                    <p>首页</p>
                </li>
            </a>
            <a href="<?php echo U('Mobile/Language/language_list');?>">
                <li class="foot">
                    <img src="/Public/website/Mobile/list/images/icon-footer2-a.png">
                    <p>语言</p>
                </li>
            </a>
            <a href="<?php echo U('Mobile/List/pull');?>">
                <li class="foot">
                    <img src="/Public/website/Mobile/list/images/icon-footer3-a.png">
                    <p>驾校</p>
                </li>
            </a>
            <a href="<?php echo U('Mobile/Cyclope/baike');?>">
                <li class="foot">
                    <img src="/Public/website/Mobile/list/images/icon-footer04-a.png">
                    <p style="color: #fa7124; font-weight: bold;">百科</p>
                </li>
            </a>
            <a href="<?php echo U('Mobile/User/user_center');?>">
                <li class="foot">
                    <img src="/Public/website/Mobile/list/images/icon-footer5-a.png">
                    <p>我的</p>
                </li>
            </a>
        </ul>
    </footer>
</div>

</body>
</html>