<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>我要去学车</title>
   <meta name="keywords" content="我要去学车，学车，驾照，考驾照，拿证，驾驶证，去哪学车，去学车，驾证">
   <meta name="description" content="我要去学车网-全国驾考学车平台，优质服务，专业指导，让天下没有难考的驾照！">
   <link rel="stylesheet" type="text/css" href="/Public/website/Home/index/css/main.css">
    <link rel="stylesheet" href="/Public/website/Home/index/css/cityselect.css">
    <script src="/Public/website/Home/index/js/jquery.js"></script>
   <script src="/Public/website/Home/index/js/img_play.js"></script>
   <script src="/Public/website/Home/index/js/city.js"></script>
   <script src="/Public/website/Home/index/js/click.js"></script>
    <script type="text/javascript" src="/Public/website/Home/index/js/cityselect.js"></script>
    <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=mbF3FSfdd6Kyprj0xUlrk40RB0F5tpj2"></script>

</head>
<body>
<div class="top_box">
   <div class="top_center">
      <a href="">关于我们</a>
      <a href="">学车指南</a>
      <a href="">订单中心</a>
      <a href="" style="color: #ff5a00;">注册</a>
      <a href="" style="color: #ff5a00;">亲，请登录！</a>
   </div>
   <div class="clearfix"></div>
</div>
<div class="logo_box">
<div class="logo_center">
   <div class="logo_left">
      <img class="logo_image" src="/Public/website/Home/index/images/logo_01.png">
      <img class="logo_line" src="/Public/website/Home/index/images/logo02.png">
      <img class="gps" src="/Public/website/Home/index/images/gps.png">
       <div class="demo" style="width:100px;float: left;margin:28px auto;">
           <input type="text" class="cityinput" value="<?php echo (session('city')); ?>" id="citySelect" autoComplete='off' placeholder="">
       </div>
       <script type="text/javascript">
           var test=new Vcity.CitySelector({input:'citySelect'});

       </script>
   </div>
   <div class="logo_right">
      <ul>
         <li><a href="">首页</a></li>
         <li><a href="">报名学车</a></li>
         <li><a href="">理论学习1</a></li>
         <li><a href="">行业资讯</a></li>
         <li><a href="">软件下载</a></li>
         <li><a href="">关于我们</a></li>
      </ul>
   </div>
   <div class="clearfix"></div>
</div>
</div>

<div class="banner" id="banner">
   <div class="banner-item">
      <a href='#this'><img src='/Public/website/Home/index/images/01.jpg'/></a>
   </div>
   <div class="banner-item">
      <a href='#this'><img src='/Public/website/Home/index/images/02.jpg'/></a>
   </div>
   <div class="banner-item">
      <a href='#this'><img src='/Public/website/Home/index/images/03.jpg'/></a>
   </div>
   <div class="banner_dl_room">
      <div id="banner_dl"></div>
   </div>
</div>

<div class="search_box">
    <div class="search_bg">
        <div id="search_input">
            <div id="search_main">
                <form action="<?php echo U('Home/Search/index');?>" method="post">
                    <select id="sort" name="condition">
                        <option value="1">驾校</option>
                        <option value="2">位置</option>
                    </select>
                    <input type="text" value="" id="lng" name="lng"/>
                    <input type="text" value="" id="lat" name="lat"/>
                    <input id="search" type="text"  name="k" value="" placeholder="广源驾校" />
                    <input id="submit" type="submit" value=""/>
                </form>
            </div>
        </div>
        <div id="search_school">
            <ul>
                <li id="search_name">上海市中心驾校</li>
                <li id="search_name">上海广源驾校</li>
                <li id="search_name">上海华程驾校</li>
                <li id="search_name">上海五汽驾校</li>
                <li id="search_name">上海新星驾校</li>
            </ul>
        </div>
        <div id="l-map" style="display: none"></div>
        <div id="searchResultPanel" style="border:1px solid #C0C0C0;width:150px;height:auto; display:none;"></div>
    </div>
