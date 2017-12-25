<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class PermissionsController extends CommonController{
/*---------------------2017-12-19shenyanyan--------------------*/
//管理员级别列表
    public function index(){
        $permissions = M('Permissions')->field('*')->select();
        $_GET['count'] = count($permissions);
        $this->assign('permissions',$permissions);
        $this->assign('get',$_GET);
        $this->display();
    }
//管理员级别添加、编辑
    public function add(){
        if(IS_AJAX){
            $_POST['edittime'] = date('Y-m-d H:i:s',time());
            if(I('id')){
                $permissions_name = M('Permissions')->where(array('id'=>I('id')))->getField('Permissions');
                $log['done'] = "管理员级别信息: $permissions_name => {$_POST['permissions']}";
                $_POST['edittime'] = date('Y-m-d H:i:s',time());
                $res = M('Permissions')->save($_POST);
            }else{
                if(M('Permissions')->where(array('permissions'=>trim(I('permissions'))))->getField('id')){
                    $this->error('级别名称已经存在！');
                }else{
                    $_POST['ntime'] = date('Y-m-d H:i:s',time());
                    $res = M('Permissions')->add($_POST);
                    $log['done'] = "管理员级别信息: => {$_POST['permissions']}";
                }
            }
            if($res){
                D('AdminLog')->logout($log);
                $this->success('操作成功',U('Admin/Permissions/index',array('pid'=>I('pid'))));
            }else{
                $this->error('操作失败');
            }
        }else{
            if(I('id')){
                $permissions = M('Permissions')->field('permissions')->where(array('id'=>I('id')))->find();
                $this->assign('permissions',$permissions);
            }
            $this->assign('url',U('Admin/Permissions/index',array('pid'=>I('pid'))));
            $this->assign('get',$_GET);
            $this->display();
        }
    }
//管理员级别批量删除
    public function del(){
        $idArr = explode(',',I('str'));
        foreach($idArr as $k => $v){
            $log['done'] = '管理员级别删除: => '.M('Permissions')->where(array('id'=>$v))->getField('permissions');
            D('AdminLog')->logout($log);
            M('Permissions')->where(array('id'=>$v))->delete();
        }
        $this->redirect('Admin/Permissions/index',array('pid'=>I('pid')));
    }
}