<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head lang="en">
    <meta charset="UTF-8">
    <title></title>
    <script src="/Public/public/js/jquery.min.1.8.2.js"></script>
    <link href="/Public/website/Admin/ment/css/mine.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/Public/public/kindeditor/kindeditor-all.js"></script>
    <script type="text/javascript" src="/Public/public/js/layer/layer.js"></script>
    <style>
        .table_a td{text-align: left}
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
<body>
<div>
    <table class="table_a">
        <tr style="background-color: rgb(19, 181, 177);">
            <th width="10%">驾校</th>
            <th width="25%">评论内容</th>
            <th width="25%">回复内容</th>
        </tr>
        <tr>
            <td><?php echo ($info['nickname']); ?></td>
            <td>
                <p>
                    <span style="color: #FA7124">【<?php echo ($info['ntime']); ?>】</span>
                    <?php echo ($info['content']); ?>
                </p>
                <?php if(!empty($info['until'])): ?><p>
                        <span style="color: #FA7124"><?php echo ($info['truename']); ?>追加【<?php echo ($info['until']['ntime']); ?>】</span>
                        <?php echo ($info['until']['content']); ?>
                    </p><?php endif; ?>
            </td>
            <?php if(!empty($reply)): ?><td>
                    <?php if(is_array($reply)): $i = 0; $__LIST__ = $reply;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$data): $mod = ($i % 2 );++$i;?><div><span style="color: #FA7124"><?php echo ($data['lastupdate']); ?>回复【<?php echo ($data['ntime']); ?>】</span><?php echo ($data['content']); ?></div><?php endforeach; endif; else: echo "" ;endif; ?>
                </td>
                <?php else: ?>
                <td>/</td><?php endif; ?>
        </tr>
    </table>
    <form action="" id="form1">
        <input type="hidden" name="eid" value="<?php echo ($get['id']); ?>"/>
        <input type="hidden" name="pid" value="<?php echo ($get['pid']); ?>"/>
        <input type="hidden" name="p" value="<?php echo ($get['p']); ?>"/>
        <div style="margin-top: 20px;">
            <textarea name="content"  id="content7" style="width:100%;height:200px;visibility:hidden;">我们会继续努力的！！！</textarea>
            <input  style="margin:2% 0 0 42%;width: 137px;height: 35px;line-height: 35px;background-color: rgb(60,149,200);border: none;border-radius: 4px;color: #ffffff "  type="button" id="submit" value="确认回复"/>
        </div>
    </form>
</div>
</body>
</html>
<script>
    $("#submit").click(function(){
        $.post("<?php echo U('Student/evaluate_reply');?>",$("#form1").serialize(),function(res){
            if(res.status){
                layer.msg(res.info,{icon:6,time:2000},function(){
                    parent.location = res.url;
                });
            }else{
                layer.msg(res.info,{icon:5,time:2000},function(){
                    parent.location = res.url;
                });
            }
        },'json');
    })
</script>