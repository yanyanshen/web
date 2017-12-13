<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>订单详情页</title>
    <link href="/Public/website/Mobile/user/user_center/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/order_center.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
</head>
<body>
<div id="pagewrap">
    <div class="header_box">
        <div class="header">
            <ul>
                <a href="<?php echo U('Mobile/User/order_center');?>">
                    <li class="back" style="padding-right: 50px">
                        <img src="/Public/public/images/back.png">
                    </li>
                </a>
                <li class="header_text">订单详情页</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <form class="list_detail">
                <div class="list_det">
                    <div class="list_det_img">
                        <?php if($info['picname'] != '' and $info['s_type'] == 1): ?><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($info['picurl']); echo ($info['picname']); ?>">
                            <?php elseif($info['picname'] != '' and $info['s_type'] == 2): ?>
                            <img src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($info['picurl']); echo ($info['picname']); ?>">
                            <?php elseif($info['picname'] != '' and $info['s_type'] == 2): ?>
                            <img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($info['picurl']); echo ($info['picname']); ?>">
                            <?php else: ?>
                            <img src="<?php echo ($http); ?>/Uploads/default_logo/517.png"><?php endif; ?>
                    </div>
                    <ul class="list_det_text">
                        <li class="text_detname">
                            <?php echo ($info['s_nickname']); ?>
                        </li>
                        <li class="text_detcourse" style="color:#FA7124;font-size: 12px"><?php echo ($info['class_name']); ?></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="list_detmain">
                    <ul class="detail">
                        <li class="detail_one" style="width: 20%">学车人数</li>
                        <li class="detail_tow"><?php echo ($info['num']); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <?php if(is_array($info['order_user'])): $i = 0; $__LIST__ = $info['order_user'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><ul class="detail">
                            <li class="detail_one" style="width: 15%">学员姓名</li>
                            <li class="detail_tow" ><?php echo ($data['name']); ?></li>
                            <li  style="margin-left: 2%;"  class="detail_one">报名电话</li>
                            <li class="detail_tow" style="width: 21%"><?php echo ($data['tel']); ?></li>
                            <div class="clearfix"></div>
                        </ul><?php endforeach; endif; else: echo "" ;endif; ?>
                    <ul class="detail">
                        <li class="detail_one">详细地址</li>
                        <li class="detail_tow" style="width: 70%">
                            <?php if(empty($$info['address'])): ?>未填写地址
                                <?php else: ?>
                                <?php echo ($info['address']); endif; ?>
                            </li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">报名方式</li>
                        <li class="detail_tow" style="color: rgb(250,113,36)"><?php echo ($info['type']==1?'全款报名':'预付费报名'); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">下单时间</li>
                        <li class="detail_tow" style="width: 200px"><?php echo ($info['create_time']); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">应付金额</li>
                        <li class="detail_tow" style="color: rgb(250,113,36)"><?php echo ($info['price']); ?>元</li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">备注说明</li>
                            <textarea name="" id="" readonly cols="35%" rows="3"><?php if(empty($$info['inform'])): ?>无
                                <?php else: ?>
                                <?php echo ($info['inform']); endif; ?></textarea>
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </form>
            <footer id="footer" style="text-align: center">
                <?php if($info["status"] == 1): ?><input class="foot_box2" onclick="status_submit(<?php echo ($info['status']); ?>,<?php echo ($info['id']); ?>)" type="button" style="background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即付款"/>
                    <?php elseif($info["status"] == 2): ?>
                    <input class="foot_box2" onclick="status_submit(<?php echo ($info['status']); ?>,<?php echo ($info['id']); ?>)" type="button" style="background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="等待处理"/>
                    <?php elseif($info["status"] == 3): ?>
                    <input class="foot_box2" onclick="status_submit(<?php echo ($info['status']); ?>,<?php echo ($info['id']); ?>)" type="button" style="background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即评价"/>
                    <?php elseif($v["status"] == 4): ?>
                    <input class="foot_box2" onclick="status_submit(<?php echo ($info['status']); ?>,<?php echo ($info['id']); ?>)" type="button" style="background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即追加"/>
                    <?php elseif($info["status"] == 5): ?>
                    <input class="foot_box2" onclick="status_submit(<?php echo ($info['status']); ?>,<?php echo ($info['id']); ?>)" type="button" style="background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="重新报名"/>
                    <?php elseif($info["status"] == 6): ?>
                    <input class="foot_box2" type="button" style="background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="已退费"/><?php endif; ?>

            </footer>
        </div>
    </div>

</div>
<script>
    function status_submit(status,oid){
        if(status != 2){
            layer.open({type:2,content:'加载中',time:2,end: function(index){
                $.post('<?php echo U("Mobile/Order/confirm_order");?>',{status:status,oid:oid},function(res){
                    if(res.info){
                        location.href = res.url;
                    }else{
                        location.href = '#';
                    }
                    layer.close(index);
                },'json');
            }
            });
        }else{
            alert('请耐心等待客服处理');
        }
    }
</script>
</body>
</html>