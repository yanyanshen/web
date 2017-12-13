<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=content-type content="text/html; charset=utf-8" />
       <link href="/Public/website/Admin/ment/css/admin.css" type="text/css" rel="stylesheet" />
        <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
        <script>
            function expand(el) {
                childobj = document.getElementById("child" + el);
                if (childobj.style.display == 'none') {
                    childobj.style.display = 'block';
                } else {
                    childobj.style.display = 'none';
                }
                return;
            }
        </script>
        <script>
		$("document").ready(function(){
			var arr="<?php echo (session('permissid')); ?>";
				arr1=arr.split(",").join(",");
				for(i=0;i<arr1.length;i++){
					if(arr1[i]==','){
						continue;
					}else{
						$("#"+arr1[i]).css("display",'block').css("width",150);
					}
				}
		});
		</script>
        <style>
            a:hover{color: #13b5b1}
        </style>
    </head>
    <body>
    <!--<table height="100%" cellspacing=0 cellpadding=0 width=170 background=/Public/website/Admin/ment/img/menu_bg.jpg border=0>
        <tr>
            <div id=0>
            <table  style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
            <tr height=30 >
            <td style="padding-left: 30px;background-color: #25a8f9;">
            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;"  class=menuparent onclick=expand(0)  href="javascript:void(0);">后台首页</a>
            </td>
            </tr>
            <tr height=4><td></td></tr>
            </table>
            </div>
            <div id=13>
                <table  style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30 >
                        <td style="padding-left: 30px;background-color: #25a8f9;">
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;"  class=menuparent onclick=expand(13)  href="javascript:void(0);">权限管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>

            <table id=child13 style="display: none;background-color: rgba(247, 241, 236, 0.07)"  cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25 >
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td >
                        <a style="text-decoration: none;" class=menuchild href="<?php echo U('Admin/index');?>" target=right>管理员列表</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/AuthGroup/index');?>" target=right>管理组列表</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/AuthRule/index');?>" target=right>权限列表</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/AdminNav/index');?>" target=right>菜单列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=11>
                <table  style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30 >
                        <td style="padding-left: 30px;background-color: #25a8f9;">
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;"  class=menuparent onclick=expand(11)  href="javascript:void(0);">订单管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child11 style="display: none;background-color: rgba(247, 241, 236, 0.07)"  cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25 >
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td >
                        <a style="text-decoration: none;" class=menuchild href="<?php echo U('Admin/Order/order_list');?>" target=right>订单列表</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Order/order_list');?>" target=right>订单列表(管理)</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Order/order_list');?>" target=right>订单统计</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Order/order_list');?>" target=right>订单来源报表</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Order/order_list');?>" target=right>订单来源关键字统计</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Order/pay_list');?>" target=right>已支付未处理订单列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=1>
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30 >
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(4)  href="javascript:void(0);">驾校管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child4 style="display: none"  cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/School/jx_list');?>" target=right>驾校管理</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/School/hot_list');?>" target=right>热搜驾校</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/School/recommand_list');?>" target=right>推荐驾校</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/School/week_list');?>" target=right>本周驾校</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=2 >
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none" class=menuparent onclick=expand(2) href="javascript:void(0);">教练管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child2 style="display: none"  cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=20>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a class=menuchild href="<?php echo U('Admin/CoachCategory/index');?>" target=right>分类管理</a>
                    </td>
                </tr>
                <tr height=20>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a class=menuchild href="<?php echo U('Admin/Coach/index_list');?>" target=right>教练列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=3>
                <table  style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;"  >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(3) href="javascript:void(0);">指导员管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child3 style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=20>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a class=menuchild href="<?php echo U('Admin/GuiderCategory/index');?>" target=right>分类管理</a>
                    </td>
                </tr>
                <tr height=20>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a class=menuchild href="<?php echo U('Admin/Guider/index_list');?>" target=right>指导员列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=3>
                <table style="background-color: #fbe095;"  cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(12) href="javascript:void(0);">学员管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child12 style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Student/stu_list');?>" target=right>学员列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=4 >
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(1) href="javascript:void(0);">基地管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child1 style="display: none;" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/TrainAddress/index');?>" target=right>基地列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=5>
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(5) href="javascript:void(0);">地标管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child5 style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/LandMark/index');?>" target=right>地标列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=6>
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(7) href="javascript:void(0);">新闻管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child7 style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Hot/index');?>" target=right>517热点</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Consult/index');?>" target=right>咨询列表</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Consult/first_index');?>" target=right>首页资讯</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=7>
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(8) href="javascript:void(0);">轮播图管理</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child8 style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Slideshow/index');?>" target=right>轮播图列表</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=8>
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(9) href="javascript:void(0);">理论学习</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child9 style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Exam/exam');?>" target=right>试题添加</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>

            <div id=9>
                <table style="background-color: #fbe095;" cellspacing=0 cellpadding=0 width=150 border=0 >
                    <tr height=30>
                        <td style="padding-left: 30px;background-color: #25a8f9;" >
                            <a style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(10) href="javascript:void(0);">百科</a>
                        </td>
                    </tr>
                    <tr height=4><td></td></tr>
                </table>
            </div>
            <table id=child10 style="display: none" cellspacing=0 cellpadding=0 width=150 border=0>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none" class=menuchild href="<?php echo U('Admin/Cyclope/index');?>" target=right>内容展示</a>
                    </td>
                </tr>
                <tr height=25>
                    <td align=middle width=30>
                        <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                    </td>
                    <td>
                        <a style="text-decoration: none"  class=menuchild href="<?php echo U('Admin/Cyclope/add');?>" target=right>视频添加</a>
                    </td>
                </tr>
                <tr height=4><td colspan=2></td></tr>
            </table>
            <td width=1 bgcolor=#d1e6f7></td>
        </tr>
    </table>-->
    <table height="100%"  cellspacing=0 cellpadding=0 width=170 background=/Public/website/Admin/ment/img/menu_bg.jpg border=0>
        <tr>
            <?php if(is_array($navList)): $i = 0; $__LIST__ = $navList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v1): $mod = ($i % 2 );++$i; if(empty($v1['child'])): ?><div id=<?php echo ($v1['priority']); ?>>
                        <table cellspacing=0 cellpadding=0 width=150 border=0 >
                            <tr height=30>
                                <td style="padding-left: 30px;background-color: #13b5b1;" >
                                    <a  href="javascript:void(0);" style="color: #ffffff;text-decoration: none;font-weight: bolder;" class=menuparent onclick=expand(<?php echo ($v1['priority']); ?>)><?php echo ($v1['navname']); ?></a>
                                </td>
                            </tr>
                            <tr><td style="border-bottom: 1px #71cdca solid"></td></tr>
                        </table>
                    </div>
                    <?php else: ?>
                    <div id=<?php echo ($v1['priority']); ?> style="padding:0">
                        <table cellspacing=0 cellpadding=0 width=150 border=0 >
                            <tr height=30>
                                <td style="padding-left: 30px;background-color: #13b5b1;">
                                    <a style="color: #ffffff;text-decoration: none;font-weight: bold;"  class=menuparent  onclick=expand(<?php echo ($v1['priority']); ?>)  href="javascript:void(0);"><?php echo ($v1['navname']); ?></a>
                                </td>
                            </tr>
                            <tr><td style="border-bottom: 1px #71cdca solid"></td></tr>
                        </table>
                    </div><?php endif; ?>
                <table id=child<?php echo ($v1['priority']); ?> style="display: none;background-color: rgba(247, 241, 236, 0.07)"  cellspacing=0 cellpadding=0 width=150 border=0>
                    <?php if(!empty($v1['child'])): if(is_array($v1['child'])): $k = 0; $__LIST__ = $v1['child'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v2): $mod = ($k % 2 );++$k;?><tr height=25>
                                <td align=middle width=30 style="border:1px solid #ffffff">
                                    <img height=9 src="/Public/website/Admin/ment/img/menu_icon.gif" width=9>
                                </td>
                                <td style="border: none">
                                    <a style="text-decoration: none;" class=menuchild href="<?php echo U($v2['navurl']);?>?pid=<?php echo ($v2['id']); ?>" target=right><?php echo ($v2["navname"]); ?></a>
                                </td>
                            </tr><?php endforeach; endif; else: echo "" ;endif; endif; ?>
                </table><?php endforeach; endif; else: echo "" ;endif; ?>
        </tr>
    </table>
    </body>
</html>