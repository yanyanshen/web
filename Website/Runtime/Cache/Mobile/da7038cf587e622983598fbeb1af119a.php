<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>章节练习</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta content="telephone=no" name="format-detection">
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no">

    <!--标准mui.css-->
    <link rel="stylesheet" href="/Public/website/Mobile/chapter_practice/css/mui.min.css">
    <link href="/Public/website/Mobile/theory_study/css/initialize.css" rel="stylesheet" type="text/css">
    <link href="/Public/website/Mobile/theory_study/css/theory_study.css" rel="stylesheet" type="text/css">
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer_mobile/layer.js"></script>
    <style>
        .options li{
            cursor: pointer;border-bottom: 1px solid #eee;
        }
    </style>
    <script>
        //获取浏览器页面可见高度和宽度
        var _PageHeight = document.documentElement.clientHeight,
                _PageWidth = document.documentElement.clientWidth;
        //计算loading框距离顶部和左部的距离（loading框的宽度�?15px，高度为61px
        var _LoadingTop = _PageHeight > 61 ? (_PageHeight - 61) / 2 : 0,
                _LoadingLeft = _PageWidth > 215 ? (_PageWidth - 215) / 2 : 0;
        //在页面未加载完毕之前显示的loading Html自定义内�?
        var _LoadingHtml = '<div id="loadingDiv" style="position:absolute;left:0;width:100%;height:'
                + _PageHeight + 'px;top:0;background:#f3f8ff;opacity:0.8;filter:alpha(opacity=80);z-index:10000;">' +
                '<div style="position: absolute; cursor1: wait; left: ' + _LoadingLeft + 'px; top:'
                + _LoadingTop + 'px; width: auto; height: 57px; line-height: 57px; padding-left: 50px; padding-right: 30px;font-size:14px; background: #fff url(/Uploads/smallpic/jz.gif) no-repeat scroll 5px 10px; border: 1px solid #757575;border-radius:5px; color: #696969; font-family:\'Microsoft YaHei\';">页面加载中，请稍等...</div></div>';
        //呈现loading效果
        document.write(_LoadingHtml);
        window.onload = function () {
            var loadingMask = document.getElementById('loadingDiv');
            loadingMask.parentNode.removeChild(loadingMask);
        };
    </script>
</head>
<body>
<div class="header_box">
    <div class="header">
        <ul>
            <li class="back" style="border: none">
                    <a href="<?php echo U('Mobile/Exam/chapter',array('mt'=>$Think.session('mt'),'ms'=>$ms,'mc'=>$mc));?>">
                        <img src="/Public/public/images/back.png">
                    </a>
            </li>
            <li class="header_text" style="border: none">
                <?php echo ($title); ?>
            </li>
            <div class="clearfix"></div>
        </ul>
    </div>
