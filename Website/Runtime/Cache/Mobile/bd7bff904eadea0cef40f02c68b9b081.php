<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>订单中心</title>
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
                <li class="back"><a href="<?php echo U('Mobile/User/order_center');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">订单详情页</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <form class="list_detail">
                <div class="list_det">
                    <div class="list_det_img"><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($info['picurl']); echo ($info['picname']); ?>"></div>
                    <ul class="list_det_text">
                        <li class="text_detname">
                            <?php echo ($info['nickname']); ?>
                        </li>
                        <li class="text_detcourse"><?php echo ($info['class_name']); ?></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="list_detmain">
                    <ul class="detail">
                        <li class="detail_one">学员姓名</li>
                        <li class="detail_tow"><?php echo ($info['name']); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">学车人数</li>
                        <li class="detail_tow"><?php echo ($info['num']); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">报名电话</li>
                        <li class="detail_tow"><?php echo ($info['tel']); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">详细地址</li>
                        <li class="detail_tow">
                            <?php if(empty($$info['address'])): ?>未填写地址
                                <?php else: ?>
                                <?php echo ($info['address']); endif; ?>
                            </li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">报名方式</li>
                        <li class="detail_tow"><?php echo ($info['otype']==1?'全款报名':'预付费报名'); ?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">下单时间</li>
                        <li class="detail_tow"><?php echo date('Y-m-d',$info['create_time']);?></li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">应付金额</li>
                        <li class="detail_tow"><?php echo ($info['price']); ?>元</li>
                        <div class="clearfix"></div>
                    </ul>
                    <ul class="detail">
                        <li class="detail_one">备注说明</li>
                        <li class="detail_tow">
                            <?php if(empty($$info['inform'])): ?>无
                                <?php else: ?>
                                <?php echo ($info['inform']); endif; ?>
                        </li>
                        <div class="clearfix"></div>
                    </ul>
                </div>
            </form>
            <footer id="footer">
                <input type="submit" oid="<?php echo ($v['id']); ?>"  status="<?php echo ($v['status']); ?>"  name="btn2" class="foot_box1" value="<?php echo ($info['memberstatus']); ?>">
                <input type="submit" oid="<?php echo ($info['id']); ?>"  status="<?php echo ($info['status']); ?>"  name="btn2" class="foot_box2" value="<?php echo ($info['statusname']); ?>">
            </footer>
        </div>
    </div>

</div>

<script>
    $(".foot_box2").click(function(){
        var status = $(this).attr('status');
        var oid = $(this).attr('oid');
        $(this).attr('disabled','true');
        layer.open({
            type:2
            ,content:'加载中'
            ,time:2
            ,end: function(index){
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
    });

    $(".foot_box1").click(function(){
        var status = $(this).attr('status');
        var oid = $(this).attr('oid');
        $(this).attr('disabled','true');
        layer.open({
            content: '您确定不要了吗？'
            ,btn: ['是', '不要']
            ,yes: function(index){
                $.post('<?php echo U("Mobile/Order/delete_order");?>',{status:status,oid:oid},function(res){
                    if(res.info == 1){
                        location.href = res.url;
                    }else{
                        location.href = '';
                    }
                    layer.close(index);
                },'json');
            }
        });
    });
</script>
</body>
</html>