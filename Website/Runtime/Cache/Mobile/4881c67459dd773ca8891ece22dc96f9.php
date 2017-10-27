<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>列表页</title>
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
        <script type="text/javascript" charset="utf-8" src="/Public/website/Mobile/list/js/cityPicker.js"></script>
        <style>
            .mui-pull-caption{margin: auto 0;text-align: center;font-size: 15px;display: none}
            .mask{  width:100%;  height:120%;overflow-x: hidden;  position: absolute;;  top:0;  z-index:1;  background-color:#000;  opacity: 0.2;  margin:0;padding:0;  }
            .font{  width:85%;  height:120%;overflow-x: hidden;   float:right;  position:absolute;  top:0;  right:0;  z-index:2;  background-color:#fff;  margin:0;padding:0;  margin-right:-85%;  }
            .font li{  list-style: none;  border-bottom: 1px solid rgb(232, 232, 232);  overflow: auto padding: 5% 3% 3% 2%;color: rgb(102, 102, 102);  margin-left: 1%;margin-top: 2%;  }

            .countys{  background-color: rgb(246, 244, 244);  border-radius: 3px;padding:2.5% 1%;  width: 28%;text-align: left;margin: 1% 1%;  vertical-align: middle;  display: inline-block;  font-size: 0.1rem;  }
            .common{  width:12%;text-align: center; }
            .color{  color: #ffa538;}
        </style>
	</head>
	<body>
        <div id="pagewrap">
            <div style="background: #fff;border-bottom: 2px;height: 51px;margin: 0;border-bottom: 1px solid #efefef;position: fixed" >
                <input type="text" class="city"  style="margin-top: 6px;line-height: 10px;width: 24%;height: 30px;padding: 0;
                    font-size: 14px;color:red;border:none" id="cityname"  value="<?php echo (session('city')); ?>">
                <script type="text/javascript">
                    $(".city").CityPicker();
                </script>
                <div class="search_box" style="float: right;margin-right: 3%">
                    <form action="<?php echo U('Mobile/List/pull');?>" method="get" style="margin: 0;padding: 0">
                        <input id="keyword" style='background: #fff;width: 81%;height: 26px;font-size:15px;border-radius: 5px;font-family: "Microsoft yahei" ' type="text" name="k" value="<?php echo (session('k')); ?>" placeholder="请输入地址或驾校名称" />
                        <input class="submit"
                               style="background-color: #fff;float:right;position:absolute;border:none;padding: 5px 0 0 10px;
                               background-image:url(/Public/website/Mobile/list/images/search_03.png);" type="submit" value="" id="submit" />
                    </form>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>

                <div id="recomment" style="margin-top: 0px;" >
                    <div class="rl-school">
                        <div class="rr_box">
                            <div class="rr" >
                                <?php if($_SESSION['xueches_']['r']== 'recommand'): ?><a  class="color" href="<?php echo U('Mobile/List/pull',array('r'=>1));?>">推荐</a>
                                    <?php else: ?>
                                    <a style="color: #646464;" href="<?php echo U('Mobile/List/pull',array('r'=>1));?>">推荐</a><?php endif; ?>
                                <div class="rr_img">
                                    <img src="/Public/website/Mobile/list/images/jt01.png">
                                </div>
                            </div>
                        </div>
                        <div class="dr_box">
                            <div class="dr">
                                <?php if($_SESSION['xueches_']['all']== 'allcount'): ?><a class="color" href="<?php echo U('Mobile/List/pull',array('all'=>1));?>">人气</a>
                                    <?php else: ?>
                                    <a style="color: #646464;" href="<?php echo U('Mobile/List/pull',array('all'=>1));?>">人气</a><?php endif; ?>
                                <div class="rr_img">
                                    <img src="/Public/website/Mobile/list/images/jt01.png">
                                </div>
                            </div>
                        </div>
                        <div class="mr_box">
                            <div class="mr">
                                <?php if($_SESSION['xueches_']['p']== 'wholeprice'): ?><a class="color"  href="<?php echo U('Mobile/List/pull',array('p'=>1));?>">价格</a>
                                    <?php else: ?>
                                    <a style="color: #646464;" href="<?php echo U('Mobile/List/pull',array('p'=>1));?>">价格</a><?php endif; ?>
                                <div class="rr_img">
                                    <img src="/Public/website/Mobile/list/images/jt01.png">
                                </div>
                            </div>
                        </div>
                        <div class="er_box">
                            <div class="er">
                                <?php if($_SESSION['xueches_']['e']== 'evalutioncount'): ?><a class="color" href="<?php echo U('Mobile/List/pull',array('e'=>1));?>">评价</a>
                                    <?php else: ?>
                                    <a style="color: #646464;" href="<?php echo U('Mobile/List/pull',array('e'=>1));?>">评价</a><?php endif; ?>
                                <div class="rr_img">
                                    <img src="/Public/website/Mobile/list/images/jt01.png">
                                </div>
                            </div>
                        </div>
                        <div class="er_box">
                            <div class="er">
                                <button type="button" id="select" style="padding: 5px;background: #fff;color:#646464;border:none " data-loading-icon="mui-spinner mui-spinner-custom" class="mui-btn mui-btn-primary">筛选</button>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
    <!--下拉刷新容器-->
        <div  style="margin-top: 24%;z-index: 1" id="pullrefresh"  class="mui-content mui-scroll-wrapper">
            <div class="mui-scroll">
				<!--数据列表-->
				<ul class="mui-table-view mui-table-view-chevron">

                    <?php if(is_array($info)): $i = 0; $__LIST__ = $info;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><li style="width: 96%;padding: 3% 0;margin: 0;" class="mui-table-view-cell">
                            <div id="r_main" style="border-bottom: none">
                                <a href="<?php echo U('Mobile/Detail/index',array('id'=>$v['id']));?>"><?php echo ($v["nickname"]); ?>
                                <div class="clearfix"></div>
                                <ul id="rm">
                                    <li class="money">￥<?php echo ($v["wholeprice"]); ?></li>
                                    <li class="num" style="font-size: 11px"><?php echo ($v["allcount"]); ?>人已报名</li>
                                </ul>
			    </a>
                                <button >
                                    <a href="<?php echo U('Mobile/Order/choose_course',array('id'=>$v['id']));?>" style="color: white;">马上报名</a>
                                </button>
                                <div class="clearfix"></div>
                            </div>
                            <div id="r_img">
                                <?php if($v['type'] == 'jx'): ?><a href="<?php echo U('Mobile/Detail/index',array('id'=>$v['id']));?>">
                                        <img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); ?>">
                                    </a><?php endif; ?>
                                <?php if($v['type'] == 'jl'): ?><a href="<?php echo U('Mobile/Detail/index',array('id'=>$v['id']));?>">
                                        <img src="<?php echo ($http); ?>/Uploads/coach_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); ?>">
                                    </a><?php endif; ?>
                                <?php if($v['type'] == 'zd'): ?><a href="<?php echo U('Mobile/Detail/index',array('id'=>$v['id']));?>">
                                        <img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($v["picurl"]); echo ($v["picname"]); ?>">
                                    </a><?php endif; ?>
                            </div>
                            <div class="clearfix"></div>
                        </li><?php endforeach; endif; else: echo "$empty" ;endif; ?>
				</ul>
			</div>
		</div>
    </div>
            <div class="call_box" style="z-index: 1000">
                <a href="tel:4008040517"><img src="/Public/website/Mobile/list/images/phone.png"></a>
            </div>
            <div class="sms_box" style="z-index: 1000">
                <a href=""><img src="/Public/website/Mobile/list/images/sms.png"></a>
            </div>
            <footer id="footer" style="z-index: 3">
            <ul>
                <li class="foot">
                    <a href="<?php echo U('Mobile/Index/index');?>">
                        <img src="/Public/website/Mobile/list/images/icon-footer1-a.png">
                        <p>首页</p>
                    </a>
                </li>
                <li class="foot">
                    <a href="">
                        <img src="/Public/website/Mobile/list/images/icon-footer2-a.png">
                        <p>语言</p>
                    </a>
                </li>
                <li class="foot">
                    <a href="#">
                        <img src="/Public/website/Mobile/list/images/icon-footer03-a.png">
                        <p style="color: #fa7124; font-weight: bold;">驾校</p>
                    </a>
                </li>
                <li class="foot">
                    <a href="<?php echo U('Mobile/Cyclope/baike');?>">
                        <img src="/Public/website/Mobile/list/images/icon-footer4-a.png">
                        <p>百科</p>
                    </a>
                </li>
                <li class="foot">
                    <?php if($_SESSION['xueches_']['mid']== ''): ?><a href="<?php echo U('Mobile/Login/login');?>">
                            <img src="/Public/website/Mobile/Index/images/icon-footer5-a.png">
                            <p>我的</p>
                        </a>
                        <?php else: ?>
                        <a href="<?php echo U('Mobile/User/user_center');?>">
                            <img src="/Public/website/Mobile/Index/images/icon-footer5-a.png">
                            <p>我的</p>
                        </a><?php endif; ?>
                </li>
            </ul>
        </footer>
            <div class="tan">
                <div class="mask" style="display:none;"></div>
                <div ></div>
                <ul class="font" style="z-index: 1000">
                </ul>
            </div>
        <script src="/Public/public/mui/js/mui.min.js"></script>
        <script>
            var btn = document.getElementById("select");
            //监听点击事件
            btn.addEventListener("tap",function () {
                $.post("<?php echo U('Mobile/List/select');?>",'',function(res){
                    var str='';
                    if(res.status==1){
                        str += '<form action="'+"<?php echo U('Mobile/List/pull');?>"+'" method="post" >';
                        str += '<li id="header" style="width: 100%;height: 2%;background-color: rgb(246, 244, 244);color: rgb(179, 179, 179);padding:1% 3% 1% 6%;border-bottom:none;">';
                        str += '筛选</li>';
                        str += '<li>当前城市';
                        str += '<p style="background-color: rgb(246, 244, 244); border-radius: 3px;padding:1%;width: 25%;text-align: left;">';
                        str += "<?php echo (session('city')); ?>"+'</p></li>';
                        str += '<li>' +
                        '<span style="margin-left: 1%;color: rgb(102, 102, 102);width: 100%">区/县</span><br>';
                        for(var i in res.info['countys']){
                            str += '<div class="countys"><input type="radio" name="countyid" value="'+res.info['countys'][i]['id']+'"/>'
                            + "&nbsp;"+res.info['countys'][i]['countyname']+'</div>'
                        }
                        str +=  '</li><li>' +
                        '<span style="margin-left: 1%;color: rgb(102, 102, 102)">小车(通车)</span><br>';
                        for(var y in res.info['xc']){
                            str += '<div class="countys common"><input type="radio" name="jztype" value="'+res.info['xc'][y]['id']+'"/>'
                            + "&nbsp;"+res.info['xc'][y]['jztype']+'</div>' ;
                        }
                        str += '</li><li class="kc"><span style="margin-left: 1%;color: rgb(102, 102, 102)">客车/货车</span><br>'

                        for(var o in res.info['kc']){
                            str += '<div class="countys common"><input type="radio" name="jztype" value="'+res.info['kc'][o]['id']+'"/>'
                            + "&nbsp;"+res.info['kc'][o]['jztype']+'</div>' ;
                        }
                        str += "</li><li style='margin-left: 0px;position: fixed;bottom: 0px;width: 100%;'>" +
                        "<input  style='z-index:3000;background-color:red ;padding:1px 50% 3px 39%;border:1px solid red;height: 45px;font-size: 17px;text-align: left;color: white;' type='submit' value='完成'/></li>";
                        str += "</li></form>";
                        $(".font").html(str);
                    }
                },'json');
                $(".mask").show();
                $(".font").animate({'right':'85%'},500);
            });

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
                        url: '<?php echo U("Mobile/List/pull");?>',
                        data: {page: ys},
                        success: function (data) {
                            var str = "";//定义变量保存内容
                            $.each(data, function (index, array) {
                                if(array['id']){
                                    str += '<li style="width: 96%;padding: 3% 0;margin: 0;" class="mui-table-view-cell">';
                                    str += ' <div id="r_main" style="border-bottom: none">';
                                    str += '<a href="'+"<?php echo U('Mobile/Detail/index');?>?id="+array['id']+'">'+array['nickname'];
                                    str += '<div class="clearfix"></div>';
                                    str += '<ul id="rm">';
                                    str += '<li class="money">￥'+array['wholeprice']+'</li>';
                                    str += '<li class="num" style="font-size: 11px">'+array['allcount']+'人已报名</li>';
                                    str += '</ul>';
				str += '</a>';
                                    str += '<button style="margin-right: 8%">';
                                    str += '<a style="color:white" href="'+"<?php echo U('Mobile/Order/choose_course');?>?id="+array['id']+'">'+'马上报名</a>';
                                    str += '</button>';
                                    str += '<div class="clearfix"></div>';
                                    str += '</div>';
                                    str += '<div id="r_img">';
                                    if(array['type'] == 'jx'){
                                        str += '<a href="'+"<?php echo U('Mobile/Detail/index');?>?id="+array['id']+'">';
                                        str += '<img src="<?php echo ($http); ?>/Uploads/School_logo/'+array['picurl']+array['picname']+'">';
                                        str += '</a>';
                                    }
                                    if(array['type'] == 'jl'){
                                        str += '<a href="'+"<?php echo U('Mobile/Detail/index');?>?id="+array['id']+'">';
                                        str += '<img src="<?php echo ($http); ?>/Uploads/coach_logo/'+array['picurl']+array['picname']+'">';
                                        str += '</a>';
                                    }
                                    if(array['type'] == 'zd'){
                                        str += '<a href="'+"<?php echo U('Mobile/Detail/index');?>?id="+array['id']+'">';
                                        str += '<img src="<?php echo ($http); ?>/Uploads/guider_logo/'+array['picurl']+array['picname']+'">';
                                        str += '</a>';
                                    }
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