</div>
<div id="loadingDiv" class="mui-content" style="z-index: 0;margin-top: 10px">
      <div class="mui-slider">
        <div class="mui-slider-group "  style="margin-bottom: 50%;">
        
            <?php if(is_array($chapter)): $k = 0; $__LIST__ = $chapter;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$chap): $mod = ($k % 2 );++$k;?><div class="mui-slider-item" style="background-color: white">
                    <div class="title_<?php echo ($chap["id"]); ?>"  answer="<?php echo ($chap["answer"]); ?>">
                        <p style="font-size: 14px;width: 90%;margin-left: 2%"><?php echo ($k); ?>.<?php echo ($chap["question"]); ?>
                            <?php if($chap["ifmul"] == 0): ?>单选<?php endif; ?>
                            <?php if($chap["ifmul"] == 1): ?>多选<?php endif; ?>
                            <?php if($chap["ifmul"] == 2): ?>判断<?php endif; ?>
                            </p>
                    </div>
                    <div class="img" style="width: 50%" >
                        <?php if($chap["image"] != '0'): ?><img src="<?php echo ($http); ?>/Uploads<?php echo ($chap["image"]); ?>"><?php endif; ?>
                    </div>
                    <div class="options">
                        <?php if($chap["ifmul"] == 1): ?><form action="" id="form_<?php echo ($chap["id"]); ?>">
                                <input type="hidden" name="answer" value="<?php echo ($chap["answer"]); ?>"/>

                                <ul>
                                    <li class="select_A" gid="<?php echo ($chap["id"]); ?>" >
                                        <label>
                                            <input type="checkbox" class="mA_<?php echo ($chap["id"]); ?>" style="display: none" value="mA_<?php echo ($chap["id"]); ?>" name="ms[]"/>
                                            <img id="mA_<?php echo ($chap["id"]); ?>" style="width: 20px;height:20px;display: inline-block;position: absolute;"    src="/Public/website/Mobile/chapter_practice/images/abcd_01.png" alt=""/>
                                        </label>
                                        <span style="margin-left: 7%;font-size: 16px"><?php echo ($chap["s1"]); ?></span>

                                    </li>
                                    <li style="margin-top: 2%;"   class="select_B" gid="<?php echo ($chap["id"]); ?>" >
                                        <label>
                                            <input type="checkbox" class="mB_<?php echo ($chap["id"]); ?>" style="display: none"  value="mB_<?php echo ($chap["id"]); ?>" name="ms[]"/>
                                            <img id="mB_<?php echo ($chap["id"]); ?>" style="width: 20px;height:20px;display: inline-block;position: absolute;"   src="/Public/website/Mobile/chapter_practice/images/abcd_02.png" alt=""/>
                                        </label>
                                        <span style="margin-left: 7%;font-size: 15px"><?php echo ($chap["s2"]); ?></span>
                                    </li>
                                    <li  style="margin-top: 2%;"  class="select_C" gid="<?php echo ($chap["id"]); ?>">
                                        <label>
                                            <input type="checkbox" class="mC_<?php echo ($chap["id"]); ?>" style="display: none"  value="mC_<?php echo ($chap["id"]); ?>" name="ms[]"/>
                                            <img  id="mC_<?php echo ($chap["id"]); ?>"   style="width: 20px;height:20px;display: inline-block;position: absolute;"  src="/Public/website/Mobile/chapter_practice/images/abcd_03.png" alt=""/>
                                        </label>
                                        <span style="margin-left: 7%;font-size: 15px"><?php echo ($chap["s3"]); ?></span>
                                    </li>
                                    <li  style="margin-top: 2%;"  class="select_D"  gid="<?php echo ($chap["id"]); ?>" >
                                        <label>
                                            <input type="checkbox" class="mD_<?php echo ($chap["id"]); ?>" style="display: none"  value="mD_<?php echo ($chap["id"]); ?>" name="ms[]"/>
                                            <img id="mD_<?php echo ($chap["id"]); ?>" style="width: 20px;height:20px;display: inline-block;position: absolute;"  src="/Public/website/Mobile/chapter_practice/images/abcd_04.png" alt=""/>
                                            <span style="margin-left: 7%;font-size: 15px"><?php echo ($chap["s4"]); ?></span>
                                        </label>
                                    </li>
                                    <div id="button_<?php echo ($chap["id"]); ?>" style="float: right;margin-top: 2%">
                                        <input type="button" class="button" gid="<?php echo ($chap["id"]); ?>" value="提交" style=""/>
                                    </div>
                                    <div id="analysism_<?php echo ($chap["id"]); ?>" style="width: 90%;margin-top:8%;display: none">
                                        <label style="font-size: 14px">答案 <span style="color: red"><?php echo ($chap["answer"]); ?></span></label>
                                        <p>
                                            <?php echo ($chap["analysis"]); ?>
                                        </p>
                                    </div>
                                </ul>
                            </form>
                            <?php else: ?>
                            <ul>
                                <li class="select_A" gid="<?php echo ($chap["id"]); ?>" style="cursor: pointer;border-bottom: 1px solid #eee" >
                                    <label>
                                        <img id="sA_<?php echo ($chap["id"]); ?>" style="width: 20px;height:20px;display: inline-block;vertical-align: middle;"    src="/Public/website/Mobile/chapter_practice/images/abcd_01.png" alt=""/>
                                        <?php echo ($chap["s1"]); ?>
                                    </label>
                                </li>
                                <li   class="select_B" gid="<?php echo ($chap["id"]); ?>" style="cursor: pointer">
                                    <label>
                                        <img id="sB_<?php echo ($chap["id"]); ?>" style="width: 20px;height:20px;display: inline-block;vertical-align: middle;"   src="/Public/website/Mobile/chapter_practice/images/abcd_02.png" alt=""/>
                                        <?php echo ($chap["s2"]); ?>
                                    </label>
                                </li>
                                <?php if($chap["ifmul"] == 0): ?><li  class="select_C" gid="<?php echo ($chap["id"]); ?>" style="cursor: pointer">
                                        <label>
                                            <img  id="sC_<?php echo ($chap["id"]); ?>"   style="width: 20px;height:20px;display: inline-block;vertical-align: middle;"  src="/Public/website/Mobile/chapter_practice/images/abcd_03.png" alt=""/>
                                            <?php echo ($chap["s3"]); ?>
                                        </label>
                                    </li>
                                    <li class="select_D"  gid="<?php echo ($chap["id"]); ?>" >
                                        <label>
                                            <img id="sD_<?php echo ($chap["id"]); ?>" style="width: 20px;height:20px;display: inline-block;vertical-align: middle;"  src="/Public/website/Mobile/chapter_practice/images/abcd_04.png" alt=""/>
                                            <?php echo ($chap["s4"]); ?>
                                        </label>
                                    </li><?php endif; ?>
                            </ul>
                            <div id="analysis_<?php echo ($chap["id"]); ?>" style="width: 90%;margin-top:8%;display: none">
                                <label style="font-size: 14px">答案 <span style="color: red"><?php echo ($chap["answer"]); ?></span></label>
                                <p>
                                    <?php echo ($chap["analysis"]); ?>
                                </p>
                            </div><?php endif; ?>
                    </div>
                </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </div>
          <footer id="foot_theoryStudy" style="z-index: 1000;margin-bottom: 0;">
              <ul  class="mui-slider-indicator" >
                  <li class="foot_option">
                      <?php if($mc == 1): ?><button class="button2">
                              <img src="/Public/website/Mobile/theory_study/images/collection.png">
                              <p>取消收藏</p>
                          </button>
                          <?php else: ?>
                          <button class="button1">
                              <img src="/Public/website/Mobile/theory_study/images/collection.png">
                              <p>收藏</p>
                          </button><?php endif; ?>

                  </li>
                  <li class="foot_option">
                      <button class="button3">
                          <img src="/Public/website/Mobile/theory_study/images/collection.png">
                          <p>解析</p>
                      </button>
                  </li>
                  <li class=" foot_option">
                      <button>
                          <img src="/Public/website/Mobile/theory_study/images/plan.png">
                          <div  style="line-height:  5px" class="mui-number">
                              <span class="k">1</span> / <?php echo ($count); ?>
                          </div>
                      </button>
                  </li>
              </ul>
          </footer>
    </div>
