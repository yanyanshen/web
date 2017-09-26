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
<script src="/Public/website/Mobile/detail/js/Marquee.js"></script>
    <script type="text/javascript">
        $(function(){
            $('#marquee_information2').kxbdSuperMarquee({
                isEqual:false,
                distance:18,
                time:3,
                direction:'up'
            });
        });

    </script>
</head>

<body>

<div id="pagewrap">

	<div id="header_box">
		<ul id="header">
			<li id="header_logo"><a href="index.html"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/logo.png"></a></li>
			<li id="header_text"><h1>为改变驾校而生</h1></li>
            <li id="header_phone"><a href=""><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/phone.png"></a></li>
			<li id="header_number"><a href="tel:4008040517">400-8040-517</a></li>
			<div class="clearfix"></div>
		</ul>
	</div>
    <div class="header_box1">
        <div class="header2">
            <ul>
                <li class="header_back">
                    <a href="<?php echo U('Mobile/Index/index');?>">
                        <img src="/Public/public/images/back.png">
                    </a>
                </li>
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
                    <?php if($info["type"] == 'jx'): ?><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($info["picurl"]); ?>/<?php echo ($info["picname"]); ?>"/><?php endif; ?>
                    <?php if($info["type"] == 'zd'): ?><img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($info["picurl"]); ?>/<?php echo ($info["picname"]); ?>"/><?php endif; ?>
                    <?php if($info["type"] == 'jl'): ?><img src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($info["picurl"]); ?>/<?php echo ($info["picname"]); ?>"/><?php endif; ?>
                </div>
                <ul class="top_m1_text">
                    <li id="tbt_mn"><?php echo ($info["nickname"]); ?></li>
                    <li id="tbt_mm">￥<?php echo ($classprice); ?></li>
                    <li id="tbt_mnum"><?php echo ($info["allcount"]); ?>人已报名</li>
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
                        <li class="like_img"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/like.png"></li>
                        <li class="like_text">共有<?php echo ($info["evalutioncount"]); ?>条评假</li>
                        <div class="clearfix"></div>
                    </ul>
                    <div class="shuffling">
                        <div class="shuffling_img"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/information.png"></div>
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
                    <?php if($info["type"] != 'jx'): if(empty($$info["school_id"])): ?><li>所属驾校：<span>�</span></li>
                            <?php else: ?>
                            <li>所属驾校：<span><?php echo ($info["school_id"]); ?></span></li><?php endif; endif; ?>
                </ul>
            </div>
        </div>

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
                                                <?php if($v["week"] == 1): ?><br>（本周特价）<?php endif; ?>
                                                <?php if($v["recommand"] == 1): ?><br>（推荐）<?php endif; ?>
                                                <?php if($v["hot"] == 1): ?><br>（热门）<?php endif; ?>
                                            </a>
                                        </td>
                                        <td align="center" style="padding: 0;margin:0"><?php echo ($v["class_type"]); ?></td>
                                        <td align="center" style="padding: 0;margin:0"><?php echo ($v["officeprice"]); ?></td>
                                        <td align="center" class="course_money" style="padding: 0;margin:0"><?php echo ($v["wholeprice"]); ?></td>
                                        <td align="center">
                                            <div class="course_apply">
                                                <a href="<?php echo U('Mobile/Order/apply_order',array('sub_button'=>$v['id']));?>">报名</a>
                                            </div>
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
                            <h1>培训课程</h1>
                        </div>
                    </div>
                    <div id="introduce_tm">
                        <div id="introduce_m">
                            <p><?php echo ($info["introduction"]); ?></p>
                            <?php if(is_array($picinfo)): $i = 0; $__LIST__ = $picinfo;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i; if($data["type"] == 'jx'): ?><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($data["picurl"]); ?>/<?php echo ($data["picname"]); ?>"/><?php endif; ?>

                                <?php if($data["type"] == 'zd'): ?><img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($data["picurl"]); ?>/<?php echo ($data["picname"]); ?>"/><?php endif; ?>
                                <?php if($data["type"] == 'jl'): ?><img src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($data["picurl"]); ?>/<?php echo ($data["picname"]); ?>"/><?php endif; endforeach; endif; else: echo "" ;endif; ?>
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
                                <li class="eval_star_m"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/star.png"></li>
                                <li class="eval_num_m"><span>619</span>条学员评价</li>
                            </ul>
                        </div>
                        <div id="eval_bottom">
                            <div id="eval_m">
                                <div class="eval_name">
                                    <h1 class="eval_left">素莫</h1>
                                    <ul class="eval_right">
                                        <li class="eval_date">2017-04-05</li>
                                        <li class="eval_time">13:25</li>
                                        <li class="eval_img"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/star.png"></li>
                                        <li class="eval_s">5.0</li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="eval_text">
                                    <p>我拿到驾驶证已经差不多半个月了，当时找的是吴教练，想起当初的学车经历我一辈子都忘不了。现在回想起来非常非常感谢吴教练努力与付出，要不是吴教练，估计我这辈子都开不了车。在和吴教练相处的这几个月，我亲眼目睹了吴教练的工作，真不是大家想象中的那样。教练真的很辛苦!�
                                    </p>
                                </div>
                            </div>
                            <div id="eval_m">
                                <div class="eval_name">
                                    <h1 class="eval_left">素莫</h1>
                                    <ul class="eval_right">
                                        <li class="eval_date">2017-04-05</li>
                                        <li class="eval_time">13:25</li>
                                        <li class="eval_img"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/star.png"></li>
                                        <li class="eval_s">5.0</li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="eval_text">
                                    <p>我拿到驾驶证已经差不多半个月了，当时找的是吴教练，想起当初的学车经历我一辈子都忘不了。现在回想起来非常非常感谢吴教练努力与付出，要不是吴教练，估计我这辈子都开不了车。在和吴教练相处的这几个月，我亲眼目睹了吴教练的工作，真不是大家想象中的那样。教练真的很辛苦!
                                    </p>
                                </div>
                            </div>
                            <div id="eval_m">
                                <div class="eval_name">
                                    <h1 class="eval_left">素莫</h1>
                                    <ul class="eval_right">
                                        <li class="eval_date">2017-04-05</li>
                                        <li class="eval_time">13:25</li>
                                        <li class="eval_img"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/star.png"></li>
                                        <li class="eval_s">5.0</li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="eval_text">
                                    <p>我拿到驾驶证已经差不多半个月了，当时找的是吴教练，想起当初的学车经历我一辈子都忘不了。现在回想起来非常非常感谢吴教练努力与付出，要不是吴教练，估计我这辈子都开不了车。在和吴教练相处的这几个月，我亲眼目睹了吴教练的工作，真不是大家想象中的那样。教练真的很辛苦!
                                    </p>
                                </div>
                            </div>
                            <div id="eval_m">
                                <div class="eval_name">
                                    <h1 class="eval_left">素莫</h1>
                                    <ul class="eval_right">
                                        <li class="eval_date">2017-04-05</li>
                                        <li class="eval_time">13:25</li>
                                        <li class="eval_img"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/star.png"></li>
                                        <li class="eval_s">5.0</li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="eval_text">
                                    <p>我拿到驾驶证已经差不多半个月了，当时找的是吴教练，想起当初的学车经历我一辈子都忘不了。现在回想起来非常非常感谢吴教练努力与付出，要不是吴教练，估计我这辈子都开不了车。在和吴教练相处的这几个月，我亲眼目睹了吴教练的工作，真不是大家想象中的那样。教练真的很辛苦!
                                    </p>
                                </div>
                            </div>
                            <div id="eval_m">
                                <div class="eval_name">
                                    <h1 class="eval_left">素莫</h1>
                                    <ul class="eval_right">
                                        <li class="eval_date">2017-04-05</li>
                                        <li class="eval_time">13:25</li>
                                        <li class="eval_img"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/star.png"></li>
                                        <li class="eval_s">5.0</li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="eval_text">
                                    <p>我拿到驾驶证已经差不多半个月了，当时找的是吴教练，想起当初的学车经历我一辈子都忘不了。现在回想起来非常非常感谢吴教练努力与付出，要不是吴教练，估计我这辈子都开不了车。在和吴教练相处的这几个月，我亲眼目睹了吴教练的工作，真不是大家想象中的那样。教练真的很辛苦!
                                    </p>
                                </div>
                            </div>
                            <div class="look_more"><div class="lm"><a>查看更多</a></div></div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <footer id="footer">
        <ul>
            <li class="foot_box">
                <a href="<?php echo U('Mobile/Order/choose_course',array('id'=>$id));?>">
                    <p>马上报名</p>
                </a>
               </li>
            <li class="foot_box">
                <a href="">
                    <p>免费咨询</p>
                </a>
            </li>
        </ul>
    </footer>

    <div class="call_box">
        <a href="tel:4008040517">
            <img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/phone.png">
        </a>
    </div>
    <div class="sms_box">
        <a href="sms:17752364125"><img src="<?php echo ($http); ?>//Public/website/Mobile/detail/images/sms.png"></a>
        <!--<a href="sms:18688888888">发短信</a>-->
    </div>

    
</div>


</body>
</html>