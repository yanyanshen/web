<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>驾考资讯</title>
    <link href="/Public/website/Mobile/consult/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/consult/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/consult/css/studyNew.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>

<body>
<style type="text/css">
    .bdsharebuttonbox a { width: 30px!important; height: 30px!important; margin: 0 auto 10px!important; float: none!important; padding: 0!important; display: block; }
    .bdsharebuttonbox a img { width: 30px; height: 30px; }
    .bdsharebuttonbox .bds_tsina { background: url(/Public/website/Mobile/consult/images/gbRes_6.png) no-repeat center center/30px 30px; }
    .bdsharebuttonbox .bds_qzone { background: url(/Public/website/Mobile/consult/images/gbRes_4.png) no-repeat center center/30px 30px; }
    .bdsharebuttonbox .bds_tqq { background: url(/Public/website/Mobile/consult/images/gbRes_5.png) no-repeat center center/30px 30px; }
    .bdsharebuttonbox .bds_weixin { background: url(/Public/website/Mobile/consult/images/gbRes_2.png) no-repeat center center/30px 30px; }
    .bdsharebuttonbox .bds_sqq { background: url(/Public/website/Mobile/consult/images/gbRes_3.png) no-repeat center center/30px 30px; }
    .bd_weixin_popup .bd_weixin_popup_foot { position: relative; top: -12px; }
</style>

<div class="login_box">
    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back">
                    <a href="<?php echo U('Mobile/Consult/studyNew');?>">
                        <img src="/Public/public/images/back.png">
                    </a>
                </li>
                <li class="header_text">驾考资讯</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="studyNew">
                <div class="new">
                    <h1 class="title"><?php echo ($info["title"]); ?></h1>
                    <ul>
                        <li class="dates"><?php echo date('Y.m.d',$info.ntime);?></li>
                        <li class="view">浏览量：<?php echo ($info["touch_count"]); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <img src="<?php echo ($http); ?>/Uploads/Consult_logo/<?php echo ($info["picurl"]); echo ($info["picname"]); ?>" width="80%">
                    <p>
                        <?php echo ($info["content"]); ?>
                    </p>
                    <div class="gb_resLay">
                        <div class="gb_res_t"><span>分享</span><i></i></div>
                        <div class="bdsharebuttonbox">
                            <ul class="gb_resItms">
                                <li> <a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin" ></a>微信好友 </li>
                                <li> <a title="分享到QQ好友" href="#" class="bds_sqq" data-cmd="sqq" ></a>QQ好友 </li>
                                <li> <a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone" ></a>QQ空间 </li>
                                <li> <a title="分享到腾讯微博" href="#" class="bds_tqq" data-cmd="tqq" ></a>腾讯微博 </li>
                                <li> <a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina" ></a>新浪微博 </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript">
    var ShareURL = "";
    $(function () {
        $(".bdsharebuttonbox a").mouseover(function () {
            ShareURL = $(this).attr("data-url");
        });
    });

    function SetShareUrl(cmd, config) {
        if (ShareURL) {
            config.bdUrl = ShareURL;
        }
        return config;
    }

    window._bd_share_config = {
        "common": {
            onBeforeClick: SetShareUrl, "bdSnsKey": {}, "bdText": ""
            , "bdMini": "2", "bdMiniList": false, "bdPic": "http://assets.jq22.com/plugin/2017-05-24-18-14-49.png", "bdStyle": "0", "bdSize": "24"
        }, "share": {}
    };

    with (document) 0[(getElementsByTagName('head')[0] || body)
            .appendChild(createElement('script'))
            .src = 'http://bdimg.share.baidu.com/static/api//Public/website/Mobile/js/share.js?v=89860593.js?cdnversion='
            + ~(-new Date() / 36e5)];
</script>


</body>
</html>