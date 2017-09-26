<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>基地管理</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <style>
        #page a,#page span{
            display: inline-block;  width:18px;  height:18px ;  padding: 5px;  margin: 2px;  text-decoration: none;
            text-align: center;  line-height: 18px;  background: #f0ead8;  color:#000000;  border: 1px solid #c2d2d7;  }
        #page a:hover{  background:#F27602;  color:#FF0000;  }
        #page span{  background:#F27602;  color:#FF0000;  font-weight: bold;  }
        #page{  float: right;  }
    </style>
</head>
<body>
    <div class="div_head">
        <span>
            <span style="float: left;">当前位置是：系统管理-》基地管理</span>
            <span style="float: right; margin-right: 8px; font-weight: bold;">
                <form action="<?php echo U('add_trainaddress');?>" method="post">
                    <input type="hidden" name="cityid" value="<?php echo ($cityid); ?>" id="cityid"/>
                </form>
            </span>
        </span>
    </div>
    <div></div>
    <div class="div_search">
        <span style="float:left">
            <form action="<?php echo U('Admin/TrainAddress/index');?>" method="get">
                城市<select name="cityid"  onchange="change(this)">
                <?php if(is_array($citys)): $i = 0; $__LIST__ = $citys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($cityid==$v['id']?'selected':''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>
                <input value="查询" type="submit" value="查询"/>
            </form>
        </span>
    <span style="float:right">总计：<?php echo ($count); ?></span>
</div>
    <div style="font-size: 13px; margin: 10px 5px;">
    <table class="table_a" border="1" width="100%">
        <tbody><tr style="font-weight: bold;">
            <th width="3%">序号</th>
            <th width="5%">基地</th>
            <th width="20%">地址</th>
            <th width="10%">添加/修改时间</th>
            <th width="3%">操作</th>
        </tr>
        <?php if(is_array($train)): $k = 0; $__LIST__ = $train;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                <td><?php echo ($k+$firstRow); ?></td>
                <td><?php echo ($v["trname"]); ?></td>
                <td><?php echo ($v["address"]); ?></td>
                <td><?php echo date('Y-m-d',$v.time);?></td>
                <td>
                    <a href="<?php echo U('del_train?id='.$v['id'].'&cityid='.$cityid.'&p='.$p);?>" onclick="if(confirm('确定删除?')==false)return false;">删除</a>
                    <a href="<?php echo U('add_trainaddress?id='.$v['id'].'&p='.$p);?>">编辑</a>
                </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>
        <div id="page">
            <?php echo ($page); ?>
        </div>
</div>
</body>
</html>

<script>
    var change= function(sel){
        $("#cityid").val(sel.value);
    };
</script>