<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>语言教育评价</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script  src="/Public/public/js/My97DatePicker/WdatePicker.js"></script>
</head>
<body>
    <div class="div_head">
        <?php echo ($get['nickname']); ?> - 评价列表
        <a style="text-decoration: none;color:#fa7124;"
               href="<?php echo ($get['add_url']); ?>">【评价添加】</a>
        <a style="text-decoration: none;color:#fa7124;"
               href="<?php echo ($get['url']); ?>">【返回】</a>
        <span class="span">总计：<?php echo ($get['count']); ?></span>
    </div>
    <div class="div_search">
        <span>
            <form action="<?php echo U('Admin/Language/language_comment',array('pid'=>$get['pid'],'p'=>$get['p'],'id'=>$get['id']));?>" id='form' method="get">
                评价时间：<input type="text" style="width: 100px" name='ntime1' value="<?php echo ($get['ntime1']?$get['ntime1']:''); ?>" onClick="WdatePicker()"/>
                至 <input type="text" style="width: 100px" name='ntime2' value="<?php echo ($get['ntime2']?$get['ntime2']:''); ?>" onClick="WdatePicker()"/>
                <input value="查询" style="font-size: 11px" type="submit"/>
            </form>
        </span>
    </div>
    <div style="margin: 10px 5px;">
    <table class="table_a" width="100%">
        <tbody>
            <tr style="background-color: rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="2%">ID</th>
                <th width="2%">评论人</th>
                <th width="15%">内容</th>
                <th width="2%">时间</th>
                <th width="2%">评分</th>
                <th width="3%">最后操作人</th>
                <th width="3%">操作</th>
            </tr>
            <?php if(is_array($get["info"])): $k = 0; $__LIST__ = $get["info"];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["id"]); ?></td>
                    <td><?php echo ($v["username"]); ?></td>
                    <td><?php echo ($v["content"]); ?></td>
                    <td><?php echo ($v["ntime"]); ?></td>
                    <td><?php echo ($v["score"]); ?></td>
                    <td><?php echo ($v["lastupdate"]); ?></td>
                    <td>
                        <a class="tablelink" href="<?php echo U('Admin/Language/language_comment_del',array('id'=>$v['id'],'pid'=>$get['pid'],'p'=>$get['p'],'type_id'=>$get['id']));?>" onclick="if(confirm('确认此操作吗？')==false) return false">删除</a>
                    </td>　
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($page); ?>
    </div>
</div>
</body>
</html>