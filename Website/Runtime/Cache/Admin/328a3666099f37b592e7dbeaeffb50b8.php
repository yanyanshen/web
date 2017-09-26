<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

        <title>学员员列表</title>

        <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
        <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
        <style>
            #page a,#page span{
                display: inline-block; width:15px;height:15px ;padding: 5px;margin: 2px;text-decoration: none;
                text-align: center; line-height: 15px;background: #f0ead8; color:#000000;  border: 1px solid #c2d2d7;
            }
            #page a:hover{background:#F27602;color:#FF0000;}
            #page span{ background:#F27602; color:#FF0000; font-weight: bold;}
            #page{ float: right; }
            .tr_color{background-color: #9F88FF}
        </style>
    </head>
    <body>
        <div class="div_head">
            <span>
                <span style="float: left;">当前位置是：系统管理-》学员列表</span>
                <span style="float: right; margin-right: 8px; font-weight: bold;">
                    <a style="text-decoration: none;" href="<?php echo U('add_stu');?>">【添加学员】</a>
                </span>
            </span>
        </div>
        <div></div>
        <div class="div_search">
            <span style="float:left">
                <form action="<?php echo U('Admin/Student/stu_list');?>" id='form' method="get">
                    城市<select name="cityid">
                    <option value="0">请选择</option>
                <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>"  <?php echo ($v['id']==$cityid?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
           </select>
                   学员姓名：<input type="text" name='truename' value="<?php echo ($truename?$truename:''); ?>" />
                    学员账号：<input type="text" name='account' value="<?php echo ($account?$account:''); ?>"/>
                    <input value="查询" type="submit"/>
                </form>
            </span>
            <span style="float:right">总计：<?php echo ($count); ?>　　</span>
        </div>
        <div style="font-size: 13px; margin: 10px 5px;">
            <table class="table_a" border="1" width="100%">
                <tbody><tr style="font-weight: bold;">
                        <th width="4%">编号</th>
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
                        <th width="10%">操作</th>
                    </tr>
                    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><tr>
                    		<td><?php echo ($vv["id"]); ?></td>
                    		<td><?php echo ($vv["account"]); ?></td>
                    		<td><img src="http://www.517xc.com/Upload/small/<?php echo ($vv['img']); ?>" alt="" style="border-radius:50%" width="50" height="50" /></td>
	                    	<td><?php echo ($vv["truename"]); ?></td>
							<td><?php echo ($vv['sex']==0?'保密':($vv['sex']==1?'男':'女')); ?></td>
							<td><?php echo date('Y-m-d H:i:s',$vv['ntime']);?></td>
							<td><?php echo ($vv["account"]); ?></td>
							<td>科目<?php echo ($vv['subjects']==0?'暂无':($vv['subjects']==1?'一':($vv['subjects']==2?'二':($vv['subjects']==3?'三':'四')))); ?></td>
						   	<td><a href="<?php echo U('Admin/Order/order_list?userid='.$vv['id']);?>" ><?php echo ($vv["listcount"]); ?>个订单</a></td>
						   	<td><a href=""><?php echo ((isset($vv["rescount"]) && ($vv["rescount"] !== ""))?($vv["rescount"]):0); ?>个计时预约</a></td>
						   	<td><a href="<?php echo U('stu_info?id='.$vv['id']);?>"><?php echo ((isset($vv["apply_count"]) && ($vv["apply_count"] !== ""))?($vv["apply_count"]):0); ?>个预约报名</a></td>
						    <td>
                                <a href="<?php echo U('verify?id='.$vv['id'].'&flag='.$vv['verify']);?>"><?php echo ($vv['verify']==0?"<font style='color:green'>启用</font>":"<font style='color:red'>禁用</font>"); ?></a></td>
								<td><?php echo ($vv["lastupdate"]); ?></td>
						    <td>
						     <a title="编辑" href="<?php echo U('stu_info?id='.$vv['id']);?>">编辑</a>
						     <a title="删除" href="<?php echo U('del_stu?id='.$vv['id']);?>" onclick="if(confirm('确定删除?')==false)return false;" >删除</a></td>
                    	</tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                </tbody>
            </table>
            <div id="page" style="float: left"><?php echo ($page); ?></div>
        </div>
    </body>
</html>