<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />

    <title>驾校列表</title>

    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>

    <style>
        #page a,#page span{
            display: inline-block; width:15px;height:15px ;padding: 5px;margin: 2px;text-decoration: none;
            text-align: center; line-height: 15px;background: #f0ead8; color:#000000;  border: 1px solid #c2d2d7;
        }
        #page a:hover{background:#F27602;color:#FF0000;}
        #page span{ background:#F27602; color:#FF0000; font-weight: bold;}
        #page{ float: right; }
        .tablelink{ cursor: pointer;}
        .message,.blue{font-size: 15px}
        .tr_color{background-color: #9F88FF}
    </style>
</head>
<body>
    <div class="div_head">
        <span>
            <span style="float: left;">当前位置是：用户管理-》驾校列表</span>
            <span style="float: right; margin-right: 8px; font-weight: bold;">
                <a style="text-decoration: none;" href="<?php echo U('Admin/School/add_jx',array('type'=>'jx'));?>">【添加驾校】</a>
            </span>
        </span>
    </div>
    <div></div>
    <div class="div_search">
        <span style="float:left">
            <form action="<?php echo U('Admin/School/jx_list');?>" id='form' method="get">
                城市<select name="cityid" >
                <option value="0">请选择</option>
                <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id']==$cityid?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
                驾校简称：<input type="text" name='nickname' value="<?php echo ($nickname?$nickname:''); ?>" />
                驾校账号：<input type="text" name='account' value="<?php echo ($account?$account:''); ?>"/>
                <input value="查询" type="submit" id='btn'/>
                <input value="清空全部" type="reset" id=''/>
            </form>
        </span>
        <span style="float:right">总计：<?php echo ($count); ?>　　</span>
    </div>
    <div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" border="1" width="100%">
        <tbody>
            <tr style="font-weight: bold;">
                <th width="2%">编号</th>
                <th width="5%">账号</th>
                <th width="4%">头像</th>
                <th width="4%">城市</th>
                <th width="8%">驾校简称</th>
                <th width="8%">地址</th>
                <th width="4%">进驻基地</th>
                <th width="4%">开设课程</th>
                <th width="5%">学员</th>
                <th width="5%">教练</th>
                <th width="3%">地标</th>
                <th width="3%">评分</th>
                <th width="8%">驾校联系人</th>
                <!--<th width="3%">证件</th>-->
                <!--<th width="4%">认证</th>-->
                <th width="5%">最后操作人</th>
                <th width="10%">操作</th>
            </tr>
            <?php if(is_array($jx_list)): $k = 0; $__LIST__ = $jx_list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <!--<td><input type="text" value="<?php echo ($v["order"]); ?>"  style="width:30px" /></td>-->
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["account"]); ?></td>
                    <td>
                        <?php if($v['picname'] != ''): ?><img src="<?php echo ($http); ?>/Uploads/School_logo/<?php echo ($v['picurl']); echo ($v['picname']); ?>" alt="" style="border-radius:50%" width="50" height="50" />
                        <?php else: ?>
                            <img src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt="" style="border-radius:50%" width="50" height="50" /><?php endif; ?>
                    </td>
                    <td><?php echo ($v["cityname"]); ?></td>
                    <td><?php echo ($v["nickname"]); ?><br>
                        <span style="color: #20c318">
                            <?php if($v["hot"] == 1): ?>热搜<?php endif; ?>
                            <?php if($v["recommand"] == 1): ?>推荐<?php endif; ?>
                            <?php if($v["week"] == 1): ?>本周<?php endif; ?>
                        </span>
                    </td>
                    <td><?php echo ($v["address"]); ?></td>
                    <td><a href="<?php echo U('TrainAddress/train_Address?id='.$v['id'].'&type='.$v['type']);?>">查看</a></td>
                    <td>
                        <a href="<?php echo U('Admin/TrainClass/train_class',array('id'=>$v['id'],'type'=>'jx'));?>"><?php echo ($v["class_num"]); ?>个课程</a>
                    </td>
                    <td><?php echo ($v["student_num"]); ?>个学员</td>
                    <td><?php echo ($v["coach_num"]); ?>个教练</td>
                    <td><a href="<?php echo U('LandMark/see_land?id='.$v['id'].'&type='.$v['type']);?>">查看</a></td>
                    <td><?php echo ($v["score"]); ?></td>
                    <td><?php echo ($v["connectteacher"]); ?></td>
                    <td><?php echo ($v["lastupdate"]); ?></td>
                    <td style="text-align: center">
                        <a href="<?php echo U('Admin/Environment/index',array('id'=>$v['id'],'type'=>$v['type']));?>">驾考环境</a>
                        <a href="<?php echo U('Admin/School/jx_editor?id='.$v['id']);?>">编辑</a>　
                        <a href="<?php echo U('Admin/School/del_school?id='.$v['id']);?>" onclick="if(confirm('确定删除?')==false)return false;">删除</a>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page" style="float: left">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>