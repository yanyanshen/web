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
                <a href="<?php echo U('Mobile/cyclope/baike');?>">
                    <li class="back" style="padding-right: 50px">
                        <img src="/Public/public/images/back.png">
                    </li>
                </a>

                <li class="header_text">百科-科目
                    <?php if($kemu == 1): ?>一
                        <?php elseif($kemu == 2): ?>
                        二
                        <?php elseif($kemu == 3): ?>
                        三
                        <?php else: ?>
                        四<?php endif; ?>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="baike-box">
                <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div class="kemuyi-list" >
                        <div class="kemuyi-list-img-box">
                            <div class="kemuyi-list-img">
                                <a href="<?php echo U('Mobile/Cyclope/baike_detail');?>?id=<?php echo ($v['id']); ?>&kemu=<?php echo ($kemu); ?>">
                                    <img style="border-radius:3px;" src="<?php echo ($v["picurl"]); ?>">
                                </a>
                            </div>
                        </div>
                        <div class="kemuyi-list-text-box">
                                <ul class="kemuyi-list-text">
                                    <li class="kemuyi-list-head">
                                        <a href="<?php echo U('Mobile/Cyclope/baike_detail');?>?id=<?php echo ($v['id']); ?>&kemu=<?php echo ($kemu); ?>"><?php echo ($v["title"]); ?></a>
                                    </li>
                                    <li class="kemuyi-list-note">
                                        <a href="<?php echo U('Mobile/Cyclope/baike_detail');?>?id=<?php echo ($v['id']); ?>&kemu=<?php echo ($kemu); ?>">
                                            <?php echo ($v["title"]); ?>
                                        </a>
                                    </li>
                                    <li class="kemuyi-list-time">浏览量：<?php echo ($v['count']); ?></li>
                                    <li class="kemuyi-list-time"><?php echo date('Y-m-d H:i:s',$v['ntime']);?></li>
                                </ul>
                        </div>
                        <div class="clearfix"></div>
                    </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </div>
        </div>
    </div>

</div>

</body>
</html>