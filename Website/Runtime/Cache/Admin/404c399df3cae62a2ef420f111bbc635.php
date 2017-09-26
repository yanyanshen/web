<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>地标管理</title>
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
        <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
        <script>
	        $("document").ready(function(){
				$("#button").click(function(){
		 			$.ajax({
		 				url:"<?php echo U('addnewland');?>",
		 			    type:"POST",
		 		        data:$('#form').serialize(),
		 		        success: function(res) {
		 		          if(res.info){
                              alert('添加成功');
		 		        	 window.location.reload();
		 		          }else{
		 		        	  alert("添加失败");
		 		          }
		 		        }
		 			},'json');
		 		});
	        });
	     </script>
    </head>
    <body>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：系统管理-》地标管理</span>
            </span>
        </div>
        <div class="div_search" style="height: 60px;">
            <span style="float:left;margin-top: 30px">
                <form action="<?php echo U('');?>" method="post">
                    城市<select name="cityid" id="city">
                            <?php if(is_array($citys)): $i = 0; $__LIST__ = $citys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($cityid==$v['id']?'selected':''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    区/县<select name="countyid" id="county" onchange="change_val(this)">
                            <?php if(is_array($countys)): $i = 0; $__LIST__ = $countys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($countyid==$v['id']?'selected':''); ?>><?php echo ($v["countyname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    <input value="查询" type="submit" value="查询"/>
                </form>
            </span>
            <span style="float:right;padding-right:10px;">
            	<form id="form">
            	    <input type="hidden" name="cityid" id="cityname" value="<?php echo ($cityid); ?>"/>
            	    <input type="hidden" name="countyid" id="countyname" value="<?php echo ($countyid); ?>"/>
                    城市:<input type="text" disabled  class="cityname" value="<?php echo ($cityname); ?>" style="width: 60px"/>
                    区/省:<input type="text" disabled  class="countyname" value="<?php echo ($countyname); ?>" style="width: 60px"/>
                    <br>
            	    输入地标名：<input type="text" name="landname" id="landname" placeholder="请输入该地区的地标名" />
                    <input type="button" value="查询" onclick="searchByStationName();"/>
            	    经度：<input type="text" name="longitude" id="longitude" />
                    纬度<input type="text" name="latitude" id="latitude"/>
            	    <input type="button" value="添加" id="button" onclick="checkNull()"/>
            	　　　　　　总计：<?php echo ($count); ?>
            	</form>
            </span>
        </div>
        <div id="left" style="font-size: 13px;width:30%;float:left;">
            <table class="table_a" border="1" >
                <tbody><tr style="font-weight: bold;">
                        <th width="3%">序号</th>
                        <th width="5%">基地</th>
                         <th width="5%">经度</th>
                        <th width="5%">纬度</th>
                        <th width="1%">操作</th>
                    </tr>
                    <?php if(is_array($land)): $i = 0; $__LIST__ = $land;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><tr>
                    	<td><?php echo ($v["id"]); ?></td>
                    	<td><?php echo ($v["landname"]); ?></td>
                    	<td><?php echo ($v["longitude"]); ?></td>
                    	<td><?php echo ($v["latitude"]); ?></td>
                        <td>
                        	<a href="<?php echo U('del_land?id='.$v['id']);?>" onclick="if(confirm('确定删除?')==false)return false;">删除</a>
                        </td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
        </div>
        <div id="container" style="width:65%;height:700px;float:right;border: 1px solid gray;overflow:hidden;"></div>
    </body>
    <script>

        $("#city").change(function(){
            $("#cityname").val($("#city option:selected").val());
            $(".cityname").val($("#city option:selected").text());
            $.post("<?php echo U('returncounty');?>", {cityid:$("#city option:selected").val()}, function(data,status){
                    $("#county").html("");
                    for(i=0;i<data.info.length;i++){
                        $("#countyname").val(data.info[0].id);
                        $(".countyname").val(data.info[0].countyname);
                        $("#county").append("<option value="+data.info[i].id+">"+data.info[i].countyname+"</option>");//在后面追加
                    }
                });
        });
        var change_val = function(sel){
                    var countyname=sel.value;
                    $("#countyname").val(countyname);
                    $(".countyname").val($("#county option:selected").text())
                };

        var checkNull  =  function () {
            if($("#landname").val()==''){
                alert('地标名不能为空');
                return false;
            }
        };

        var city=$("#city option:selected").text();
     var map = new BMap.Map("container");
    map.centerAndZoom(city, 12);
    map.enableScrollWheelZoom(true);    //启用滚轮放大缩小，默认禁用
    map.enableContinuousZoom();    //启用地图惯性拖拽，默认禁用
    map.addControl(new BMap.NavigationControl());  //添加默认缩放平移控件
    map.addControl(new BMap.OverviewMapControl()); //添加默认缩略地图控件
    map.addControl(new BMap.OverviewMapControl({ isOpen: true, anchor: BMAP_ANCHOR_BOTTOM_RIGHT }));   //右下角，打开
    var localSearch = new BMap.LocalSearch(map);
    localSearch.enableAutoViewport(); //允许自动调节窗体大小
    function searchByStationName() {
        map.clearOverlays();//清空原来的标注
        var keyword =$("#city option:selected").text()+document.getElementById("landname").value;
        localSearch.setSearchCompleteCallback(function (searchResult) {
            var poi = searchResult.getPoi(0);
            document.getElementById("longitude").value = poi.point.lng;
            document.getElementById("latitude").value =poi.point.lat;
            map.centerAndZoom(poi.point, 12);
            var marker = new BMap.Marker(new BMap.Point(poi.point.lng, poi.point.lat));  // 创建标注，为要查询的地方对应的经纬度
            map.addOverlay(marker);
            marker.enableDragging();//目标拖拽

            //标注拖拽后的位置
            marker.addEventListener("dragend", function (e) {
                document.getElementById("longitude").value = e.point.lng;
                document.getElementById("latitude").value = e.point.lat;
            });
            //点击的位置
            map.addEventListener("click", function (e) {
                //alert("当前位置：" + e.point.lng + ", " + e.point.lat);
                var pointClick=  new BMap.Point(e.point.lng , e.point.lat);
                map.openInfoWindow(infoWindow, pointClick);
            });

            var content = document.getElementById("landname").value + "<br/><br/>经度：" + poi.point.lng + "<br/>纬度：" + poi.point.lat;
            var infoWindow = new BMap.InfoWindow("<p style='font-size:14px;'>" + content + "</p>");
            marker.addEventListener("click", function () { this.openInfoWindow(infoWindow); });
             marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
    });
    localSearch.search(keyword);
}


    </script>
</html>