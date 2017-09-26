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
    <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
</head>

<body>

<div id="pagewrap">
    <div class="header_box">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/User/user_center');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">订单中心</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="order_select">
                <ul class="order_s">
                    <li class="list status" status="0"><a style="color: #fa7124;" href="javascript:;">全部</a></li>
                    <li class="status" status="1"><a  href="javascript:;">待付款</a></li>
                    <li class="status" status="2"><a href="javascript:;">待确认</a></li>
                    <li class="status" status="3"><a  href="javascript:;">待评价</a></li>
                    <li class="status" status="4"><a href="javascript:;">已完成</a></li>
                    <div class="clearfix"></div>
                </ul>

            </div>
            <div id="content">
                <?php if(is_array($order_info)): $i = 0; $__LIST__ = $order_info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><form class="list_box">
                        <div class="list_top">
                            <div class="list_top_img">
                                <?php if($v['type'] == 'jx'): ?><img src="<?php echo ($http); ?>//Public/website/Mobile/user/user_center/images/os.png">
                                    <?php elseif($v['type'] == 'jl'): ?>
                                    <img src="<?php echo ($http); ?>//Public/website/Mobile/user/user_center/images/ot.png">
                                    <?php else: ?>
                                    <img src="<?php echo ($http); ?>//Public/website/Mobile/user/user_center/images/oz.png"><?php endif; ?>
                            </div>
                            <p><?php echo ($v['adminstatus']); ?></p>
                            <div class="clearfix"></div>
                        </div>
                        <div class="list_body" >
                            <div class="list_body_img">
                                <?php if($v['type'] == 'jx'): ?><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>">
                                    <?php elseif($v['type'] == 'jl'): ?>
                                    <img src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>">
                                    <?php else: ?>
                                    <img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>"><?php endif; ?>
                            </div>
                            <ul class="list_body_text">
                                <a href="<?php echo U('Mobile/User/order_center_details',array('id'=>$v['id']));?>">
                                    <li class="text_name"><?php echo ($v['nickname']); ?></li>
                                    <li class="text_course" style="margin:3% 0"><?php echo ($v['class_name']); ?></li>
                                    <li class="text_apply"><?php echo ($v['type']==1?"全款报名":"预付费报名"); ?></li>
                                </a>
                            </ul>
                            <ul class="list_body_money">
                                <li class="money1">￥<?php echo ($v['price']); ?>元</li>
                                <br/>
                                <li class="money2">实付：<?php echo ($v['status']==1?0:($v['status']==5?0:$v['total_fee'])); ?>元</li>
                                <div class="clearfix"></div>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="list_bottom">
                            <a href="javascript:;"  status="<?php echo ($v['status']); ?>" oid="<?php echo ($v['id']); ?>"  class="submit1"><?php echo ($v['statusname']); ?></a>
                            <a href="javascript:;"  status="<?php echo ($v['status']); ?>" oid="<?php echo ($v['id']); ?>" class="submit2"><?php echo ($v['memberstatus']); ?></a>
                            <div class="clearfix"></div>
                        </div>
                    </form><?php endforeach; endif; else: echo "$empty" ;endif; ?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<script>
    $(".status").click(function(){
        var status = $(this).attr('status');
        $(this).addClass('list').siblings().removeClass('list');
        var str = '';
        $.post('<?php echo U("Mobile/User/order_center");?>',{status:status},function(res){
            if(res == 0){
                $("#content").html("<h1>暂无数据</h1>");
            }else{
                for(var i in res){
                str += '<form class="list_box"> ';
                str += '<div class="list_top"> ';
                str += '<div class="list_top_img"><img src="/Public/website/Mobile/user/user_center/images/os.png"></div> ';
                str += '<p>'+res[i]['adminstatus']+'</p>';
                str += '<div class="clearfix"></div>';
                str += '</div>';
                str += '<div class="list_body">';
                str += '<div class="list_body_img">';
                    if(res[i]['type'] == 'jx'){
                        str += '<img src="<?php echo ($http); ?>/Uploads/School_logo/'+res[i]['picurl']+res[i]['picname']+'">';
                    }else if(res[i]['type'] == 'jl'){
                        str += '<img src="<?php echo ($http); ?>/Uploads/Coach_logo/'+res[i]['picurl']+res[i]['picname']+'">';
                    }else{
                        str += '<img src="<?php echo ($http); ?>/Uploads/guider_logo/'+res[i]['picurl']+res[i]['picname']+'">';
                    }
                str += '</div>';
                str += '<ul class="list_body_text">';
                str += '<a href="'+"<?php echo U('Mobile/User/order_center_details');?>?id="+res[i]['id']+'">';
                str += '<li class="text_name">'+res[i]['nickname']+'</li>';
                str += '<li class="text_course">'+res[i]['class_name']+'</li>';
                str += '<li class="text_apply">'+res[i]==1?"全款报名":"预付费报名"+'</li>';
                str += '</a>';
                str += '</ul>';
                str += '<ul class="list_body_money">';
                str += '<li class="money1">￥'+res[i]['price']+'元</li><br/>';
                str += '<li class="money2">实付：';
                if(res[i]['status'] == 1 || res[i]['status'] == 5){
                    str += 0;
                }else{
                    str += res[i]['total_fee'];
                }
                str += '元</li>';
                str += '<div class="clearfix"></div>';
                str += '</ul>';
                str += '<div class="clearfix"></div>';
                str += '</div>';
                str += '<div class="list_bottom">';
                str += '<a href="javascript:;"  status="'+res[i]['status']+'" oid="'+res[i]['id']+'"  class="submit1">'+res[i]['statusname']+'</a>';
                str += '<a href="javascript:;"  status="'+res[i]['status']+'" oid="'+res[i]['id']+'" class="submit2">'+res[i]['memberstatus']+'</a>';
                str += '<div class="clearfix"></div>';
                str += '</div>';
                str += '</form>';
                $("#content").html(str);
                }
            }
        },'json');
    });
</script>
<script>
    $('.submit1').live('click',function(){
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
    $('.submit2').live('click',function(){
        var status = $(this).attr('status');
        var oid = $(this).attr('oid');
        $(this).attr('disabled','true');
        layer.open({
            content: '您确定不要了吗？'
            ,btn: ['是', '不要']
            ,yes: function(index){
                $.post('<?php echo U("Mobile/Order/delete_order");?>',{status:status,oid:oid},function(res){
                    if(res == 1){
                        location.href = res.url;
                    }else{
                        location.href = '';
                    }
                    layer.close(index);
                });
            }
        });
    });
</script>