</div>
</body>
<script src="/Public/website/Mobile/chapter_practice/js/mui.min.js"></script>
<script>

    $(".select_A").click(function(){
        var id=$(this).attr('gid');
        var analysis = '#analysis_'+ id;
        $(analysis).show();
        var title='.title_'+id;
        var answer=$(title).attr('answer');
        idName='s'+answer+'_'+$(this).attr('gid');
        if(answer.length==1){
            if(answer=='A'){
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='B'){
                $('#sA_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='C'){
                $('#sA_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='D'){
                $('#sA_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }

            $.post('<?php echo U("Mobile/Exam/one_judge");?>',{id:id,user_answer:'A'},function(res){
            },'json');
        }else{
            var checkbox = $('.mA_'+id);
            if(checkbox.data('waschecked')==true){
                checkbox.prop('checked',false);
                checkbox.data('waschecked',false);
                $('#mA_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_01.png')
            }
            else{
                checkbox.prop('checked',true);
                checkbox.data('waschecked',true);
                $('#mA_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_05.png')
            }
        }
    });

    $(".select_B").click(function(){
        var id=$(this).attr('gid');
        var analysis = '#analysis_'+ id;
        $(analysis).show();
        var title='.title_'+id;
        var answer=$(title).attr('answer');
        idName='s'+answer+'_'+$(this).attr('gid');
        if(answer.length==1){
            if(answer=='B'){
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='A'){
                $('#sB_'+id).attr("src",'/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='C'){
                $('#sB_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='D'){
                $('#sB_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }
        }else{
            var checkbox = $('.mB_'+id);
            if(checkbox.data('waschecked')==true){
                checkbox.prop('checked',false);
                checkbox.data('waschecked',false);
                $('#mB_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_02.png')
            }else{
                checkbox.prop('checked',true);
                checkbox.data('waschecked',true);
                $('#mB_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_05.png')
            }
        }

        $.post('<?php echo U("Mobile/Exam/one_judge");?>',{id:id,user_answer:'B'},function(res){
        },'json');

    });

    $(".select_C").click(function(){
        var id=$(this).attr('gid');
        var analysis = '#analysis_'+ id;
        $(analysis).show();
        var title='.title_'+id;
        var answer=$(title).attr('answer');
        idName='s'+answer+'_'+$(this).attr('gid');
        if(answer.length == 1){
            if(answer=='B'){
                $('#sC_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='A'){
                $('#sC_'+id).attr("src",'/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='C'){
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='D'){
                $('#sC_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }
        }else{
            var checkbox = $('.mC_'+id);
            if(checkbox.data('waschecked')==true){
                checkbox.prop('checked',false);
                checkbox.data('waschecked',false);
                $('#mC_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_03.png')
            }else{
                checkbox.prop('checked',true);
                checkbox.data('waschecked',true);
                $('#mC_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_05.png')
            }
        }

        $.post('<?php echo U("Mobile/Exam/one_judge");?>',{id:id,user_answer:'C'},function(res){
        },'json');


    });

    $(".select_D").click(function(){
        var id=$(this).attr('gid');
        var analysis = '#analysis_'+ id;
        $(analysis).show();
        var title='.title_'+id;
        var answer=$(title).attr('answer');
        idName='s'+answer+'_'+$(this).attr('gid');
        if(answer.length == 1){
            if(answer=='B'){
                $('#sD_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='A'){
                $('#sD_'+id).attr("src",'/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='C'){
                $('#sD_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_07.png');
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }else if(answer=='D'){
                document.getElementById(idName).src='/Public/website/Mobile/chapter_practice/images/abcd_06.png';
            }
        }else{
            var checkbox = $('.mD_'+id);
            if(checkbox.data('waschecked')==true){
                checkbox.prop('checked',false);
                checkbox.data('waschecked',false);
                $('#mD_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_04.png')
            }else{
                checkbox.prop('checked',true);
                checkbox.data('waschecked',true);
                $('#mD_'+id).attr('src','/Public/website/Mobile/chapter_practice/images/abcd_05.png')
            }
        }

        $.post('<?php echo U("Mobile/Exam/one_judge");?>',{id:id,user_answer:'D'},function(res){
        },'json');

    });

    $('.button').click(function(){
        var id = $(this).attr('gid');
        $.post('<?php echo U("Mobile/Exam/judge");?>',$("#form_"+id).serialize(),function(res) {
            if(res.info=='请选择答案'){
                layer.open({
                    content: res.info
                    ,skin: 'msg'
                    ,icon:2
                    ,style: "background-color:#DAEAD3; font-color:white; border:none;" //自定风格
                    ,time: 2 //2秒后自动关闭
                });
            }else if(res.info=='回答错误'){
                layer.open({
                    content:res.info
                    ,skin:'msg'
                    ,icon:3
                    ,style:"background-color:#DAEAD3;border:none"
                    ,time:2
                });
                $("#analysism_"+id).show();
            }else if(res.info=='回答正确'){
                layer.open({
                    content:res.info
                    ,skin:'msg'
                    ,icon:2
                    ,style:"background-color:#DAEAD3;border:none"
                    ,time:2
                });
                $("#analysism_"+id).show();
            }
        },'json')
    });
/*沈艳艳 收藏*/
    $(".button1").click(function(){
        var k=$(".k").text();
        $.post('<?php echo U("Mobile/Exam/chapter_practice");?>',{k:k},function(res){
            layer.open({
                content:res.info
                ,skin:'msg'
                ,icon:3
                ,style:"background-color:#DAEAD3;border:none"
                ,time:2
            })
        },'json');
    });

    /*沈艳艳取消收藏*/
    $(".button2").click(function(){
        var k=$(".k").text();
        $.post('<?php echo U("Mobile/Exam/chapter_practice");?>',{k:k,cancel:1},function(res){
            layer.open({
                content:res.info
                ,skin:'msg'
                ,icon:3
                ,style:"background-color:#DAEAD3;border:none"
                ,time:2
            })
        },'json');
    });

    /*沈艳艳试题分析*/
    $(".button3").click(function(){
        var k=$(".k").text();
        $.post('<?php echo U("Mobile/Exam/chapter_practice");?>',{k:k,analysis:1},function(res){
            var id = res.info;
            if(res.url == 1){
                var analysis = "#analysism_"+id;
            }else{
                var analysis = "#analysis_"+id;
            }
            $(analysis).toggle();
        },'json');
    });
    mui.init();

</script>
</html>