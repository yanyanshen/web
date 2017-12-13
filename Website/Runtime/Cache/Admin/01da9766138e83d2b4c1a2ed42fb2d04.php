<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title>编辑教练</title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
    <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
    <script type="text/javascript" src="/Public/public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
    <script type="text/javascript" src="/Public/public/js/layer/layer.js"></script>
    <style>
        .table_a  td{text-align: left;}
        .table_a input{font-size: 12px}

        #searchresult{top:50px;left: 280px;position: absolute;z-index:5; overflow:hidden;border-top:none;}
        .line{font-size:12px; color: #ffffff; background:rgb(19, 181, 177); width:200px; padding:2px;height: 30px}
        .hover{ color:#323232;background-color: transparent;cursor: pointer}
    </style>
    <script>
        $(document).ready(function(e) {
            KindEditor.ready(function (K) {
                K.create('#content7', {
                    allowFileManager: true,
                    filterMode: true,
                    afterBlur: function () {  //利用该方法处理当富文本编辑框失焦之后，立即同步数据
                        this.sync("#content7");
                    }
                });
            });
        })
    </script>
</head>
<script>
    $(function(){
        $("#submit").click(function(){
            $(this).attr('disabled',true);
            $('#form1').ajaxSubmit(function(res){
                if(res.status){
                    layer.msg(res.info,{icon:6,time:2000},function(){
                        location.href=res.url;
                    });
                }else{
                    layer.msg(res.info,{icon:5,time:2000},function(){
                        location.href=res.url;
                    });
                }
            },'json');
            return false;
        });
    })
</script>
<body>
<div class="div_head">
    教练编辑
    <span>
        <a style="text-decoration: none;color: #fa7142" href="<?php echo ($url); ?>">【返回】</a>
        <a style="text-decoration: none;color: #fa7142" href="">【刷新】</a>
    </span>
</div>
<div style="font-size: 11px;margin: 10px 5px">
    <form action="<?php echo U('Admin/Coach/editor_jl');?>" method="post" id="form1" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo ($jl['id']); ?>" jl_id="<?php echo ($jl['id']); ?>" id="jl_id" pid="<?php echo ($get['pid']); ?>" p="<?php echo ($get['p']); ?>"/>
        <input type="hidden" name="pid" value="<?php echo ($get['pid']); ?>"/>
        <input type="hidden" name="type" value="<?php echo ($get['type']); ?>"/>
        <input type="hidden" name="p" value="<?php echo ($get['p']); ?>"/>
        <table width="100%" class="table_a">
            <tr style="color: #323232;">
                <td>所属驾校：</td>
                <td>
                    <input type="hidden" name="school_id" value="<?php echo ($jl["school_id"]); ?>" id="sid"/>
                    <input type="text" value="<?php echo ($school_nickname?$school_nickname:''); ?>"  name="school_nickname" id="search" placeholder="请输入驾校"/>
                    <span id="searchresult" class="td"></span>
                </td>
            </tr>
            <tr>
                <td width="6%x">教练账号：</td>
                <td>
                    <input type="text" name="account"  value="<?php echo ($jl['account']); ?>"/>
                </td>
            </tr>
            <tr>
                <td>教练姓名：</td>
                <td>
                    <input type="text" name="nickname" value="<?php echo ($jl['nickname']); ?>"/>
                </td>
            </tr>
            <tr>
                <td>性&nbsp;&nbsp;别：</td>
                <td>
                        <input type="radio"  name='sex' value=0  <?php echo ($jl['sex']==0?checked:''); ?> /> <label for="">男</label>
                        <input type="radio"   name='sex' value=1 <?php echo ($jl['sex']==1?checked:''); ?> /><label for="">女</label>
                        <input type="radio"   name='sex' value=2 <?php echo ($jl['sex']==2?checked:''); ?> /><label for="">保密</label>
                </td>
            </tr>
            <tr>
                <td>教练类型：</td>
                <td>
                    <select name="category_id" style="font-size: 12px;width: 80px;height: 20px">
                        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value='<?php echo ($v["id"]); ?>' <?php echo ($jl['id']==$v['id']?selected:''); ?> ><?php echo ($v["category_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>所在城市：</td>
                <td>
                    <select name="cityid" style="width:80px;font-size: 12px;height: 20px" id="cityid" onchange="change(this)">
                        <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id']==$jl['cityid']?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>所属教练：</td>
                <td>
                    <select name="boss_id" style="width:80px;font-size: 12px;height: 20px">
                        <?php if(is_array($boss)): $i = 0; $__LIST__ = $boss;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id']==$jl['boss_id']?selected:''); ?>><?php echo ($v["boss_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>身份证号：</td>
                <td><input type="text" name="numberId" value="<?php echo ($jl["numberid"]); ?>" /></td>
            </tr>
            <tr>
                <td>驾驶证号：</td>
                <td><input type="text" name="driverId" value="<?php echo ($jl["driverid"]); ?>" /></td>
            </tr>
            <tr>
                <td>车牌号：</td>
                <td><input type="text" name="carnumber" value="<?php echo ($jl["carnumber"]); ?>" /></td>
            </tr>
            <tr>
                <td>教练证号：</td>
                <td><input type="text" name="serialid" value="<?php echo ($jl["serialid"]); ?>" /></td>
            </tr>
            <tr>
                <td>年&nbsp;&nbsp;龄：</td>
                <td><input type="text" name="age" value="<?php echo ($jl["age"]); ?>"/></td>
            </tr>
            <tr>
                <td>驾&nbsp;&nbsp;龄：</td>
                <td><input type="text" name="driverage"  value="<?php echo ($jl["driverage"]); ?>"/></td>
            </tr>
            <tr>
                <td>教&nbsp;&nbsp;龄：</td>
                <td><input type="text" name="teachage" value="<?php echo ($jl["teachage"]); ?>"/></td>
            </tr>
            <tr>
                <td>联系电话：</td>
                <td><input type="text" name="phone" value="<?php echo ($jl["phone"]); ?>" /></td>
            </tr>
            <tr>
                <td>最低价格</td>
                <td><input type="text" name="minprice" value="<?php echo ($jl["minprice"]); ?>" /></td>
            </tr>
            <tr>
                <td>原价</td>
                <td><input type="text" name="highprice" value="<?php echo ($jl["highprice"]); ?>" /></td>
            </tr>
            <tr>
                <td>评论数：</td>
                <td><input type="text" name="evalutioncount" value="<?php echo ($jl["evalutioncount"]); ?>" /></td>
            </tr>
            <tr>
                <td>总学员数：</td>
                <td><input type="text" name="student_num"  value="<?php echo ($jl["student_num"]); ?>" /></td>
            </tr>
            <tr>
                <td>已通过人数：</td>
                <td><input type="text" name="passedcount" value="<?php echo ($jl["passedcount"]); ?>" /></td>
            </tr>
            <tr>
                <td>地&nbsp;&nbsp;址：</td>
                <td><input type="text" name="address" value="<?php echo ($jl["address"]); ?>" /></td>
            </tr>
            <tr>
                <td>计时培训：</td>
                <td>
                    <label><input type="radio"  name='timing' value=1 <?php echo ($jl['timing']==1?checked:''); ?> />支持</label>　
                    <label><input type="radio"   name='timing' value=0 <?php echo ($jl['timing']==0?checked:''); ?> />不支持</label>
                </td>
            </tr>
            <tr>
                <td>教练头像</td>
                <td>
                    <div class="usercity" style="border:3px dashed #e6e6e6;width:200px;height:200px;position: relative;margin-bottom: 15px">
                        <p id="preview1" >
                            <?php if($jl['picname'] != ''): ?><img id="imghead1"  border=0 src="<?php echo ($http); ?>/Uploads/Coach_logo/<?php echo ($jl['picurl']); echo ($jl['picname']); ?>" width="150" height="120">
                                <?php else: ?>
                                <img id="imghead1"  border=0 src="<?php echo ($http); ?>/Uploads/default_logo/517.png" width="150" height="120"><?php endif; ?>
                        </p>
                        <span></span>
                        <input type="file" id="image0" name="image" onchange="previewImage(this,'preview1','imghead1')" style="display:none;" >
                        <label for="image0"  style="margin:50px 20px;color:#fff;text-align:center;border-radius:4px;width:110px;height:26px;line-height:26px;font-size:14px;background:rgb(19, 181, 177);padding:6px 10px;cursor:pointer;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);">点击选择主图</label>
                    </div>
                </td>
            </tr>
            <tr>
                <td>教练简介：</td>
                <td>
                    <textarea name="introduction" id="content7"  style="padding-left:70px;height:250px;visibility:hidden;"><?php echo ($jl['introduction']); ?></textarea>
                </td>
            </tr>
            <tr>
                <td colspan="2" align="center">
                    <input type="submit" id="submit" value="保存更新">
                </td>
            </tr>
        </table>
    </form>
</div>
</body>
</html>
<script>
    $(document).ready(function(){
        $('#search').keyup(function(){
            var search_key = $('#search').val();
            $.post("<?php echo U('Admin/TrainClass/search_school');?>",{search_key:search_key},function(res){
                if(res.info) {
                    var layer;
                    layer = "<table>";     //创建一个table
                    for (var i in res.info) {
                        layer += "<tr><td class='line' onclick='line("+res.info[i]['id']+',"'+res.info[i]['nickname']+'"'+")'>" + res.info[i]['nickname'] + "</td></tr>";
                    }
                    layer += "</table>";
                    $('#searchresult').empty();  //先清空#searchresult下的所有子元素
                    $('#searchresult').append(layer);//将刚才创建的table插入到#searchresult内
                    $('.line').hover(function(){  //监听提示框的鼠标悬停事件
                        $(this).addClass("hover");
                    },function(){
                        $(this).removeClass("hover");
                    });
                }
            },'json');
        });
    });
    function line(id,nickname){
        $('#search').val(nickname);
        $("#sid").val(id);
        $('#searchresult').empty();
    }
</script>
<script>
    var change=function(sel){
        var city=sel.value;
        $("#cityid").val(city);
    };

    function previewImage(file,pre,imag) {
        var MAXWIDTH  = 200;
        var MAXHEIGHT = 150;
        var div = document.getElementById(pre);
        if( !file.value.match( /.jpg|.gif|.png|.bmp/i ) ){
            $('#'+pre).next('span').css({"color":"red","font-weight":"bold"}).text('图片类型无效！');
            return false;
        }else{
            $('#'+pre).next('span').css({"color":"green","font-weight":"bold"}).text('');
        }
        if (file.files && file.files[0])
        {
            div.innerHTML ='<img id='+imag+'>';
            var img = document.getElementById(imag);
            img.onload = function(){
                var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
                img.width  =  rect.width;
                img.height =  rect.height;
//                 img.style.marginLeft = rect.left+'px';
                img.style.marginTop = rect.top+'px';
            }
            var reader = new FileReader();
            reader.onload = function(evt){img.src = evt.target.result;}
            reader.readAsDataURL(file.files[0]);
        }
        else //兼容IE
        {
            var sFilter='filter:progid:DXImageTransform.Microsoft.AlphaImageLoader(sizingMethod=scale,src="';
            file.select();
            file.blur();
            var src = document.selection.createRange().text;
            div.innerHTML ='<img id='+imag+'>';
            var img = document.getElementById(imag);
            img.filters.item('DXImageTransform.Microsoft.AlphaImageLoader').src = src;
            var rect = clacImgZoomParam(MAXWIDTH, MAXHEIGHT, img.offsetWidth, img.offsetHeight);
            status =('rect:'+rect.top+','+rect.left+','+rect.width+','+rect.height);
        }

        $(file).next('label').css({margin:0,top:0,position:'absolute',background:'rgba(0,0,0,0.4)',color:'#fff',fontSize:'14px'}).html('重新选择主图');
    }
    function clacImgZoomParam( maxWidth, maxHeight, width, height ){
        var param = {top:0, left:0, width:width, height:height};
        if( width>maxWidth || height>maxHeight )
        {
            rateWidth = width / maxWidth;
            rateHeight = height / maxHeight;

            if( rateWidth > rateHeight )
            {
                param.width =  maxWidth;
                param.height = Math.round(height / rateWidth);
            }else
            {
                param.width = Math.round(width / rateHeight);
                param.height = maxHeight;
            }
        }

        param.left = Math.round((maxWidth - param.width) / 2);
        param.top = Math.round((maxHeight - param.height) / 2);
        return param;
    }
</script>