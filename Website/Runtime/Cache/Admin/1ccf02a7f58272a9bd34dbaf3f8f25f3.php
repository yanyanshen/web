<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>指导员列表</title>
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
        <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
        <script src="/Public/public/js/layer/layer.js"></script>
	     <script>
	     $("document").ready(function(){
	  		$("#b").click(function(){
				form=$("#form").serializeArray();
				url="?";
	 			for(i=0;i<form.length;i++){
					if(form[i].value!=''){
						url+=form[i].name+"="+form[i].value+"&";
					}
				}
				location.href =url;
	 		});
	     });
		</script>
    </head>
    <body>
        <div class="div_head">
           指导员列表
            <a style="text-decoration: none;color:#FA7124;" href="<?php echo U('add_zd',array('type'=>'zd','pid'=>$get['pid'],'p'=>$get['p']));?>">【指导员添加】</a>
            <a href="" style="color: #323232;text-decoration: none">【刷新】</a>
            <span class="span">总计：<?php echo ($count); ?></span>
        </div>
        <div class="div_search" >
            <span>
                <form id='form' action="?">
                        城市：<select name="cityid" style="font-size: 11px;width: 70px;height: 20px">
                        <option value="">请选择</option>
                        <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id']==$get['cityid']?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    指导员名称：<input type="text" name='nickname' value="<?php echo ($get['nickname']); ?>"/>
                    指导员账号：<input type="text" name='account' value="<?php echo ($get['account']); ?>"/>
                    <input style="font-size: 11px" value="查询" type="button" id='b'/>
                    <input  style="font-size: 11px" value="清空" type="reset" id='b'/>
                </form>
            </span>
        </div>
        <div style="margin-left: 6px">
            <input id="checkall" style="font-size: 12px;font-weight: bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0;" type="button" value='全选' />
            <input type="button" value='删除' onclick="batch_operate_del('zd')" style="font-size: 12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0"/>
            <script>
                $("document").ready(function(){
                    $("#checkall").click(function(){
                        if($(this).val() == '全选'){
                            $("input[type='checkbox']").prop('checked',true);
                            $("#checkall").val('取消全选');
                        }else{
                            $("input[type='checkbox']").prop('checked',false);
                            $("#checkall").val('全选');
                        }
                    });
                });

                function batch_operate_del(type){
                    var id_arr = document.getElementsByName('id[]');
                    var flag = false;
                    for(var i in id_arr){
                        if(id_arr[i].checked){
                            flag = true;
                            break;
                        }
                    }
                    if(flag){
                        $.post("<?php echo U('Admin/Finance/batch_operate');?>",$("#form2").serialize(),function(res){
                            layer.msg('确定要删除吗？',{
                                time:0,
                                btn:['确定','取消'],
                                yes:function(){
                                location.href = "<?php echo U('Admin/School/batch_operate_del');?>?pid=<?php echo ($get['pid']); ?>&p=<?php echo ($get['p']); ?>&str="+res.info['str']+"&type="+type
                                }
                            });
                        },'json')
                    }else{
                        layer.msg('请勾选后再操作',{time:2000,btn:['知道了']});
                    }
                }
            </script>
        </div>
        <div style="margin: 10px 5px;">
            <table class="table_a"  width="100%">
                <tbody>
                <tr style="background-color:rgb(19, 181, 177);">
                    <th width="3%">ID</th>
                    <th width="1%">账号</th>
                    <th width="3%">城市</th>
                    <th width="2%">头像</th>
                    <th width="4%">姓名</th>
                    <th width="4%">指导员号</th>
                    <th width="3%">最低价格</th>
                    <th width="2%">性别</th>
                    <th width="2%">课程数</th>
                    <th width="4%">类型</th>
                    <th width="3%">进驻基地</th>
                    <th width="2%">学员数</th>
                    <th width="2%">地标</th>
                    <th width="2%">评分</th>
                    <th width="4%">车牌号</th>
                    <!--<th width="3%">本周特价</th>-->
                    <!--<th width="3%">热门驾校</th>-->
                    <th width="3%">推荐驾校</th>
                    <th width="3%">计时培训</th>
                    <th width="3%">最后操作人</th>
                    <th width="8%">操作</th>
                </tr>
                <form action="" id="form2">
                    <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                            <td><input type="checkbox" name="id[]" value="<?php echo ($v["id"]); ?>"/><?php echo ($v["id"]); ?></td>
                            <td><?php echo ($v["account"]); ?></td>
                            <td><?php echo ($v["cityname"]); ?></td>
                            <td>
                                <?php if($v['picname'] != ''): ?><img src="<?php echo ($http); ?>/Uploads/guider_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>" alt="" style="border-radius:50%" width="50" height="40" />
                                    <?php else: ?>
                                    <img src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt="" style="border-radius:50%" width="50" height="40" /><?php endif; ?>
                            </td>
                            <td><?php echo ($v["nickname"]); ?>
                                <span style="color: rgb(19, 181, 177)">
                                    <?php if($v["hot"] == 1): ?>热搜<?php endif; ?>
                                    <?php if($v["recommand"] == 1): ?>推荐<?php endif; ?>
                                    <?php if($v["week"] == 1): ?>本周<?php endif; ?>
                                </span>
                            </td>
                            <td><?php echo ($v["serialid"]); ?></td>
                            <td><?php echo ($v["minprice"]); ?></td>
                            <td><?php echo ($v['sex']==0?'男':($v['sex']==1?'女':'保密')); ?></td>
                            <td>
                                <a class="tablelink" href="<?php echo U('Admin/TrainClass/train_class',array('id'=>$v['id'],'type'=>$v['type'],'p'=>$get['p'],'pid'=>$get['pid']));?>"><?php echo ($v['class_num']); ?></a>
                            </td>
                            <td><?php echo ($v["category_name"]); ?></td>
                            <td><a class="tablelink" href="<?php echo U('TrainAddress/train_Address?id='.$v['id'].'&type='.$v['type'].'&pid='.$get['pid'].'&p='.$get['p']);?>">查看</a></td>
                            <td><?php echo ($v["student_num"]); ?></td>
                            <td><a  class="tablelink"  href="<?php echo U('LandMark/see_land?id='.$v['id'].'&type='.$v['type'].'&pid='.$get['pid'].'&p='.$get['p']);?>">查看</a></td>
                            <td><?php echo ($v["score"]); ?></td>
                            <td><?php echo ($v["carnumber"]); ?></td>
                            <!--<td>-->
                                <!--<a class="tablelink"  href="javascript:;"  onclick="status_update(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,'week',<?php echo ($get['p']?$get['p']:1); ?>)"><?php echo ($v['week']?'取消本周':'本周'); ?></a>-->
                            <!--</td>-->
                            <!--<td>-->
                                <!--<a href="javascript:;"  class="tablelink"  onclick="status_update(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,'hot',<?php echo ($get['p']?$get['p']:1); ?>)"><?php echo ($v['hot']?'取消热门':'热门'); ?></a>-->
                            <!--</td>-->
                            <td>
                                <a href="javascript:;"  class="tablelink"onclick="status_update(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,'recommand',<?php echo ($get['p']?$get['p']:1); ?>)"><?php echo ($v['recommand']?'取消推荐':'推荐'); ?></a>
                            </td>
                            <td>
                                <a href="javascript:;"  class="tablelink"  onclick="status_update(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,'timing',<?php echo ($get['p']?$get['p']:1); ?>)"><?php echo ($v['timing']?'取消计时':'计时'); ?></a>
                            </td>
                            <td> <?php echo ($v["lastupdate"]); ?></td>
                            <td>
                                <a  class="tablelink" href="<?php echo U('Admin/Environment/abstract_pic',array('id'=>$v['id'],'type'=>$v['type'],'p'=>$get['p'],'pid'=>$get['pid'],'t'=>1));?>">教学环境</a>
                                <span>|</span>
                                <a class="tablelink" href="<?php echo U('Admin/Environment/abstract_pic',array('id'=>$v['id'],'type'=>$v['type'],'pid'=>$get['pid'],'p'=>$get['p'],'t'=>0));?>">简介图片</a>
                                <span>|</span>
                                <a class="tablelink" href="<?php echo U('editor_zd',array('id'=>$v['id'],'type'=>$v['type'],'p'=>$get['p'],'pid'=>$get['pid']));?>">编辑</a>　
                                <span>|</span>
                                <a  class="tablelink" onclick="show_forbid(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,<?php echo ($get['p']?$get['p']:1); ?>)"><?php echo ($v['show_forbid']?'禁止':'展示'); ?></a>
                                <script>
                                    function show_forbid(id,pid,p){
                                        layer.msg('确定要这样吗？',{
                                            time:0,
                                            btn:['确定','取消'],
                                            yes:function(){
                                                location.href = "<?php echo U('Admin/School/show_forbid');?>?id="+id+'&pid='+pid+'&p='+p
                                            }
                                        });
                                    }

                                    function status_update(id,pid,type,p){
                                        layer.msg('确定要这样吗？',{
                                            time:0,
                                            btn:['确定','取消'],
                                            yes:function(){
                                                location.href = "<?php echo U('Admin/School/status_update');?>?id="+id+'&pid='+pid+'&type='+type+'&p='+p
                                            }
                                        });
                                    }
                                </script>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </form>
                </tbody>
            </table>
            <div id="page">
                <?php echo ($page); ?>
            </div>
        </div>
    </body>
</html>