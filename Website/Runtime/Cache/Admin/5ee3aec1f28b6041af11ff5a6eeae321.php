<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <title>语言列表</title>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script src="/Public/public/js/jquery-3.2.1.min.js"></script>
    <script src="/Public/public/js/layer/layer.js"></script>
</head>
<body>
    <div class="div_head">
        语言列表
        <?php if($get['add_language'] == '0'): ?><a style="text-decoration: none;color:#fa7124;"
               href="javascript:alert('暂无权限');">【语言添加】</a>
            <?php else: ?>
            <a style="text-decoration: none;color:#fa7124;"
               href="<?php echo U($get['add_language'],array('pid'=>$get['pid'],'p'=>$get['p']));?>">【语言添加】</a><?php endif; ?>
        <span class="span">总计：<?php echo ($list['count']); ?></span>
    </div>
    <div class="div_search" >
        <span>
            <form action="<?php echo U('Admin/Language/index',array('pid'=>$get['pid'],'p'=>$get['p']));?>" id='form' method="get">
                城市：<select name="cityid" style="font-size: 12px;width: 70px;height: 20px;">
                    <option value="0">请选择</option>
                    <?php if(is_array($city)): $i = 0; $__LIST__ = $city;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$v): $mod = ($i % 2 );++$i;?><option value="<?php echo ($v["id"]); ?>" <?php echo ($v['id']==$get['cityid']?selected:''); ?>><?php echo ($v["cityname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                语言名称：<input type="text" name='nickname' value="<?php echo ($get['nickname']?$get['nickname']:''); ?>" />
                <input value="查询" type="submit" id='btn'/>
                <input value="清空全部" type="reset" id='btn'/>
            </form>
        </span>
    </div>
    <div style="margin: 10px 5px;">
    <table class="table_a"  width="100%">
        <tbody>
            <tr style="background-color:rgb(19, 181, 177);">
                <th width="2%">编号</th>
                <th width="2%">ID</th>
                <th width="3%">头像</th>
                <th width="6%">语言名称</th>
                <th width="4%">价格</th>
                <th width="3%">城市</th>
                <th width="8%">地址</th>
                <th width="3%">课程</th>
                <th width="4%">学员</th>
                <th width="2%">评分</th>
                <th width="4%">官方电话</th>
                <th width="4%">负责人电话</th>
                <th width="3%">最后操作人</th>
                <th width="10%">操作</th>
            </tr>
            <?php if(is_array($list["list"])): $k = 0; $__LIST__ = $list["list"];if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$v): $mod = ($k % 2 );++$k;?><tr>
                    <td><?php echo ($k+$firstRow); ?></td>
                    <td><?php echo ($v["id"]); ?></td>
                    <td>
                        <?php if($v['picurl'] != ''): ?><img src="<?php echo ($v['picurl']); ?>" alt="" style="border-radius:50%" width="55" height="40" />
                        <?php else: ?>
                            <img src="<?php echo ($http); ?>/Uploads/default_logo/517.png" alt="" style="border-radius:50%" width="50" height="40" /><?php endif; ?>
                    </td>
                    <td><?php echo ($v["nickname"]); ?></td>
                    <td><?php echo ($v["minprice"]); ?>元起</td>
                    <td><?php echo ($v["cityname"]); ?></td>
                    <td><?php echo ($v["address"]); ?></td>
                    <td>
                        <a class="tablelink" href="<?php echo U('Admin/Language/language_class',array('id'=>$v['id'],'pid'=>$get['pid'],'p'=>$get['p']));?>"><?php echo ($v["class_num"]); ?>个课程</a>
                    </td>
                    <td><?php echo ($v["num"]); ?>个学员</td>
                    <td><?php echo ($v["score"]); ?></td>
                    <td><?php echo ($v["official_tel"]); ?></td>
                    <td><?php echo ($v["manager_tel"]); ?></td>
                    <td><?php echo ($v["lastupdate"]); ?></td>
                    <td>
                        <a  class="tablelink" href="<?php echo U('language_edit',array('id'=>$v['id'],'pid'=>$get['pid'],'p'=>$get['p']));?>">编辑</a>　
                        <span>|</span>
                        <a class="tablelink" href="<?php echo U('abstract_pic',array('id'=>$v['id'],'pid'=>$get['pid'],'p'=>$get['p'],'type'=>0));?>">简介图片</a>　
                        <span>|</span>
                        <a class="tablelink" href="<?php echo U('abstract_pic',array('id'=>$v['id'],'pid'=>$get['pid'],'p'=>$get['p'],'type'=>1));?>">环境</a>　
                        <span>|</span>
                        <a class="tablelink" href="<?php echo U('language_comment',array('id'=>$v['id'],'pid'=>$get['pid'],'p'=>$get['p']));?>">评价</a>　
                        <a  class="tablelink" href="javascript:void(0);"
                           onclick="del(<?php echo ($v['id']); ?>,<?php echo ($get['pid']); ?>,'language',<?php echo ($get['p']?$get['p']:1); ?>)">删除</a>
                        <script>
                            function del(id,pid,type,p){
                                layer.msg('确定要删除吗？', {
                                    time: 0, //不自动关闭
                                    btn: ["确定", '取消'],
                                    yes: function(){
                                        location.href='<?php echo U("Admin/cyclope/del");?>?id='+id+'&pid='+pid+'&type='+type+'&p='+p; //此处只是为了演示，实际使用可以剔除
                                    }
                                });
                            }
                        </script>
                    </td>
                </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
        </tbody>
    </table>
    <div id="page">
        <?php echo ($list['page']); ?>
    </div>
</div>
</body>
</html>