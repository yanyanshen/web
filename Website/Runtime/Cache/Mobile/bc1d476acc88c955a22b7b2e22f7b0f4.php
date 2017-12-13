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
    <link rel="stylesheet" href="/Public/public/mui/css/mui.min.css">
    <link href="/Public/website/Mobile/consult/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/consult/css/media-queries.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/consult/css/studyNew.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
<body>


<div class="login_box">
    <div class="header_box" style="z-index: 3000">
        <div class="header">
            <ul>
                <li class="back"><a href="<?php echo U('Mobile/Index/index');?>"><img src="/Public/public/images/back.png"></a></li>
                <li class="header_text">驾考咨询</li>
                <div class="clearfix"></div>
            </ul>
        </div>
    </div>
        <div id="pullrefresh" style="margin-top: 15%" class="mui-content mui-scroll-wrapper">
            <div class="main mui-scroll" >
                <div class="studyNew">
                    <div class="new">
                        <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><a href="<?php echo U('Mobile/Consult/studyNew_detail',array('id'=>$data['id']));?>">
                                <div id="n_box1">
                                    <div class="n_img">
                                        <img style="border-radius: 3px" src="<?php echo ($data["picurl"]); ?>" width=""/>
                                    </div>
                                    <div class="n_main">
                                        <?php echo (mb_substr($data["title"],0,12,utf8)); ?>...
                                        <ul id="nm">
                                            <li class="date"><?php echo date('Y/m/d',$data['ntime']);?></li>
                                            <li class="num"><?php echo ($data["touch_count"]); ?></li>
                                            <li class="eye"><img src="/Public/website/Mobile/consult/images/eye.png"></li>
                                            <div class="clearfix"></div>
                                        </ul>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </a><?php endforeach; endif; else: echo "$empty" ;endif; ?>
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
                url: '<?php echo U("Mobile/Consult/studyNew");?>',
                data: {page: ys},
                success: function (data) {
                    var str = "";//定义变量保存内容
                    $.each(data, function (index, array) {
                        if(array['id']){
                            str += '<div id="n_box1">';
                            str += '<a href="'+"<?php echo U('Mobile/Consult/studyNew_detail');?>?id="+array['id']+'">';
                                str += '<div class="n_img">';
                                str += '<img style="border-radius: 3px" src="'+array['picurl']+'"/>';
                                str += '</div>';
                            str += '</a>';
                            str += '<div class="n_main">';
                            str += '<a href="'+"<?php echo U('Mobile/Consult/studyNew_detail');?>?id="+array['id']+'">'+array['title']+'</a>';
                            str += '<ul id="nm">';
                            str += '<li class="date">'+array['ntime']+'</li>';
                            str += '<li class="num">'+array['touch_count']+'</li>';
                            str += '<li class="eye"><img src="/Public/website/Mobile/consult/images/eye.png"></li>';
                            str +=  '<div class="clearfix"></div>';
                            str +=  '</ul>';
                            str +=  '</div>';
                            str += ' <div class="clearfix"></div>';
                            str +=  '</div>';
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