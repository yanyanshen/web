<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en" xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>我要去学车—首页</title>
    <link href="/Public/website/Mobile/Index/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/Index/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/Index/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/public/js/banner/banner.css" rel="stylesheet" type="text/css">
    <link href="/Public/public/js/banner/cityPicker.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/banner/banner.js"></script>
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/Public/public/js/banner/Marquee.js"></script>
</head>
<body>
<div id="pagewrap">
    <div class="addWrap">
        <div class="swipe" id="mySwipe">
            <div class="swipe-wrap">
                <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><div>
                        <a href="<?php echo ($http); echo U($v['href']);?>">
                            <img class="img-responsive" src="<?php echo ($http); ?>/Uploads/Slideshow_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); ?>" width="400" height="143.75"/>
                        </a>
                    </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </div>
        </div>
        <ul id="position">
            <li class="cur"></li>
            <li class=""></li>
            <li class=""></li>
            <li class=""></li>
        </ul>
    </div>
    <script type="text/javascript">
        var bullets = document.getElementById('position').getElementsByTagName('li');
        var banner = Swipe(document.getElementById('mySwipe'), {
            auto: 2000,
            continuous: true,
            disableScroll:false,
            callback: function(pos) {
                var i = bullets.length;
                while (i--) {
                    bullets[i].className = ' ';
                }
                bullets[pos].className = 'cur';
            }
        });
    </script>

    <div id="header_box2">
        <div id="header2">
            <input type="text" class="city" style="" value="<?php echo (session('city')); ?>" readonly>
            <script type="text/javascript" src="/Public/website/Mobile/Index/js/cityPicker.js"></script>
            <script type="text/javascript">
                $(".city").CityPicker();
            </script>
            <div class="search_box" style="border-radius: 5px;margin-right: 5%;width:55%">
                <?php if($_SESSION['xueches_']['k']== ''): ?><input class="search" type="text" name="k" value="" placeholder="请输入驾校或街道" />
                    <?php else: ?>
                    <input class="search" type="text" name="k" value="<?php echo (session('k')); ?>" placeholder="请输入驾校或街道" /><?php endif; ?>
                <div class="clearfix"></div>
            </div>
            <div class="clearfix"></div>
        </div>
        <script>
            $(".search_box").click(function(){
                location.href = "<?php echo U('Mobile/List/pull');?>"
            })
        </script>
    </div>

    <div id="content">
        <div id="options">
            <a href="<?php echo U('Mobile/List/pull');?>">
                <div class="option1">
                    <img src="/Public/website/Mobile/Index/images/index_icon01.png">
                    <p>驾考全包</p>
                </div>
            </a>
            <a href="<?php echo U('Mobile/List/pull');?>">
                <div class="option1">
                    <img src="/Public/website/Mobile/Index/images/index_icon02.png">
                    <p>计时培训</p>
                </div>
            </a>
            <a href="<?php echo U('Mobile/Index/zxzk');?>">
                <div class="option1">
                    <img src="/Public/website/Mobile/Index/images/index_icon03.png">
                    <p>自学直考</p>
                </div>
            </a>
            <a href="<?php echo U('Mobile/Exam/theory_study');?>">
                <div class="option1">
                    <img src="/Public/website/Mobile/Index/images/index_icon04.png">
                    <p>理论学习</p>
                </div>
            </a>
            <div class="clearfix"></div>
        </div>
        <div class="demopage">
            <div class="demopage_img"><img src="/Public/website/Mobile/Index/images/517.png"></div>
            <div class="marquee_box">
                <div id="marquee">
                    <ul>
                        <li>
                            <p class="marquee_hot">惊爆</p><a href="" title="普及30个一线城市">普及30个一线城市</a>
                            <div class="clearfix"></div>
                        </li>
                        <li>
                            <p class="marquee_hot">热门</p>
                            <a href="" title="合作1800所A级驾校">合作1800所A级驾校</a>
                            <div class="clearfix"></div>
                        </li>
                        <li>
                            <p class="marquee_hot">爆棚</p><a href="" title="百万学员的选择">百万学员的选择</a>
                            <div class="clearfix"></div>
                        </li>
                    </ul>
                </div>
                <div class="demopage_text">
                    <p>报名即送大礼包！</p>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#marquee').kxbdSuperMarquee({
                    isEqual:false,
                    distance:30,
                    time:3,
                    direction:'up'
                });
            });
        </script>


        <div id="weekPrice">
            <div class="w-school">
                <div class="wp">
                    <img src="/Public/website/Mobile/Index/images/Lowest%20price.png">
                    <p>本周特价</p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="weekPrice_box">
                <?php if(is_array($week_list)): $i = 0; $__LIST__ = array_slice($week_list,0,1,true);if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Mobile/Detail/index',array('id'=>$v['school_id']));?>">
                        <div id="weekPrice_box1"  style="padding-bottom:30px;width: 47%;margin-right: 0px">
                            <ul>
                                    <li><?php echo ($v["nickname"]); ?></li>
                                    <li><h1>￥<?php echo ($v["minprice"]); ?></h1></li>
                                    <li><h2>￥<?php echo ($v["highprice"]); ?></h2></li>
                                    <li><p>价格优惠，保证42小时实车训练...</p></li>
                                    <li>
                                        <?php if($v['picname'] != ''): ?><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); ?>" alt="">
                                            <?php else: ?>
                                            <img src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt=""/><?php endif; ?>
                                    </li>
                            </ul>
                        </div>
                    </a><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                    <div id="weekPrice_box2" style="height: 260px">
                        <?php if(is_array($week_list1)): $i = 0; $__LIST__ = array_slice($week_list1,1,null,true);if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$data2): $mod = ($i % 2 );++$i;?><div class="wp_school1" style="height: 105px;margin-bottom: 10px">
                                <a href="<?php echo U('Mobile/Detail/index',array('id'=>$data2['school_id'],'type'=>$data2['type']));?>">
                                    <ul class="wps_ul">
                                        <li><?php echo ($data2["nickname"]); ?></li>
                                        <li><h1>￥<?php echo ($data2["minprice"]); ?></h1></li>
                                        <li><h2>￥<?php echo ($data2["highprice"]); ?></h2></li>
                                        <span>价格优惠，42小时实车训..</span>
                                    </ul>
                                </a>
                                <a  href="<?php echo U('Mobile/Detail/index',array('id'=>$data2['school_id'],'type'=>$data2['type']));?>" class="wps_img">
                                    <img height="50" src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($data2["picurl"]); echo ($data2["picname"]); ?>">
                                </a>
                                <div class="clearfix"></div>
                            </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                    </div>
                <div class="clearfix"></div>
            </div>
            <div id="more-school" style="margin:0">
                <div class="more" style="border:1px solid #ececec;width: 100%;">
                    <a style="padding:2% 38%;text-align: center" href="<?php echo U('Mobile/List/pull');?>">
                        更多驾校<img style="float: right" src="/Public/website/Mobile/Index/images/more.png">
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div id="hot">
            <div class="hot-school">
                <div class="hs">
                    <img src="/Public/website/Mobile/Index/images/index_icon07.png">
                    <p>热门驾校</p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="hot_box">
                <?php if(is_array($hot_list)): $i = 0; $__LIST__ = $hot_list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Mobile/Detail/index',array('id'=>$data['school_id'],'type'=>$data['type']));?>">
                        <div id="hot_box1" style="border-radius: 10px">
                            <?php if($data['picname'] != ''): ?><img style="margin-top: 10px" src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>" alt=""/>
                                <?php else: ?>
                                <img style="margin-top: 10px" src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt="" /><?php endif; ?>
                            <span style="text-align:center;color: #323232;font-weight: bold;margin-left: 15px;line-height: 24px;font-size: 12px;font-family: "微软雅黑" ">
                                <?php echo ($data["nickname"]); ?>
                            </span>
                            <p style="color: #fa7124;margin-left: 15px">￥<?php echo ($data["minprice"]); ?></p>
                            <p style="margin-left: 15px;font-size: 10px"><?php echo ($data["student_num"]); ?>人已报名</p>
                        </div>
                    </a><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                <div class="clearfix"></div>
            </div>
            <div id="more-school">
                <div class="more" style="border:1px solid #ececec;width: 100%;text-align: center">
                    <a  style="padding:2% 38%;text-align: center"href="<?php echo U('Mobile/List/pull');?>">
                        更多驾校<img style="float: right" src="/Public/website/Mobile/Index/images/more.png">
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div id="recomment">
            <div class="r-school">
                <div class="rs">
                    <img src="/Public/website/Mobile/Index/images/index_icon06.png">
                    <p>推荐驾校</p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="r_box">
                <?php if(is_array($jx_list)): $i = 0; $__LIST__ = $jx_list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div id="r_box1">
                        <div id="r_main">
                            <a href="<?php echo U('Mobile/Detail/index',array('id'=>$data['school_id'],'type'=>$data['type']));?>">
                                <?php echo ($data["nickname"]); ?>
                                <div class="clearfix"></div>
                                <ul id="rm">
                                    <li class="money">￥<?php echo ($data["minprice"]); ?></li>
                                    <li class="num" style="font-size: 10px"><?php echo ($data["student_num"]); ?>人已报名</li>
                                </ul>
                            </a>
                            <a style="" href="<?php echo U('Mobile/Detail/index',array('id'=>$data['school_id']));?>#detail">
                                <button style="padding: 4px 8px;color:#ffffff;font-size: 11px;">马上报名</button>
                            </a>
                            <div class="clearfix"></div>
                        </div>
                        <a href="<?php echo U('Mobile/Detail/index',array('id'=>$data['school_id'],'type'=>$data['type']));?>">
                            <div id="r_img">
                                <?php if($data["picname"] != ''): ?><img style="border-radius: 3px" src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>">
                                    <?php else: ?>
                                    <img style="width: 100px;height: 70px" src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt=""/><?php endif; ?>
                            </div>
                        </a>
                        <div class="clearfix"></div>
                    </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </div>
            <div id="more-school">
                <div class="more" style="border:1px solid #ececec;width: 100%;text-align: center">
                    <a style="padding:2% 38%;text-align: c" href="<?php echo U('Mobile/List/pull');?>">
                        更多驾校<img style="float: right" src="/Public/website/Mobile/Index/images/more.png">
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>


        <div id="new">
            <div class="n-school">
                <div class="ns">
                    <img src="/Public/website/Mobile/Index/images/index_icon08.png">
                    <p>驾考资讯</p>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div id="n_box">
                <?php if(is_array($consult)): $i = 0; $__LIST__ = $consult;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Mobile/Consult/studyNew_detail',array('id'=>$v['id']));?>">
                    <div id="n_box1">
                        <div id="n_main" style="margin-top: 10px">
                            <h1><?php echo (mb_substr($v["title"],0,20,utf8)); ?>...</h1>
                            <ul id="nm">
                                <li class="date"><?php echo date('Y/m/d',$v['time']);?></li>
                                <li class="num"><?php echo ($v["touch_count"]); ?></li>
                                <li class="eye">
                                    <img src="/Public/website/Mobile/Index/images/eye.png">
                                </li>
                                <div class="clearfix"></div>
                            </ul>
                        </div>
                        <div id="n_img">
                            <img  style="border-radius: 3px" src="<?php echo ($v["picurl"]); ?>">
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    </a><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </div>
            <div id="more-school">
                <div class="more" style="border:1px solid #ececec;width: 100%;text-align: center">
                    <a style="padding:2% 38%" href="<?php echo U('Consult/studynew');?>">
                        更多资讯<img style="float: right" src="/Public/website/Mobile/Index/images/more.png">
                    </a>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
    <footer id="footer">
        <ul>
            <a href="<?php echo U('Mobile/Index/index');?>">
                <li class="foot">
                        <img src="/Public/public/images/icon-footer01-a.png">
                        <p style="color: #fa7124; font-weight: bold;">首页</p>
                </li>
            </a>
            <a href="<?php echo U('Mobile/Language/language_list');?>">
                <li class="foot">
                    <img src="/Public/public/images/icon-footer2-a.png">
                    <p>语言</p>
                </li>
            </a>

            <a href="<?php echo U('Mobile/List/pull');?>">
                <li class="foot">
                    <img src="/Public/public/images/icon-footer3-a.png">
                    <p>驾校</p>
                </li>
            </a>
            <a href="<?php echo U('Mobile/Cyclope/baike');?>">
                <li class="foot">
                    <img src="/Public/public/images/icon-footer4-a.png">
                    <p>百科</p>
                </li>
            </a>
            <a href="<?php echo U('Mobile/User/user_center');?>">
                <li class="foot">
                    <img src="/Public/public/images/icon-footer5-a.png">
                    <p>我的</p>
                </li>
            </a>

        </ul>
    </footer>
    <div class="call_box">
        <a href="tel:4008040517"><img src="/Public/public/images/phone.png"></a>
    </div>
    <div class="sms_box">
        <a href="sms:18688888888"><img src="/Public/public/images/sms.png"></a>
    </div>
    
</div>
</body>
</html>