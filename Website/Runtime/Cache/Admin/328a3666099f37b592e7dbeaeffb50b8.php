<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
        <title>学员列表</title>
        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
        <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
        <script src="/Public/public/js/layer/layer.js"></script>
    </head>
    <body>
        <div class="div_head">
            学员列表
            <a href="" style="text-decoration: none;color: #FA7124">【刷新】</a>
            <span class="span">总计：<?php echo ($count); ?>　</span>
        </div>
        <div class="div_search">
            <span>
                <form action="<?php echo U('Admin/Student/stu_list',array('pid'=>$get['pid'],'p'=>$get['p']));?>" id='form' method="get">
                    城市：<select name="cityid" style="font-size: 12px;width: 80px;height: 20px">
                    <option value="0">请选择</option>
                    <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"  <?php echo ($v['id']==$get['cityid']?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                   学员姓名：<input type="text" name='truename' value="<?php echo ($get['truename']?$get['truename']:''); ?>" />
                    学员账号：<input type="text" name='account' value="<?php echo ($get['account']?$get['account']:''); ?>"/>
                    <input style="font-size: 11px" value="查询" type="submit" id="b"/>
                    <input style="font-size: 11px" value="清空" type="reset"  id="b"/>
                </form>
            </span>
        </div>
        <div style="margin-left: 6px">
            <input id="checkall" style="font-size: 12px;font-weight: bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0;" type="button" value='全选' />
            <input type="button" value='删除' onclick="batch_operate_del()" style="font-size: 12px;font-weight:bold;background-color:rgb(247, 247, 247);border-radius: 3px;border:none;color: #646464;width: 60px;padding: 2px 0"/>
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

                function batch_operate_del(){
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
                                    location.href = "<?php echo U('Admin/Student/batch_operate_del');?>?pid=<?php echo ($get['pid']); ?>&p=<?php echo ($get['p']); ?>&str="+res.info['str']
                                }
                            });
                        },'json')
                    }else{
                        layer.msg('请勾选后再操作',{time:2000,btn:['知道了']});
                    }
                }
            </script>
        </div>
        <div style=" margin: 10px 5px;">
            <table class="table_a" width="100%">
                <tbody>
                <tr style="background-color: rgb(19, 181, 177);">
                    <th width="4%">ID</th>
                    <th width="8%">账号</th>
                    <th width="4%">头像</th>
                    <th width="7%">学员姓名</th>
                    <th width="4%">性别</th>
                    <th width="10%">注册时间</th>
                    <th width="8%">联系方式</th>
                    <th width="4%">当前科目</th>
                    <th width="5%">订单个数</th>
                    <th width="5%">计时预约个数</th>
                    <th width="5%">预约个数</th>
                    <th width="3%">状态</th>
                    <th width="5%">最后操作人</th>
                    <th width="5%">操作</th>
                    </tr>
                <form action="" id="form2">
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><tr>
                    		<td><input type="checkbox" value="<?php echo ($vv["id"]); ?>" name="id[]"/><?php echo ($vv["id"]); ?></td>
                    		<td><?php echo ($vv["account"]); ?></td>
                    		<td>
                                <?php if($vv['img'] != ''): ?><img  src="<?php echo ($http); ?>/Uploads/small/<?php echo ($vv['img']); ?>" alt="" style="border-radius:50%" width="50" height="40" />
                                    <?php else: ?>
                                    <img  src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt="" style="border-radius:50%" width="50" height="40" /><?php endif; ?>
                            </td>
	                    	<td><?php echo ($vv["truename"]); ?></td>
							<td><?php echo ($vv['sex']==0?'保密':($vv['sex']==1?'男':'女')); ?></td>
							<td><?php echo date('Y-m-d H:i:s',$vv['ntime']);?></td>
							<td><?php echo ($vv["account"]); ?></td>
							<td>科目<?php echo ($vv['subject']==0?'暂无':$vv['subject']); ?></td>
						   	<td><a class="tablelink" href="<?php echo U('Admin/Order/order_list?userid='.$vv['id'].'&pid='.$get['pid'].'&p='.$get['p']);?>" ><?php echo ($vv["listcount"]); ?>个订单</a></td>
						   	<td><a class="tablelink" href=""><?php echo ((isset($vv["rescount"]) && ($vv["rescount"] !== ""))?($vv["rescount"]):0); ?>个计时预约</a></td>
						   	<td><a class="tablelink" href="<?php echo U('Admin/Student/school_apply',array('pid'=>$get['pid'],'p'=>$get['p'],'mid'=>$vv['id']));?>"><?php echo ((isset($vv["apply_count"]) && ($vv["apply_count"] !== ""))?($vv["apply_count"]):0); ?>个预约报名</a></td>
						    <td>
                                <a class="tablelink" href="<?php echo U('verify?id='.$vv['id'].'&flag='.$vv['verify'].'&p='.$get['p'].'&pid='.$get['pid']);?>"><?php echo ($vv['verify']==0?"<font style='color:rgb(19, 181, 177)'>启用</font>":"<font style='color:rgb(19, 181, 177)'>禁用</font>"); ?></a></td>
								<td><?php echo ($vv["lastupdate"]); ?></td>
						    <td>
						     <a class="tablelink" title="编辑" href="<?php echo U('stu_info?id='.$vv['id'].'&pid='.$get['pid'].'&p='.$get['p']);?>">编辑</a>
                        </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                </form>
                </tbody>
            </table>
            <div id="page"><?php echo ($page); ?></div>
        </div>
    </body>
</html>