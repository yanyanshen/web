<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>语言教育列表</title>
		<meta name="viewport" content="width=device-width, initial-scale=1,maximum-scale=1,user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<link rel="stylesheet" href="/Public/public/mui/css/mui.min.css">
        <link href="/Public/website/Mobile/list/css/main.css" rel="stylesheet" type="text/css">
        <link href="/Public/website/Mobile/list/css/media-queries.css" rel="stylesheet" type="text/css">
        <link href="/Public/website/Mobile/list/css/initialize.css" rel="stylesheet" type="text/css">
        <link href="/Public/public/js/banner/cityPicker.css" rel="stylesheet" type="text/css">
        <link href="/Public/website/Mobile/list/css/list.css" rel="stylesheet" type="text/css">
        <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
        <script src="/Public/public/js/banner/banner.js"></script>
        <script type="text/javascript" charset="utf-8" src="/Public/website/Mobile/language/cityPicker.js"></script>
        <style>
            .mui-pull-caption{margin: auto 0;text-align: center;font-size: 15px;display: none}
            .mask{  width:100%;  height:120%;overflow-x: hidden;  position: absolute;;  top:0;  z-index:1;  background-color:#000;  opacity: 0.2;  margin:0;padding:0;  }
            .font{  width:85%;  height:120%;overflow-x: hidden;   float:right;  position:absolute;  top:0;  right:0;  z-index:2;  background-color:#fff;  margin:0;padding:0;  margin-right:-85%;  }
            .font li{  list-style: none;  border-bottom: 1px solid rgb(232, 232, 232);  overflow: auto padding: 5% 3% 3% 2%;color: rgb(102, 102, 102);  margin-left: 1%;margin-top: 2%;  }

            .countys{  background-color: rgb(246, 244, 244);  border-radius: 3px;padding:2.5% 1%;  width: 28%;text-align: left;margin: 1% 1%;  vertical-align: middle;  display: inline-block;  font-size: 0.1rem;  }
            .common{  width:12%;text-align: center; }
            .color{  color: #ffa538;}
            .cur{width:8px;height:8px;margin:0 1px;display:inline-block;-webkit-border-radius:5px;border-radius:5px;background-color:#fff;  }
        </style>
	</head>
<body>
    <div id="pagewrap">
        <div style="background: #fff;border-bottom: 2px;height: 51px;margin: 0;border-bottom: 1px solid #efefef;" >
                <input type="text" class="city"  style="margin-top: 6px;line-height: 10px;width: 24%;height: 30px;padding: 0;
                    font-size: 14px;color:red;border:none" id="cityname"  value="<?php echo (session('city')); ?>">
                <script type="text/javascript">
                    $(".city").CityPicker();
                </script>
                <div class="search_box" style="float: right;margin-right: 3%">
                    <form action="<?php echo U('Mobile/Language/language_list');?>" method="get" style="margin: 0;padding: 0">
                        <input type="text" name="language_keyword" value="<?php echo ($get['language_keyword']?$get['language_keyword']:''); ?>" placeholder="请输入名称" id="language_keyword" style='background: #fff;width: 81%;height: 26px;font-size:15px;border-radius: 5px;font-family: "Microsoft yahei" '  />
                        <input class="submit" style="background-color: #fff;float:right;position:absolute;border:none;padding: 5px 0 0 10px;
                               background-image:url(/Public/website/Mobile/list/images/search_03.png);" type="submit" value="" id="submit" />
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>
            <!--下拉刷新容器-->
        <div  style="margin-top: 55px;z-index: 1" id="pullrefresh"  class="mui-content mui-scroll-wrapper">
            <div class="mui-scroll">
				<!--数据列表-->
				<ul class="mui-table-view mui-table-view-chevron">
                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li style="width: 96%;padding: 3% 0;margin: 0;" class="mui-table-view-cell">
                            <div id="r_main" style="border-bottom: none">
                                <a href="<?php echo U('Mobile/Language/language_detail',array('id'=>$v['id']));?>"><?php echo ($v["nickname"]); ?>
                                    <div class="clearfix"></div>
                                    <ul id="rm">
                                        <li style="font-size: 10px" class="money">￥<?php echo ($v["minprice"]); ?> 元起</li>
                                        <li class="num" style="font-size: 10px"><?php echo ($v["num"]); ?>人已报名</li>
                                    </ul>
                                </a>
                                    <a href="<?php echo U('Mobile/Language/language_detail',array('id'=>$v['id']));?>#detail " style="color: white;font-size: 12px">
                                        <button style="margin-right: 0"> 马上报名</button>
                                    </a>
                                <div class="clearfix"></div>
                            </div>
                            <div id="r_img" style="border:1px solid #eee;border-radius: 3px">
                                <a href="<?php echo U('Mobile/Language/language_detail',array('id'=>$v['id']));?>">
                                    <img src="<?php echo ($v["picurl"]); ?>">
                                </a>
                            </div>
                            <div class="clearfix"></div>
                        </li><?php endforeach; endif; else: echo "$empty" ;endif; ?>
				</ul>
			</div>
		</div>
    </div>
    <div class="call_box" style="z-index: 1000">
        <a href="tel:4008040517"><img src="/Public/public/images/phone.png"></a>
    </div>
    <div class="sms_box" style="z-index: 1000">
        <a href="sms:18688888888"><img src="/Public/public/images/sms.png"></a>
    </div>
    <footer id="footer" style="z-index: 3">
        <ul>
                <a href="<?php echo U('Mobile/Index/index');?>">
                    <li class="foot">
                        <img src="/Public/public/images/icon-footer1-a.png">
                        <p>首页</p>
                    </li>
                </a>
                <a href="">
                    <li class="foot">
                        <img src="/Public/public/images/icon-footer02-a.png">
                        <p  style="color: #fa7124; font-weight: bold;">语言</p>
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
                        url: '<?php echo U("Mobile/Language/language_list");?>',
                        data: {page: ys},
                        success: function (data) {
                            var str = "";//定义变量保存内容
                            $.each(data, function (index, array) {
                                if(array['id']){
                                    str += '<li style="width: 96%;padding: 3% 0;margin: 0;" class="mui-table-view-cell">';
                                    str += ' <div id="r_main" style="border-bottom: none">';
                                    str += '<a  href="'+"<?php echo U('Mobile/Language/language_detail');?>?id="+array['id']+'">'+array['nickname']+'#detail';
                                    str += '<div class="clearfix"></div>';
                                    str += '<ul id="rm">';
                                    str += '<li class="money"  style="font-size: 10px" >￥'+array['minprice']+' 元起</li>';
                                    str += '<li class="num" style="font-size: 10px">'+array['num']+'人已报名</li>';
                                    str += '</ul>';
				                    str += '</a>';
                                    str += '<a style="color:white;font-size:10px" href="'+"<?php echo U('Mobile/Language/language_detail');?>?id="+array['id']+'#detail">';
                                    str += '<button style="margin-right: 0">马上报名</button></a>';
                                    str += '<div class="clearfix"></div>';
                                    str += '</div>';
                                    str += '<div id="r_img" style="border:1px solid #eee;border-radius: 3px">';
                                    str += '<a href="'+"<?php echo U('Mobile/Language/language_detail');?>?id="+array['id']+'#detail">';
                                    str += '<img src="'+array['picurl']+'">';
                                    str += '</a>';
                                    str += '</div>';
                                    str += '<div class="clearfix"></div>';
                                    str += '</div></li>';
                                }
                                //下拉刷新，新纪录插到最前面；
                            });
                            $(".mui-table-view").append(str); //把HTML添加到容器
                            ys++;//页数+1
                        }
                    });
				}, 1500);
			}
            mui('body').on('tap','a',function(){document.location.href=this.href;});
        </script>
	</body>
</html>