</div>
<div class="main_box">

   <div class="main_box2">

      <div class="main2">

         <div class="main2_top">
            <h1>排行榜</h1>
            <div class="main2_top2">
               <img src="/Public/website/Home/index/images/27.png">
               <h2>选择适合自己的学车导师</h2>
               <img src="/Public/website/Home/index/images/27.png">
               <div class="clearfix"></div>
            </div>
         </div>

         <div class="main2_bottom">
            <div class="main2_bottom1">
               <div class="main2_bt1">
                  <h1>驾校</h1>
               </div>
               <div class="main2_bb1">
                   <?php if(is_array($schools)): $k = 0; $__LIST__ = $schools;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$schools): $mod = ($k % 2 );++$k;?><div class="main2_school">
                           <?php if($k > 4): ?><div class="number_box"><div class="number4"><?php echo ($k); ?></div></div>
                                <?php else: ?>
                               <div class="number_box"><div class="number<?php echo ($k); ?>"><?php echo ($k); ?></div></div><?php endif; ?>
                           <div class="name_school"><a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$schools['id']));?>"><?php echo ($schools["schools_name"]); ?></a></div>
                           <div class="cost_school"><a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$schools['id']));?>"><?php echo ($schools["schools_price"]); ?>/起</a></div>
                           <div class="human_school"><a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$schools['id']));?>"><span style="color:#ff5a00; font-size: 14px;"><?php echo ($schools["schools_num"]); ?></span>人已报名</a></div>
                       </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                  <div class="more"><a href="">查看更多</a></div>
               </div>
            </div>

            <div class="main2_bottom2">
               <div class="main2_bt2">
                  <h1>教练</h1>
               </div>
               <div class="main2_bb2">
                   <?php if(is_array($coachs)): $k = 0; $__LIST__ = $coachs;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$coachs): $mod = ($k % 2 );++$k;?><div class="main2_teacher">
                          <?php if($k > 4): ?><div class="number_box1"><div class="number4"><?php echo ($k); ?></div></div>
                              <?php else: ?>
                              <div class="number_box1"><div class="number<?php echo ($k); ?>"><?php echo ($k); ?></div></div><?php endif; ?>
                         <div class="head_portrait"><div class="head"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div></div>
                         <div class="teacher_box">
                            <div class="teacher1">
                               <a href="" class="name_teacher"><?php echo ($coachs["coachs_name"]); ?></a>
                               <img src="/Public/website/Home/index/images/5_07.png" class="star">
                            </div>
                            <div class="teacher2">
                               <a href="" class="cost_teacher"><?php echo ($coachs["coachs_price"]); ?>元/起</a>
                               <a href="" class="apply_teacher"><span style="color:#ff5a00; font-size: 16px; font-family:"微软雅黑";><?php echo ($coachs["coachs_num"]); ?></span>人已报名</a>
                            </div>
                         </div>
                      </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                  <div class="more"><a href="">查看更多</a></div>
               </div>
            </div>

            <div class="main2_bottom3">
               <div class="main2_bt3">
                  <h1>指导员</h1>
               </div>
               <div class="main2_bb3">
                   <?php if(is_array($offers)): $k = 0; $__LIST__ = $offers;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$offers): $mod = ($k % 2 );++$k;?><div class="main2_teacher">
                           <?php if($k > 4): ?><div class="number_box1"><div class="number4"><?php echo ($k); ?></div></div>
                               <?php else: ?>
                               <div class="number_box1"><div class="number<?php echo ($k); ?>"><?php echo ($k); ?></div></div><?php endif; ?>
                           <div class="head_portrait"><div class="head"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div></div>
                           <div class="teacher_box">
                               <div class="teacher1">
                                   <a href="" class="name_teacher"><?php echo ($offers["offers_name"]); ?></a>
                                   <img src="/Public/website/Home/index/images/5_07.png" class="star">
                               </div>
                               <div class="teacher2">
                                   <a href="" class="cost_teacher"><?php echo ($offers["offers_price"]); ?>元/起</a>
                                   <a href="" class="apply_teacher">已教学员<span style="color:#ff5a00; font-size: 16px; font-family:"微软雅黑";><?php echo ($offers["offers_num"]); ?></span>人</a>
                               </div>
                           </div>
                       </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                  <div class="more"><a href="">查看更多</a></div>
               </div>
            </div>
            <div class="clearfix"></div>
         </div>

      </div>

   </div>

   <div class="main_box1">
      <div class="main1">
         <div class="main1_top">
            <h1>培训课程</h1>
            <div class="main1_top1">
            <img src="/Public/website/Home/index/images/27.png">
            <h2>选择适合自己的驾考模式</h2>
            <img src="/Public/website/Home/index/images/27.png">
            <div class="clearfix"></div>
            </div>
         </div>

         <div class="main1_bottom">
            <div class="main1_bottom1">
               <img src="/Public/website/Home/index/images/course1.png">
               <h1>驾考全包</h1>
               <a href="">VIP班</a>
               <a href="">速成班</a>
               <a href="">周末班</a>
               <a href="">周一到周五班</a>
               <a href="">周一到周日班</a>
            </div>
            <div class="main1_bottom2">
               <img src="/Public/website/Home/index/images/course2.png">
               <h1>计时培训</h1>
               <a href="">VIP班</a>
               <a href="">速成班</a>
               <a href="">周末班</a>
               <a href="">周一到周五班</a>
               <a href="">周一到周日班</a>
            </div>
            <div class="main1_bottom3">
               <img src="/Public/website/Home/index/images/course3.png">
               <h1>自学直考</h1>
               <a href="">VIP班</a>
               <a href="">速成班</a>
               <a href="">周末班</a>
               <a href="">周一到周五班</a>
               <a href="">周一到周日班</a>
            </div>
            <div class="clearfix"></div>
         </div>   
      </div>
   </div>


   <div class="main_box3_1">
      <div class="main3_1">
         <div class="main3_1_top">
            <h1>热门驾校</h1>
            <div class="main3_1_top3">
               <img src="/Public/website/Home/index/images/27.png">
               <h2>一流服务、专业高效</h2>
               <img src="/Public/website/Home/index/images/27.png">
               <div class="clearfix"></div>
            </div>
         </div>
         <div class="main3_1_bottom">
            <div class="hot_10">
                <?php if(is_array($hots)): $k = 0; $__LIST__ = array_slice($hots,0,10,true);if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$hots): $mod = ($k % 2 );++$k;?><div class="main3_school">
                        <?php if($k < 4): ?><div class="number_box3"><div class="number<?php echo ($k); ?>_1"><?php echo ($k); ?></div></div>
                            <?php else: ?>
                            <div class="number_box3"><div class="number4_1"><?php echo ($k); ?></div></div><?php endif; ?>

                        <div class="name_school3">
                            <a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$hotLeft['id']));?>"><?php echo ($hots["schools_name"]); ?></a>
                        </div>
                    </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
               <div class="clearfix"></div>
            </div>
            <div class="hot_box">
               <div class="hot_left">
                   <?php if(is_array($hotsRight)): $i = 0; $__LIST__ = array_slice($hotsRight,10,8,true);if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$hotsRight): $mod = ($i % 2 );++$i;?><div id="hot_school">
                           <div class="hot_school_top">
                               <a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$hotsRight['id']));?>" class="hot_s_name"><?php echo ($hotsRight["schools_name"]); ?></a>
                               <p class="hot_s_jz"><?php echo ($hotsRight["type_name"]); ?>照</p>
                               <p class="hot_s_h">￥<?php echo ($hotsRight["schools_price"]); ?></p>
                               <p class="hot_s_n">￥<?php echo ($hotsRight["schools_nowprice"]); ?></p>
                               <div class="clearfix"></div>
                           </div>
                           <div class="hot_school_bottom">
                               <p class="hot_s_t">已有<?php echo ($hotsRight["schools_num"]); ?>名学员报名</p>
                               <a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$hotsRight['id']));?>" class="hot_s_b">详情>></a>
                               <div class="clearfix"></div>
                           </div>
                       </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
               </div>
               <div class="hot_right">
                   <?php if(is_array($hotsRight1)): $i = 0; $__LIST__ = array_slice($hotsRight1,18,26,true);if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$hotsRight): $mod = ($i % 2 );++$i;?><div id="">
                           <div class="hot_school_top">
                               <a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$hotsRight['id']));?>" class="hot_s_name"><?php echo ($hotsRight["schools_name"]); ?></a>
                               <p class="hot_s_jz"><?php echo ($hotsRight["type_name"]); ?>照</p>
                               <p class="hot_s_h">￥<?php echo ($hotsRight["schools_price"]); ?></p>
                               <p class="hot_s_n">￥<?php echo ($hotsRight["schools_nowprice"]); ?></p>
                               <div class="clearfix"></div>
                           </div>
                           <div class="hot_school_bottom">
                               <p class="hot_s_t">已有<?php echo ($hotsRight["schools_num"]); ?>名学员报名</p>
                               <a href="<?php echo U('Home/SchoolsDetail/index',array('id'=>$hotsRight['id']));?>" class="hot_s_b">详情>></a>
                               <div class="clearfix"></div>
                           </div>
                       </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
               </div>
            </div>
            <div class="hot_image">
               <div class="image_every"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div>
               <div class="image_every"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div>
               <div class="image_every"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div>
               <div class="image_every"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div>
               <div class="image_every"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div>
               <div class="image_every"><a href=""><img src="/Public/website/Home/index/images/head1.png"></a></div>
            </div>
            <div class="clearfix"></div>
         </div>

      </div>
   </div>


   <div class="main_box3">
      <div class="main3">
      
         <div class="main3_top">
            <h1>驾考环境</h1>
            <div class="main3_top3">
               <img src="/Public/website/Home/index/images/27.png">
               <h2>选择自己心仪的驾考环境</h2>
               <img src="/Public/website/Home/index/images/27.png">
               <div class="clearfix"></div>
            </div>
         </div>
         
         <div class="main3_bottom">
            <div class="main3_bottom1">
               <img src="/Public/website/Home/index/images/yunxing.jpg">
            </div>
            <div class="main3_bottom2">
               <img src="/Public/website/Home/index/images/20140823111641.JPG">
            </div>
            <div class="main3_bottom3">
               <img src="/Public/website/Home/index/images/20160602133244.jpg">
            </div>
            <div class="main3_bottom4">
               <img src="/Public/website/Home/index/images/20160602133244.jpg">
            </div>
            <div class="main3_bottom5">
               <img src="/Public/website/Home/index/images/20110609041655826.jpg">
            </div>
            <div class="main3_bottom6">
               <img src="/Public/website/Home/index/images/20160628163556.png">
            </div>
            <div class="clearfix"></div>
            
         </div>

      </div>
   
   </div>
   

   <div class="main_box6">
      <div class="main6">

         <div class="main6_top">
            <h1>学车流程</h1>
            <div class="main6_top6">
               <a href="">科目一交规</a>
               <a href="">科目二小路</a>
               <a href="">科目三大路</a>
               <a href="">科目四安全文明</a>
               <div class="clearfix"></div>
            </div>
         </div>

         <div class="main6_bottom">
            <div class="main6_bottom1">
               <a href="">
                  <img src="/Public/website/Home/index/images/head1.png">
               </a>
            </div>
            <div class="main6_bottom2">
               <div class="guide1">
                  <div class="guide1_img">
                     <a href="">
                        <img src="/Public/website/Home/index/images/guide02.png">
                     </a>
                  </div>
                  <div class="guide1_text">
                     <a href="">
                        <h1>2017科一快速考试记忆法</h1>
                        <div class="guide1_text_p"><p>道路交通标志是用图形符号、颜色和文字向交通参与者传递特定信息，是用于管理交通的设施，交通标志的颜色共有
                           七种，每一种的用途都是不相同的，下面就一一为您介绍。</p></div>
                     </a>
                  </div>
               </div>
               <div class="guide2">
                  <div class="guide1">
                     <div class="guide1_img">
                        <a href="">
                           <img src="/Public/website/Home/index/images/guide_61.png">
                        </a>
                     </div>
                     <div class="guide1_text">
                        <a href="">
                           <h1>2017科一快速考试记忆法</h1>
                           <div class="guide1_text_p"><p>道路交通标志是用图形符号、颜色和文字向交通参与者传递特定信息，是用于管理交通的设施，交通标志的颜色共有
                              七种，每一种的用途都是不相同的，下面就一一为您介绍。</p></div>
                        </a>
                     </div>
                  </div>
               </div>
               <div class="guide3">
                  <div class="guide1">
                     <div class="guide1_img">
                        <a href="">
                           <img src="/Public/website/Home/index/images/guide01_63.png">
                        </a>
                     </div>
                     <div class="guide1_text">
                        <a href="">
                           <h1>2017科一快速考试记忆法</h1>
                           <div class="guide1_text_p"><p>道路交通标志是用图形符号、颜色和文字向交通参与者传递特定信息，是用于管理交通的设施，交通标志的颜色共有
                              七种，每一种的用途都是不相同的，下面就一一为您介绍。</p></div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
            <div class="main6_bottom3">

               <div class="privilege_box1">
                  <h1>最新特惠信息</h1>
               </div>

               <div class="privilege_box2">
                  <div class="privilege">
                     <div class="privilege_img">
                        <img src="/Public/website/Home/index/images/guide01_63.png">
                     </div>
                     <div class="privilege_text">
                        <a href="">
                           <p><span style="color:rgb(63,160,239); font-weight: bold;">广源驾校</span>计时收费 1对1分期缴纳 最快35天拿到驾驶证</p>
                        </a>
                     </div>
                  </div>
                  <div class="privilege">
                     <div class="privilege_img">
                        <img src="/Public/website/Home/index/images/guide01_63.png">
                     </div>
                     <div class="privilege_text">
                        <a href="">
                           <p><span style="color:rgb(63,160,239); font-weight: bold;">广源驾校</span>计时收费 1对1分期缴纳 最快35天拿到驾驶证</p>
                        </a>
                     </div>
                  </div>
                  <div class="privilege">
                     <div class="privilege_img">
                        <img src="/Public/website/Home/index/images/guide01_63.png">
                     </div>
                     <div class="privilege_text">
                        <a href="">
                           <p><span style="color:rgb(63,160,239); font-weight: bold;">广源驾校</span>计时收费 1对1分期缴纳 最快35天拿到驾驶证</p>
                        </a>
                     </div>
                  </div>
                  <div class="privilege">
                     <div class="privilege_img">
                        <img src="/Public/website/Home/index/images/guide01_63.png">
                     </div>
                     <div class="privilege_text">
                        <a href="">
                           <p><span style="color:rgb(63,160,230); font-weight: bold;">广源驾校</span>计时收费 1对1分期缴纳 最快35天拿到驾驶证</p>
                        </a>
                     </div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>

   
   <div class="main_box4">
      <div class="main4">
      
         <div class="main4_top">
            <h1>学车流程</h1>
            <div class="main4_top4">
               <img src="/Public/website/Home/index/images/27.png">
               <h2>517学车流程，助你早日拿驾照</h2>
               <img src="/Public/website/Home/index/images/27.png">
               <div class="clearfix"></div>
            </div>
         </div>
         
         <div class="main4_bottom">
            <div class="main4_bottom1">
               <img src="/Public/website/Home/index/images/42.png">
               <h1>报名</h1>
               
                 <a href="">驾考模式</a>
                 <a href="">学车费用</a>
                 <a href="">学车流程</a>
                 <a href="">体检流程</a>
               
            </div>
            <div class="main4_bottom2">
               <img src="/Public/website/Home/index/images/44.png">
               <h1>科目一</h1>
               
                 <a href="">理论考试</a>
                 <a href="">考试内容</a>
                 <a href="">考试标准</a>
                 <a href="">考试技巧</a>
               
            </div>
            <div class="main4_bottom3">
               <img src="/Public/website/Home/index/images/46.png">
               <h1>科目二</h1>
               
                 <a href="">小路考试</a>
                 <a href="">考试内容</a>
                 <a href="">考试标准</a>
                 <a href="">考试技巧</a>
               
            </div>
            <div class="main4_bottom4">
               <img src="/Public/website/Home/index/images/48.png">
               <h1>科目三</h1>
               
                 <a href="">大路考试</a>
                 <a href="">考试内容</a>
                 <a href="">考试标准</a>
                 <a href="">考试技巧</a>
               
            </div>
            <div class="main4_bottom5">
               <img src="/Public/website/Home/index/images/50.png">
               <h1>科目四</h1>
               
                 <a href="">理论考试</a>
                 <a href="">考试内容</a>
                 <a href="">考试标准</a>
                 <a href="">考试技巧</a>
               
            </div>
            <div class="main4_bottom6">
               <img src="/Public/website/Home/index/images/52.png">
               <h1>拿本</h1>
               
                 <a href="">新手上路</a>
                 <a href="">新手必知</a>
                 <a href="">上路技巧</a>
                 <a href="">开车秘籍</a>
               
            </div>
            <div class="clearfix"></div>
            
         </div>

      </div>
   
   </div>
   
   
   <div class="main_box5">
      <div class="main5">
      
         <div class="main5_top">
            <h1>学车保障</h1>
            <div class="main5_top5">
               <img src="/Public/website/Home/index/images/27.png">
               <h2>放心学车，省心考试，尽心服务</h2>
               <img src="/Public/website/Home/index/images/27.png">
               <div class="clearfix"></div>
            </div>
         </div>
         
         <div class="main5_bottom">
            <div class="main5_bottom1">
               <img src="/Public/website/Home/index/images/61.png">
               <h1>精选优惠</h1>
            </div>
            <div class="main5_bottom2">
               <img src="/Public/website/Home/index/images/64.png">
               <h1>安全省心</h1>
            </div>
            <div class="main5_bottom3">
               <img src="/Public/website/Home/index/images/66.png">
               <h1>服务保障</h1>
            </div>
            
            <div class="clearfix"></div>
            
         </div>

      </div>
   
   </div>


