<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv=content-type content="text/html; charset=utf-8" />
        <link href="/Public/website/Admin/ment/css/admin.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <table cellspacing=0 cellpadding=0 width="100%" background="/Public/website/Admin/ment/img/header_bg.jpg" border=0>
            <tr height=56>
                <td width=260>
                    <img height=56 src="/Public/website/Admin/ment/img/header_left.jpg" width=260>
                </td>
                <td style="font-weight: bold; color: #fff; padding-top: 20px" 
                    align=middle>当前用户：<?php echo (session('admin_name')); ?> &nbsp;&nbsp;
                    <a style="color: #fff" onclick="if (confirm('确定要退出吗？')) return true; else return false;" href="<?php echo U('Admin/Login/logout');?>" target=_top>退出系统</a>
                </td>
                <td align=right width=268>
                    <img height=56 src="/Public/website/Admin/ment/img/header_right.jpg" width=268>
                </td>
            </tr>
        </table>
        <table cellspacing=0 cellpadding=0 width="100%" border=0>
            <tr bgcolor=#1c5db6 height=4>
                <td></td>
            </tr>
        </table>
    </body>
</html>