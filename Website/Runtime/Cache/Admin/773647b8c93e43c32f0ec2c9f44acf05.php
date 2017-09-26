<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <title>添加驾校</title>
        <meta http-equiv="content-type" content="text/html;charset=utf-8">
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="/Public/website/Admin/ment/js/webuploader/webuploader.css" />
        <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="/Public/public/js/jquery.form.js"></script>
        <script src="/Public/public/js/jquery.validate.js"></script>
        <script type="text/javascript" src="/Public/public/js/webuploader/webuploader.js"></script>
        <script type="text/javascript" src="/Public/public/js/upload.js"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=mbF3FSfdd6Kyprj0xUlrk40RB0F5tpj2"></script>

        <style type="text/css">
            input{  margin-bottom: 8px;  }
            span.error{  font-size: 14px;  font-weight: bold;  color: #FF0000;  }
            span.ok{  font-size: 14px;  font-weight: bold;  color: #38D63B;  }
            #changePwd{  cursor: pointer;  }
        </style>
    </head>
        <script language="javascript">
        $(function(){
            var validate=$('#form1').validate({
                rules:{
                    account:{required:true},
                    pass:{required:true, rangelength:[5,32]},
                    nickname:{required:true},
                    fullname:{required:true},
                    address:{required:true}
                },
                messages:{
                    account:{required:'驾校账号不能为空！'},
                    pass:{required:'密码不能为空！', rangelength:'密码长度必须在5到12位之间！'},
                    nickname:{required:'简称不能为空!'},
                    fullname: {required: '全称不能为空'},
                    address:{required:'地址不能为空'}
                },
                success:function(span){
                    span.addClass('ok').text('通过验证')
                },
                validClass:'ok',
                errorElement:'span'
            });




            $("#add_jx").click(function(){
                    if(validate.form()){
                        $("#add_jx").attr('disabled',true);
                        $('#form1').ajaxSubmit(function(res){
                                if(res.status==1){
                                    $('.uploadBtn').click();
                                    setTimeout(function() {
                                        alert('编辑成功');
                                        location.href="<?php echo U('Admin/School/jx_list');?>";
                                    },3000);
                                }else{
                                    alert('驾校名称已存在,请重新编辑');
                                    location.href="<?php echo U('Admin/School/add_jx');?>";
                                }
                            },'json');
                            return false;
                        }

            });
        });


    </script>
    <body>

        <div class="div_head">
            <span>
                <span style="float:left">当前位置是：驾校管理-》添加驾校</span>
                <span style="float:right;margin-right: 8px;font-weight: bold">
                    <a style="text-decoration: none" href="<?php echo U('jx_list?p='.$p);?>">【返回】</a>
                </span>
            </span>
        </div>
        <div></div>

        <div style="font-size: 13px;margin: 10px 5px">
            <form action="<?php echo U('Admin/School/add_jx');?>" method="post" enctype="multipart/form-data" id="form1">
                <input type="hidden" name="type" value="<?php echo ($type); ?>"/>
            <table border="1" width="100%" class="table_a">
                <tr>
                    <td width="7%">驾校账号</td>
                    <td><input type="text" name="account" /><span style="color:red;"><?php echo ((isset($errorInfo["account"]) && ($errorInfo["account"] !== ""))?($errorInfo["account"]):""); ?></span></td>
                </tr>
		        <tr>
                    <td>登录密码</td>
                    <td><input type="text" name="pass" value="244ac348537069c3bfe9d633349b7334" style="width:500px" /><span style="color:red;"><?php echo ((isset($errorInfo["pass"]) && ($errorInfo["pass"] !== ""))?($errorInfo["pass"]):""); ?>(默认为517xueche)</span></td>
                </tr>

                <tr>
                    <td>所在城市</td>
                    <td>
                        <select name="cityid"  onchange="change(this)">
                            <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["cityname"]); ?>"><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </td>
                </tr>

                <tr>
                    <td>驾校简称</td>
                    <td><input type="text" name="nickname" /><span style="color:red;"><?php echo ((isset($errorInfo["nickname"]) && ($errorInfo["nickname"] !== ""))?($errorInfo["nickname"]):""); ?></span></td>
                </tr>
                <tr>
                    <td>驾校全称</td>
                    <td><input type="text" id="keyword" name="fullname" style="width:400px"/>
                        <span style="color:red;"><?php echo ((isset($errorInfo["fullname"]) && ($errorInfo["fullname"] !== ""))?($errorInfo["fullname"]):""); ?></span>
                    </td>
                </tr>
                <tr>
                    <td>地址</td>
                    <td>
                        <input type="text" name="address" value="" id="address"/>
                        <input type="button" value="定位" onclick="searchByStationName();" />
                    </td>
                    <div id="container"
                         style="position: absolute;
                            display:none;
                            width: 400px;
                            height: 300px;
                            top: 200px;
                            border: 1px solid gray;
                            overflow:hidden;">
                    </div>
                </tr>
                <tr>
                    <td>驾校电话</td>
                    <td><input type="text" name="phone" value="" /></td>
                </tr>

                <tr>
                    <td>优先级</td>
                    <td><input type="text" name="order" value="" />(数字，优先级越大排名越靠前)</td>
                </tr>
                 <tr>
                    <td>驾校logo</td>
                    <td>
                        <div class="usercity" style="border:3px dashed #e6e6e6;width:210px;height:200px;position: relative;margin-bottom: 15px">
                            <p id="preview1" ><img id="imghead1"  border=0 src=''></p><span></span>
                            <input type="file" id="image1" name="image" onchange="previewImage(this,'preview1','imghead1')" style="display:none;" >
                            <label for="image1"  style="margin:50px 20px;color:#fff;text-align:center;border-radius:4px;width:110px;height:26px;line-height:26px;font-size:14px;background:#00b7ee;padding:6px 10px;cursor:pointer;box-shadow: 0 1px 1px rgba(0, 0, 0, 0.1);">点击选择主图</label>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>驾校简介logo</td>
                    <td>
                        <label>驾校简介logo<b>*</b></label>
                        <div class="uploader-list-container vocation" style="width: 525px;border:0px;">
                            <div class="queueList">
                                <div id="dndArea" class="placeholder">
                                    <div id="filePicker-2"></div>
                                    <p>或将照片拖到这里，单次最多可选10张</p>
                                </div>
                            </div>
                            <div class="statusBar" style="display:none;">
                                <div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
                                <div class="info"></div>
                                <div class="btns">
                                    <div id="filePicker2"></div>
                                    <div class="uploadBtn" style="display: none">开始上传</div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td>计时培训</td>
                    <td>
                        <label><input type="radio"  name='timing' value=1 />支持</label>　
                        <label><input type="radio" name='timing' value=0 />不支持</label>
                    </td>
                </tr>
                 <tr>
                    <td>签名</td>
                    <td><input type="text" name="signature"/></td>
                </tr>
                <tr>
                    <td>评分</td>
                    <td><input type="text" name="score"/><span style="color:red;"><?php echo ((isset($errorInfo["score"]) && ($errorInfo["score"] !== ""))?($errorInfo["score"]):""); ?></span></td>
                </tr>

                 <tr>
                    <td>评论数</td>
                    <td><input type="text" name="evalutioncount"  /><span style="color:red;"><?php echo ((isset($errorInfo["evalutioncount"]) && ($errorInfo["evalutioncount"] !== ""))?($errorInfo["evalutioncount"]):""); ?></span></td>
                </tr>
                 <tr>
                    <td>好评数</td>
                    <td><input type="text" name="praisecount" /><span style="color:red;"><?php echo ((isset($errorInfo["praisecount"]) && ($errorInfo["praisecount"] !== ""))?($errorInfo["praisecount"]):""); ?></span></td>
                </tr>
                 <tr>
                    <td>总学员数</td>
                    <td><input type="text" name="allcount"  /><span style="color:red;"><?php echo ((isset($errorInfo["allcount"]) && ($errorInfo["allcount"] !== ""))?($errorInfo["allcount"]):""); ?></span></td>
                </tr>
                 <tr>
                    <td>已通过人数</td>
                    <td><input type="text" name="passedcount" /><span style="color:red;"><?php echo ((isset($errorInfo["passedcount"]) && ($errorInfo["passedcount"] !== ""))?($errorInfo["passedcount"]):""); ?></span></td>
                </tr>
                <tr>
                    <td>联系人/联系方式</td>
                    <td><input type="text" name="connectteacher" />（姓名 空格 手机号）</td>
                </tr>

                 <tr>
                    <td>驾校简介</td>
                    <td><textarea name="introduction"  cols="80" rows="10"></textarea></td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                        <input type="submit" id="add_jx" value="确认编辑">
                    </td>
                </tr>  
            </table>
            </form>
        </div>
    </body>
</html>
<script>

    var uploadUrl = '<?php echo U("uploadMulPic");?>';
//    var listUrl = '<?php echo U("index");?>';
var map = new BMap.Map("container");
    var change = function(sel){
        var city=sel.value;
        var map = new BMap.Map("container");
        map.centerAndZoom(city, 12);
    };
var localSearch = new BMap.LocalSearch(map);
localSearch.enableAutoViewport(); //允许自动调节窗体大小
function searchByStationName() {
    var keyword = document.getElementById("keyword").value;
    localSearch.setSearchCompleteCallback(function (searchResult) {
        var poi = searchResult.getPoi(0);
        document.getElementById("address").value = poi.address;  //获取经度和纬度，将结果显示在文本框中
    });
    localSearch.search(keyword);
}

    function previewImage(file,pre,imag) {
        var MAXWIDTH  = 200;
        var MAXHEIGHT = 230;
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