</div>


<div class="foot_box">
   <div class="foot">
      <div class="foot1">
         <div class="foot1_left">
            <div class="foot1_left1">
               <h1>加入我们</h1>
               <a href="">加入我们</a>
               <a href="">商务合作</a>
               <a href="">服务条款</a>
               <a href="">招聘公告</a>
            </div>
            <div class="foot1_left1">
               <h1>关于我们</h1>
               <a href="">APP下载</a>
               <a href="">平台优势</a>
               <a href="">意见反馈</a>
               <a href="">隐私声明</a>
            </div>
            <div class="foot1_left1">
               <h1>帮助中心</h1>
               <a href="">注册认证</a>
               <a href="">新手引导</a>
               <a href="">常见问题</a>
               <a href="">517福利</a>
            </div>
            <div class="foot1_left1">
               <h1>友情链接</h1>
               <a href="">旧版官网</a>
               <a href="">手机版官网</a>
               <a href="">交管所官网</a>
               <a href="">学成网</a>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="foot1_right">
            <div class="foot1_right1">
               <h1>全国客服热线</h1>
               <h2>400-8040-517</h2>
               <h3>工作日 &nbsp;9:00-21:00</h3>
               <h4>节假日 &nbsp;9:00-21:00</h4>
            </div>
            <div class="clearfix"></div>
         </div>
         <div class="clearfix"></div>
      </div>
      <div class="clearfix"></div>
      <div class="foot2">
         <h1>热门驾校</h1>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
         <a href="">广源驾校</a>
      </div>
      
      <div class="foot3">
         <img src="/Public/website/Home/index/images/76.png">
         <p>Copyright © 2013 517xueche, All Rights Reserved. 上海吾要去信息科技有限公司 | 沪ICP备13030092号</p>
      </div>
   </div>
