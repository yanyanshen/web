<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta content="telephone=no" name="format-detection">
<meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
<title>驾校详情</title>
<link href="/Public/website/Mobile/detail/css/main.css" rel="stylesheet" type="text/css">
<link href="/Public/website/Mobile/detail/css/media-queries.css" rel="stylesheet" type="text/css">
<link href="/Public/website/Mobile/detail/css/initialize.css" rel="stylesheet" type="text/css">
<link href="/Public/website/Mobile/detail/css/details.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/banner/Marquee.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#marquee_information2').kxbdSuperMarquee({
                isEqual:false, distance:18, time:3, direction:'up'
            });
        });
    </script>
</head>
<body>

<div id="pagewrap">
    <div class="header_box1">
        <div class="header2">
            <ul>
                <a href="<?php echo ($mobile_return); ?>">
                    <li class="header_back" style="padding-right: 50px">
                        <img src="/Public/public/images/back.png">
                    </li>
                </a>
                <li class="header_detail">
                    <?php if($info["type"] == 'jx'): ?>驾校详情<?php endif; ?>
                    <?php if($info["type"] == 'zd'): ?>指导员详情<?php endif; ?>
                    <?php if($info["type"] == 'jl'): ?>教练详情<?php endif; ?>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="content_moble">
        <div id="content_mt">
            <div id="top_m1">
                <div class="top_m1_img">
                    <?php if($info["type"] == 'jx'): ?><img style="border-radius: 3px" src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($info["picurl"]); ?>/<?php echo ($info["picname"]); ?>"/><?php endif; ?>
                    <?php if($info["type"] == 'zd'): ?><img style="border-radius: 3px" src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($info["picurl"]); ?>/<?php echo ($info["picname"]); ?>"/><?php endif; ?>
                    <?php if($info["type"] == 'jl'): ?><img style="border-radius: 3px" src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($info["picurl"]); ?>/<?php echo ($info["picname"]); ?>"/><?php endif; ?>
                </div>
                <ul class="top_m1_text">
                    <li id="tbt_mn"><?php echo ($info["nickname"]); ?></li>
                    <li id="tbt_mm">￥<?php echo ($info["minprice"]); ?></li>
                    <li id="tbt_mnum"><?php echo ($info["student_num"]); ?>人已报名</li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div id="top_m2">
                <p style="font-weight: normal;color: #646464;margin-left: 10px">地址：<?php echo ($info["address"]); ?></p>
                <div class="topm2">
                    <span>驾校</span>官方报名电话：<?php echo ($info["phone"]); ?>
                </div>
                <?php if($info["type"] != 'jx'): ?><ul  style="width: 240px;margin-left: auto;margin-right: auto;">
                        <li style="float: left;margin-left: 20px;font-weight: normal">年龄：<?php echo ($info["age"]); ?></li><br>
                        <li style="float: left;margin-left: 20px;font-weight: normal">教龄：<?php echo ($info["teachage"]); ?></li>
                        <li style="float: left;margin-left: 20px;font-weight: normal">驾龄：<?php echo ($info["driverage"]); ?></li>
                        <div class="clearfix"></div>
                    </ul><?php endif; ?>
            </div>
            <div id="top_m3">
                <div class="top-m3">
                    <ul class="like_box">
                        <li class="like_img"><img src="/Public/website/Mobile/detail/images/like.png"></li>
                        <li class="like_text">共有<?php echo ($info["evalutioncount"]); ?>条评假</li>
                        <div class="clearfix"></div>
                    </ul>
                    <div class="shuffling">
                        <div class="shuffling_img"><img src="/Public/website/Mobile/detail/images/information.png"></div>
                        <div class="shuffling_text">
                            <div id="marquee_information2">
                                <ul>
                                    <li>冯先生一天前报了上海市中心驾校</li>
                                    <li>冯先生一天前报了上海市中心驾校</li>
                                    <li>冯先生一天前报了上海市中心驾校</li>
                                    <li>冯先生一天前报了上海市中心驾校</li>
                                    <li>冯先生一天前报了上海市中心驾校</li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div id="top_m2">
            <div class="topm2" style="border: none;font-weight: normal">
                <ul>
                    <li>计时培训<span>
                        <?php if($info["timing"] == 1): ?>支持计时
                            <?php else: ?>
                            不支持计时<?php endif; ?>
                        </span></li>
                    <?php if($info["type"] != 'jx'): ?><li>所属驾校：<span><?php echo ($info['school_id']); ?></span></li><?php endif; ?>
                </ul>
            </div>
        </div>
        <a name="detail"></a>
        <div id="content_mc">
            <div class="course_bm">
                <div class="course_tbm">
                    <div class="course_tm">
                        <h1>培训课程</h1>
                    </div>
                </div>
                <div class="course_tablem">
                    <table width="94%" border=0 bgcolor="#dcdcdc" cellspacing=0 cellpadding=0 id="coursem">
                    <tr>
                        <td>
                            <table width="100%" border=0 cellspacing=1 cellpadding=10>
                                <tr bgcolor="#f5f5f5">
                                    <th align="center" style="width: 25%">培训课程</th>
                                    <th align="center" style="width: 20%;">班别</th>
                                    <th align="center" style="width: 18%;">官方价</th>
                                    <th align="center" style="width: 17%;">优惠价</th>
                                    <th align="center">报名学车</th>
                                </tr>
                                <?php if(is_array($class)): $i = 0; $__LIST__ = $class;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr bgcolor="#FFFFFF">
                                        <td align="center" style="padding: 0;margin:0">
                                            <a href="<?php echo U('Mobile/Detail/course_details',array('id'=>$v['id']));?>" class="course_name">
                                                <?php echo ($v["name"]); ?>
                                            </a>
                                        </td>
                                        <td align="center" style="padding: 0;margin:0"><?php echo ($v["class_type"]); ?></td>
                                        <td align="center" style="padding: 0;margin:0"><?php echo ($v["officeprice"]); ?></td>
                                        <td align="center" class="course_money" style="padding: 0;margin:0"><?php echo ($v["wholeprice"]); ?></td>
                                        <td align="center">
                                            <a href="<?php echo U('Mobile/Order/apply_order',array('sub_button'=>$v['id']));?>">
                                                <div class="course_apply" style="color: #ffffff;padding: 3px 0">报名</div>
                                            </a>
                                        </td>
                                    </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                            </table>
                        </td>
                    </tr>
                </table>
                </div>
            </div>
        </div>
        <div id="content_mi">
                <div id="introduce_bm">
                    <div class="course_tbm">
                        <div class="course_tm">
                            <h1>驾校简介</h1>
                        </div>
                    </div>
                    <div id="introduce_tm">
                        <div id="introduce_m">
                            <p><?php echo ($info["introduction"]); ?></p>
                            <?php if(is_array($abstract_pic)): $i = 0; $__LIST__ = $abstract_pic;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i; if($data["type"] == 'jx' and $data["picname"] != ''): ?><img class="img1" style="width: 250px;height: 150px" src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>"/><?php endif; ?>

                                <?php if($data["type"] == 'zd' and $data["picname"] != ''): ?><img class="img1" style="width: 250px;height: 150px" src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>"/><?php endif; ?>
                                <?php if($data["type"] == 'jl' and $data["picname"] != ''): ?><img class="img1" style="width: 250px;height: 150px" src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>"/><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                            <script type="text/javascript">
                                $(function(){
                                    $(".img1").click(function(){
                                        var width = $(this).width();
                                        if(width==250) {
                                            $(this).width(300);
                                            $(this).height(200);
                                        } else {
                                            $(this).width(250);
                                            $(this).height(150);
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </div>
                </div>
            </div>

        <div id="content_mi">
            <div id="introduce_bm">
                <div class="course_tbm">
                    <div class="course_tm">
                        <h1>驾校环境</h1>
                    </div>
                </div>
                <div id="introduce_tm">
                    <div id="introduce_m">
                        <?php if(is_array($picinfo)): $i = 0; $__LIST__ = $picinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i; if($data["type"] == 'jx' and $data["picname"] != ''): ?><img class="img1" style="width: 250px;height: 150px" src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>"/><?php endif; ?>

                            <?php if($data["type"] == 'zd' and $data["picname"] != ''): ?><img class="img2" style="width: 250px;height: 150px" src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>"/><?php endif; ?>
                            <?php if($data["type"] == 'jl' and $data["picname"] != ''): ?><img class="img2" style="width: 250px;height: 150px" src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($data["picurl"]); echo ($data["picname"]); ?>"/><?php endif; endforeach; endif; else: echo "" ;endif; ?>
                        <script type="text/javascript">
                            $(function(){
                                $(".img2").click(function(){
                                    var width = $(this).width();
                                    if(width==250) {
                                        $(this).width(300);
                                        $(this).height(200);
                                    } else {
                                        $(this).width(250);
                                        $(this).height(150);
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>
        </div>

        <div id="content_me">
            <div id="eval_bm">
                <div class="course_tbm">
                    <div class="course_tm">
                        <h1>学员评价</h1>
                    </div>
                </div>
                <div id="eval_mm">
                    <div id="eval_tm">
                        <ul>
                            <li class="eval_score_m">5.0</li>
                            <li class="eval_star_m"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/start.png"></li>
                            <li class="eval_num_m"><span><?php echo ($evaluate_count); ?></span>条学员评价</li>
                        </ul>
                    </div>
                    <div id="eval_bottom">
                        <?php if(is_array($evaluate)): $i = 0; $__LIST__ = $evaluate;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div id="eval_m" style="margin-top: 10px">
                                <div class="eval_name">
                                    <h1 class="eval_left"><?php echo ($data['truename']); ?></h1>
                                    <ul class="eval_right">
                                        <li class="eval_date"><?php echo ($data['ntime']); ?></li>
                                        <li class="eval_img">
                                            <?php if($data['score'] == 1): ?><img width="84" height="14" src="/Public/website/Mobile/detail/images/start1.png">
                                                <?php elseif($data['score'] == 2): ?>
                                                <img width="84" height="14" src="/Public/website/Mobile/detail/images/start2.png">
                                                <?php elseif($data['score'] == 3): ?>
                                                <img width="84" height="14" src="/Public/website/Mobile/detail/images/start3.png">
                                                <?php elseif($data['score'] == 4): ?>
                                                <img width="84" height="14" src="/Public/website/Mobile/detail/images/start4.png">
                                                <?php elseif($data['score'] == 5): ?>
                                                <img src="/Public/website/Mobile/detail/images/start.png"><?php endif; ?>
                                        </li>
                                        <li class="eval_s"><?php echo ($data['score']); ?>.0</li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <?php if(!empty($data['reply'])): ?><div class="eval_text">
                                        <?php if($data['append'] == 1): ?><p style="border-bottom: none;padding:0"><?php echo ($data['content']); ?></p>
                                            <p style="border-bottom: 0;padding:0"> <span style="color: #FA7124">追加内容【<?php echo ($data['untime']); ?>】</span> <?php echo ($data['ucontent']); ?></p>
                                            <?php else: ?>
                                            <p style="border-bottom: none;margin: 0">内容:<?php echo ($data['content']); ?></p><?php endif; ?>
                                        <div style="border-bottom: 1px solid #eee;">
                                            <?php if(is_array($data['reply'])): $i = 0; $__LIST__ = $data['reply'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><p style="border: 0;margin:0"><span style="color: #FA7124">驾校回复【<?php echo ($v['ntime']); ?>】</span> <?php echo ($v['content']); ?></p><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                                        </div>
                                    </div>
                                    <?php else: ?>
                                    <div class="eval_text">
                                        <?php if($data['ucontent'] != ''): ?><p style="border-bottom: none;padding:0"><?php echo ($data['content']); ?></p>
                                            <p><span style="color:#fa7124">追加内容【<?php echo ($data['untime']); ?>】</span><?php echo ($data['ucontent']); ?></p>
                                            <?php else: ?>
                                            <p><?php echo ($data['content']); ?></p><?php endif; ?>
                                    </div><?php endif; ?>
                            </div><?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                    <div class="look_more">
                        <div class="lm">
                            <a  style="padding:10px 100px;" href="<?php echo U('Mobile/Detail/evaluate',array('id'=>$info['id']));?>">查看更多</a>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <footer id="footer">
        <ul>
            <a href="#detail">
                <li class="foot_box">
                    <p>马上报名</p>
                </li>
            </a>
            <li class="foot_box">
                <a href="">
                    <p>免费咨询</p>
                </a>
            </li>
        </ul>
    </footer>
    <div class="call_box">
        <a href="tel:4008040517">
            <img src="/Public/public/images/phone.png">
        </a>
    </div>
    <div class="sms_box">
        <a href="sms:17752364125"><img src="/Public/public/images/sms.png"></a>
        <!--<a href="sms:18688888888">发短信</a>-->
    </div>
    
</div>
</div>
</body>
</html>