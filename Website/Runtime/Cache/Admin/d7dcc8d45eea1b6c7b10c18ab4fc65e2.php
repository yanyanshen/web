<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>驾校编辑</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
        <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
        <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
        <script type="text/javascript" src="/Public/public/js/layer/layer.js"></script>
        <script type="text/javascript" src="/Public/public/kindeditor/kindeditor-all.js"></script>
        <style>
            .table_a  td{text-align: left}
            .table_a  input{font-size: 12px}
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
            $("#jx_editor").click(function(){
                $('#jx_editor').attr('disabled',true);
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
        驾校编辑
        <a style="text-decoration: none;font-weight: bold;color: #FA7124" href="<?php echo U('jx_list',array('pid'=>$get['pid'],'p'=>$get['p']));?>">【返回】</a>
    </div>
    <div style="margin: 10px 5px">
            <form action="<?php echo U('Admin/School/jx_editor');?>" method="post" enctype="multipart/form-data" id="form1">
                <input type="hidden" name='id' value="<?php echo ($id); ?>"/>
                <input type="hidden" name='pid' value="<?php echo ($get['pid']); ?>"/>
                <input type="hidden" name='p' value="<?php echo ($get['p']); ?>"/>
                <table  width="100%" class="table_a">
                <tr>
                    <td style="color: #323232" width="7%">驾校账号</td>
                    <td><input type="text" name="account" value="<?php echo ($jx["account"]); ?>" /></td>
                </tr>
                <tr>
                    <td>所在城市</td>
                    <td>
                        <select name="cityid" onchange="change(this)" style="width: 70px;height: 20px;font-size: 11px">
                            <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($jx['cityid']==$v['id']?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>驾校简称</td>
                    <td><input type="text" name="nickname" value="<?php echo ($jx["nickname"]); ?>" /></td>
                </tr>
                <tr>
                    <td>驾校全称</td>
                    <td><input type="text" name="fullname" id="keyword" value="<?php echo ($jx["fullname"]); ?>" style="width:300px"/></td>
                </tr>
                <tr>
                    <td>地址</td>
                    <td>
                        <input type="text" name="address"  value="<?php echo ($jx['address']); ?>"/>
                    </td>
                </tr>
                <tr>
                    <td>驾校电话</td>
                    <td><input type="text" name="phone" value="<?php echo ($jx['phone']); ?>" /></td>
                </tr>
                    <tr>
                        <td>最低价格</td>
                        <td><input type="text" name="minprice"  value="<?php echo ($jx["minprice"]); ?>"/></td>
                    </tr>
                    <tr>
                        <td>原价</td>
                        <td><input type="text" name="highprice"  value="<?php echo ($jx["highprice"]); ?>"/></td>
                    </tr>
                    <tr>
                        <td>驾照类型</td>
                        <td><input type="text" name="jtype" style="font-size: 10px;width: 170px" value="<?php echo ($jx["jtype"]); ?>"/>（多个可用英文逗号隔开）</td>
                    </tr>
                 <tr>
                    <td>优先级</td>
                    <td><input type="text" name="order" value="<?php echo ($jx["order"]); ?>"/>(数字，优先级越大排名越靠前)</td>
                </tr>
                <tr>
                    <td>驾校logo</td>
                    <td>
                        <div class="usercity" style="border:3px dashed #e6e6e6;width:210px;height:200px;position: relative;margin-bottom: 15px">
                            <p id="preview1" >
                                <?php if($jl['picname'] != ''): ?><img id="imghead1"  border=0 src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($jl['picurl']); echo ($jl['picname']); ?>" width="150" height="120">
                                    <?php else: ?>
                                    <img id="imghead1"  border=0 src="<?php echo ($http); ?>/Uploads/default_logo/517.png" width="150" height="120"><?php endif; ?>
                            </p>
                            <span></span>
                            <input type="file" id="image1" name="image" onchange="previewImage(this,'preview1','imghead1')" style="display:none;" >
                            <label for="image1"  style="margin:50px 20px;color:#fff;text-align:center;border-radius:4px;width:110px;height:26px;line-height:26px;font-size:14px;background: rgb(19, 181, 177);padding:6px 10px;cursor:pointer;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);">点击选择主图</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>计时培训</td>
                    <td>
                        <label><input type="radio"  name='timing' value=1 <?php echo ($jx['timing']==1?'checked':''); ?> />支持</label>　
                        <label><input type="radio" name='timing' value=0 <?php echo ($jx['timing']==0?'checked':''); ?>/>不支持</label>
                    </td>
                </tr>
                <tr>
                    <td>评分</td>
                    <td><input type="text" name="score" value="<?php echo ($jx['score']); ?>" /></td>
                </tr>
                 <tr>
                    <td>评论数</td>
                    <td><input type="text" name="evalutioncount" value="<?php echo ($jx['evalutioncount']); ?>" /></td>
                </tr>
                 <tr>
                    <td>总学员数</td>
                    <td><input type="text" name="allcount" value="<?php echo ($jx['allcount']); ?>" /></td>
                </tr>
                 <tr>
                    <td>已通过人数</td>
                    <td><input type="text" name="passedcount" value="<?php echo ($jx['passedcount']); ?>" /></td>
                </tr>
                <tr>
                    <td>联系人/联系方式</td>
                    <td><input type="text" name="connectteacher" value="<?php echo ($jx['connectteacher']); ?>"/>（姓名 空格 手机号）</td>
                </tr>
                 <tr>
                    <td>驾校简介</td>
                     <td>
                         <textarea name="introduction" id="content7"  style="padding-left:70px;height:250px;visibility:hidden;">
                         <?php echo ($jx['introduction']); ?>
                        </textarea>
                     </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="button" id="jx_editor" value="保存更新">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</body>
</html>
<script>
    function previewImage(file,pre,imag) {
        var MAXWIDTH  = 200;
        var MAXHEIGHT = 150;
        var div = document.getElementById(pre);
        if( !file.value.match( /.jpg|.gif|.png|.bmp/i ) ){
//$(this).prev('span').text('图片格式无效！');
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