</div>



<div id="apply_box">
   <div class="apply">
      <div class="apply_img">
         <img src="/Public/website/Home/index/images/fix_31.png">
      </div>
      <div class="apply_text">
         <img src="/Public/website/Home/index/images/fix02_34.png">
      </div>
      <div class="apply_QRcode1">
         <img src="/Public/website/Home/index/images/QRcode.png">
         <p>扫码下载我要去学车客户端</p>
      </div>
      <div class="apply_QRcode2">
         <img src="/Public/website/Home/index/images/QRcode.png">
         <p>扫码关注我要去学车微信公众号</p>
      </div>
      <div id="apply_close">
         <input name="button" type="image" value="" src="/Public/website/Home/index/images/fix03_34.png" />
      </div>
      <div class="clearfix"></div>
   </div>
</div>


<div class="fix_box">
   <div class="fix1">
       <div class="fix1_box">
           <img src="/Public/website/Home/index/images/fix202_11.png">
           <!--<a href="">在线客服</a>-->
           <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1967176003&site=qq&menu=yes">
               在线客服
           </a>
       </div>
      <div class="fix1_box">
         <img src="/Public/website/Home/index/images/fix201_14.png">
         <a href="">马上报名</a>
      </div>
      <div class="fix1_box">
         <img src="/Public/website/Home/index/images/fix201_14.png">
         <a href="">拨打热线</a>
      </div>
   </div>
   <h1>400-8040-517</h1>
   <div class="fix2">
      <img src="/Public/website/Home/index/images/fix2_17.png">
   </div>
    <div class="fix_box2">
        <img id="pack" src="/Public/website/Home/index/images/packUp.png">
    </div>
</div>
</body>
</html>
<script>
    function G(id) {
        return document.getElementById(id);
    }

    var map = new BMap.Map("l-map");
    var city=$("#citySelect").val();
    map.centerAndZoom(city,11);                   // 初始化地图,设置城市和地图级别。

    var localSearch = new BMap.LocalSearch(map);
    localSearch.enableAutoViewport(); //允许自动调节窗体大小
    var keyword = document.getElementById("search").value;
    localSearch.setSearchCompleteCallback(function (searchResult) {
        var poi = searchResult.getPoi(0);
        document.getElementById("lng").value = poi.point.lng;  //获取经度和纬度，将结果显示在文本框中
        document.getElementById("lat").value = poi.point.lat; //获取经度和纬度，将结果显示在文本框中
        map.centerAndZoom(poi.point, 13);
    });
    localSearch.search(keyword);

    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
            {"input" : "search"
                ,"location" : map
            });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
        var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

        setPlace();
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
            onSearchComplete: myFun
        });
        local.search(myValue);
    }
</script>