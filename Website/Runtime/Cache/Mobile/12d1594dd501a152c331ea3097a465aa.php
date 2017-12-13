<?php if (!defined('THINK_PATH')) exit();?>﻿<!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>订单中心</title>
    <link rel="stylesheet" href="/Public/public/mui/css/mui.min.css">
    <link href="/Public/website/Mobile/user/user_center/css/main.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/user/user_center/css/order_center.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
    <style>
        /*.list{ padding: 5px 10px;border-radius: 15px; background-color: rgb(255, 108, 1);color:#fa7124}*/
        .status{border-bottom:2px solid #FA7124 ;}
    </style>
</head>
<body>
<div id="pagewrap">
    <div class="header_box">
        <div class="header">
            <ul>
                <a href="<?php echo U('Mobile/User/user_center');?>"><li class="back" style="padding-right: 50px"><img src="/Public/public/images/back.png"></li></a>
                <li class="header_text">订单中心</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="main_box">
        <div class="main">
            <div class="order_select">
                <ul class="order_s">
                    <?php if($_SESSION['xueches_']['total']== 'total'): ?><li class="list">
                        <?php else: ?>
                        <li><?php endif; ?>
                        <a style="padding: 5px 15px;" href="<?php echo U('Mobile/User/order_center',array('status'=>'0','total'=>'total'));?>">全部</a>
                    </li>

                    <?php if($_SESSION['xueches_']['pay']== 'pay'): ?><li class="list">
                            <?php else: ?>
                        <li><?php endif; ?>
                    <a style="padding: 5px 15px;" href="<?php echo U('Mobile/User/order_center',array('status'=>'1','pay'=>'pay'));?>">待付款</a>
                    </li>

                    <?php if($_SESSION['xueches_']['already']== 'already'): ?><li class="list">
                            <?php else: ?>
                        <li><?php endif; ?>
                    <a style="padding: 5px 15px;" href="<?php echo U('Mobile/User/order_center',array('status'=>'2','already'=>'already'));?>">已付款</a>
                    </li>

                    <?php if($_SESSION['xueches_']['evaluate']== 'evaluate'): ?><li class="list">
                            <?php else: ?>
                        <li><?php endif; ?>
                    <a style="padding: 5px 15px;" href="<?php echo U('Mobile/User/order_center',array('status'=>'3','evaluate'=>'evaluate'));?>">待评价</a>
                    </li>

                    <?php if($_SESSION['xueches_']['end']== 'end'): ?><li class="list">
                            <?php else: ?>
                        <li><?php endif; ?>
                    <a style="padding: 5px 15px;" href="<?php echo U('Mobile/User/order_center',array('status'=>'4','end'=>'end'));?>">已完成</a>
                    </li>
                    <div class="clearfix"></div>
                </ul>
            </div>
            <div id="pullrefresh" style="margin-top: 80px" class="mui-content mui-scroll-wrapper">
                <div class="main mui-scroll" >
                    <div id="content">
                        <?php if(is_array($order_info)): $i = 0; $__LIST__ = $order_info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><form class="list_box">
                                <div class="list_top">
                                    <div class="list_top_img">
                                        <?php if($v['s_type'] == 2): ?><img src="<?php echo ($http); ?>//Public/website/Mobile/user/user_center/images/ot.png">
                                            <?php elseif($v['s_type'] == 3): ?>
                                            <img src="<?php echo ($http); ?>//Public/website/Mobile/user/user_center/images/oz.png">
                                            <?php else: ?>
                                            <img src="<?php echo ($http); ?>//Public/website/Mobile/user/user_center/images/os.png"><?php endif; ?>
                                    </div>
                                    <p><?php echo ($v['create_time']); ?></p>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="list_body" >
                                    <div class="list_body_img">
                                    </div>
                                    <ul class="list_body_text">
                                        <a href="<?php echo U('Mobile/User/order_center_details',array('id'=>$v['id']));?>">
                                            <li class="text_name"><?php echo ($v['s_nickname']); ?></li>
                                            <li class="text_course" style="margin:3% 0"><?php echo ($v['class_name']); ?></li>
                                            <li class="text_apply"><?php echo ($v['type']==1?"全款报名":"预付费报名"); ?></li>
                                        </a>
                                    </ul>
                                    <ul class="list_body_money">
                                        <li class="money1">￥<?php echo ($v['price']); ?>元</li>
                                        <br/>
                                        <li class="money2">实付：<?php echo ($v['total_fee']); ?>元</li>
                                        <div class="clearfix"></div>
                                    </ul>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="list_bottom">
                                    <?php if($v["status"] == 1): ?><input onclick="status_submit(<?php echo ($v['status']); ?>,<?php echo ($v['id']); ?>)" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即付款"/>
                                        <?php elseif($v["status"] == 2): ?>
                                        <input onclick="status_submit(<?php echo ($v['status']); ?>,<?php echo ($v['id']); ?>)" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="等待处理"/>
                                        <?php elseif($v["status"] == 3): ?>
                                        <input onclick="status_submit(<?php echo ($v['status']); ?>,<?php echo ($v['id']); ?>)" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即评价"/>
                                        <?php elseif($v["status"] == 4): ?>
                                        <input onclick="status_submit(<?php echo ($v['status']); ?>,<?php echo ($v['id']); ?>)" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即追加"/>
                                        <?php elseif($v["status"] == 5): ?>
                                        <input onclick="status_submit(<?php echo ($v['status']); ?>,<?php echo ($v['id']); ?>)" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="重新报名"/>
                                        <?php elseif($v["status"] == 6): ?>
                                        <input type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="已退费"/><?php endif; ?>
                                    <div class="clearfix"></div>
                                </div>
                            </form><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
<script src="/Public/public/mui/js/mui.min.js"></script>
</html>
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
<script>
    mui.init({
        pullRefresh: {
            container: '#pullrefresh',
            down: {
                callback: pulldownRefresh
            },
            up: {
                contentrefresh: '正在加载...',
                callback: pullupRefresh
            }
        }
    });
    /**
     * 下拉刷新具体业务实现
     */
    function pulldownRefresh() {
        mui('#pullrefresh').pullRefresh().endPulldownToRefresh(); //refresh completed
        setTimeout(function() {
            $(".mui-pull-caption").show();
        }, 1500);
    };
    var count = 0;
    /**
     * 上拉加载具体业务实现
     */
    var ys = 2; //从第二页开始获取数据

    function pullupRefresh() {
        setTimeout(function() {
            mui('#pullrefresh').pullRefresh().endPullupToRefresh((++count > 2)); //参数为true代表没有更多数据了。
            var table = document.body.querySelector('.mui-table-view');
            $.ajax({
                type: "POST",
                dataType: "json",
                url: '<?php echo U("Mobile/User/order_center");?>',
                data: {page: ys},
                success: function (data) {
                    var str = "";//定义变量保存内容
                    $.each(data, function (index, array) {
                        if(array['id']){
                            str += '<form class="list_box"> ';
                            str += '<div class="list_top"> ';
                            str += '<div class="list_top_img"><img src="/Public/website/Mobile/user/user_center/images/os.png"></div> ';
                            str += '<p>'+array['create_time']+'</p>';
                            str += '<div class="clearfix"></div>';
                            str += '</div>';
                            str += '<div class="list_body">';
                            str += '<div class="list_body_img">';
                            str += '</div>';
                            str += '<ul class="list_body_text">';
                            str += '<a href="'+"<?php echo U('Mobile/User/order_center_details');?>?id="+array['id']+'">';
                            str += '<li class="text_name">'+array['s_nickname']+'</li>';
                            str += '<li class="text_course">'+array['class_name']+'</li>';
                            if(array['type']==1){
                                str += '<li class="text_apply">全款报名</li>';
                            }else{
                                str += '<li class="text_apply">预付费报名</li>';
                            }
                            str += '</a>';
                            str += '</ul>';
                            str += '<ul class="list_body_money">';
                            str += '<li class="money1">￥'+array['price']+'元</li><br/>';
                            str += '<li class="money2">实付：' + array['total_fee'];
                            str += '元</li>';
                            str += '<div class="clearfix"></div>';
                            str += '</ul>';
                            str += '<div class="clearfix"></div>';
                            str += '</div>';
                            str += '<div class="list_bottom">';
                            if(array['status'] == 1){
                                str += '<input onclick="status_submit('+array['status']+','+array['id']+')" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即付款"/>'
                            }else if(array['status'] == 2){
                                str += '<input onclick="status_submit('+array['status']+','+array['id']+')" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="等待处理"/>'
                            }else if(array['status'] == 3){
                                str += '<input onclick="status_submit('+array['status']+','+array['id']+')" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即评价"/>'
                            }else if(array['status'] == 4){
                                str += '<input onclick="status_submit('+array['status']+','+array['id']+')" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="立即追加"/>'
                            }else if(array['status'] == 5){
                                str += '<input onclick="status_submit('+array['status']+','+array['id']+')" type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="重新报名"/>'
                            }else if(array['status'] == 6){
                                str += '<input type="button" style="margin-right: 10px;float: right;background-color: #FA7124;color: #ffffff;border:0;-webkit-appearance: none" value="已退款"/>'
                            }
                            str += '<div class="clearfix"></div>';
                            str += '</div>';
                            str += '</form>';
                        }else{
                            $("#content").html("<h1 style='height: 30px;background-color: #ffffff;padding-top: 20px;text-align: center;font-size: 15px'>没有查到数据</h1>");
                        }
                        //下拉刷新，新纪录插到最前面；
                    });
                    $("#content").append(str); //把HTML添加到容器
                    ys++;//页数+1
                }
            });
        }, 1500);
    }
    mui('body').on('tap','a',function(){document.location.href=this.href;});
</script>