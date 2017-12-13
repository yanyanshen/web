<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <title>评论页面</title>
    <link rel="stylesheet" href="/Public/public/mui/css/mui.min.css">
    <link href="/Public/website/Mobile/consult/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/consult/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/consult/css/studyNew.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <style>
        .list{ padding: 7px 12px;border-radius: 15px; background-color: rgb(255, 108, 1);color:#fa7124}
        .status{ padding: 7px 12px;border-radius: 15px;background-color: rgb(255, 236, 234) ;}
    </style>
<body>
<div class="login_box">
    <div class="header_box" style="z-index: 3000">
        <div class="header">
            <ul>
                <a href="<?php echo U('Mobile/Detail/index',array('id'=>$get['id']));?>">
                    <li class="back">
                        <img src="/Public/public/images/back.png">
                    </li>
                </a>

                <li class="header_text">学员评价</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div class="header_box">
        <div class="header">
            <ul>
                <li class="header_text" style="margin:0 auto;height: 50px">
                    <?php if($_SESSION['xueches_']['total']== 1): ?><a href="<?php echo U('Mobile/Detail/evaluate',array('status'=>'total','id'=>$get['id']));?>" class="status list">全部(<?php echo ($total); ?>)</a>
                        <?php else: ?>
                        <a href="<?php echo U('Mobile/Detail/evaluate',array('status'=>'total','id'=>$get['id']));?>" class="status">全部(<?php echo ($total); ?>)</a><?php endif; ?>

                    <?php if($_SESSION['xueches_']['new']== 1): ?><a href="<?php echo U('Mobile/Detail/evaluate',array('status'=>'new','id'=>$get['id']));?>" class="status list" style="margin: 0 10px;">最新(<?php echo ($new); ?>)</a>
                        <?php else: ?>
                        <a href="<?php echo U('Mobile/Detail/evaluate',array('status'=>'new','id'=>$get['id']));?>" class="status" style="margin: 0 10px;">最新(<?php echo ($new); ?>)</a><?php endif; ?>
                    <?php if($_SESSION['xueches_']['until']== 1): ?><a href="<?php echo U('Mobile/Detail/evaluate',array('status'=>'until','id'=>$get['id']));?>" class="status list">追加(<?php echo ($until); ?>)</a>
                        <?php else: ?>
                        <a href="<?php echo U('Mobile/Detail/evaluate',array('status'=>'until','id'=>$get['id']));?>" class="status">追加(<?php echo ($until); ?>)</a><?php endif; ?>
                </li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
    <div id="pullrefresh" style="margin-top: 30%" class="mui-content mui-scroll-wrapper">
        <div class="main mui-scroll" >
            <div class="studyNew">
                <div class="new">
                    <?php if(is_array($evaluate)): $i = 0; $__LIST__ = $evaluate;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div id="n_box1">
                            <div>
                                <h5 style="display: inline-block;height: 20px;line-height: 30px;color: #000000"><?php echo ($data['truename']); ?></h5>
                                <div style="display: inline-block;float: right;margin-right: 1px">
                                    <span style="margin-right: 5px"><?php echo ($data['ntime']); ?></span>
                                    <?php if($data['score'] == 1): ?><img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start1.png">
                                    <?php elseif($data['score'] == 2): ?>
                                    <img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start2.png">
                                    <?php elseif($data['score'] == 3): ?>
                                    <img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start3.png">
                                    <?php elseif($data['score'] == 4): ?>
                                    <img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start4.png">
                                    <?php elseif($data['score'] == 5): ?>
                                    <img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start.png"><?php endif; ?>
                                    <span style="margin-left: 5px"><?php echo ($data['score']); ?>.0</span>
                                </div>
                            </div>
                            <div>
                                <?php if($data['ucontent'] != ''): ?><p style="border-bottom: none;padding:0"><?php echo ($data['content']); ?></p>
                                    <p style="border-bottom: 0;padding:0"> <span style="color: #FA7124">追加内容【<?php echo ($data['untime']); ?>】</span> <?php echo ($data['ucontent']); ?></p>
                                    <?php else: ?>
                                    <p style="border-bottom: none;margin: 0"><?php echo ($data['content']); ?></p><?php endif; ?>
                            </div>
                            <div>
                                <?php if(is_array($data['reply'])): $i = 0; $__LIST__ = $data['reply'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><p><span style="color: #FA7124;border-top: none;">驾校回复【<?php echo ($v['ntime']); ?>】</span> <?php echo ($v['content']); ?></p><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                            </div>
                        </div><?php endforeach; endif; else: echo "" ;endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
    <script src="/Public/public/mui/js/mui.min.js"></script>
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
                url: '<?php echo U("Mobile/Detail/evaluate");?>',
                data: {page: ys},
                success: function (data) {
                    var str = "";//定义变量保存内容
                    $.each(data, function (index, array) {
                        if(array['id']){
                            str += '<div id="n_box1">';
                            str += '<div>';
                            str += '<h5 style="display: inline-block;height: 20px;line-height: 30px;color: #000000">'+array['truename']+'</h5>';
                            str += '<div style="display: inline-block;margin-left: 10px;float: right;margin-right: 1px">';
                            str += '<span  style="margin-right: 5px">'+array['ntime']+'</span>';
                            if(array['score'] == 1){
                                str += '<img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start1.png">';
                            }else if(array['score'] == 2){
                                str += '<img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start2.png">';
                            }else if(array['score'] == 3){
                                str += '<img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start3.png">';
                            }else if(array['score'] == 4){
                                str += '<img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start4.png">';
                            }else if(array['score'] == 5){
                                str += '<img style="width: 84px;display:inline-block;" src="/Public/website/Mobile/detail/images/start.png">';
                            }
                            str += '<span  style="margin-left: 5px">'+array['score']+'.0</span>';
                            str += '</div>';
                            str += '</div>';
                            str += '<div>';
                            if(array['ucontent']){
                                str += '<p style="border-bottom: none;padding:0">'+array['content']+'</p>';
                                str += '<p style="border-bottom: 0;padding:0"> <span style="color: #FA7124">追加内容【'+array['untime']+'】</span> '+array['ucontent']+'</p>';
                            }else{
                                str += '<p style="border-bottom: none;margin: 0">'+array['content']+'</p>';
                            }
                            str += '</div>';
                            str += '<div>';
                            for(var i in array['reply']){
                                str += '<p><span style="color: #FA7124">驾校回复【'+array['reply'][i]['ntime']+'】</span>'+array['reply'][i]['content']+'</p>';
                            }
                            str += '</div>';
                            str += '</div>';
                        }
                        //下拉刷新，新纪录插到最前面；
                    });
                    $(".new").append(str); //把HTML添加到容器
                    ys++;//页数+1
                }
            });
        }, 1500);
    }
    mui('body').on('tap','a',function(){document.location.href=this.href;});
</script>