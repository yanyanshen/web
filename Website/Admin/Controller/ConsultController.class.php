<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
use Think\Page;
class ConsultController extends CommonController{
    public function index(){
//判断是否有资讯添加按钮权限
        $consult = D('AuthRule')->getRule(I('pid'),'资讯添加');
        $this->assign('consult',$consult['name']);

        $where = "s.cityid=c.id and s.flag=0";
        $count=M('Consult')->table('xueches_consult s,xueches_citys c')->where($where)->count();
        $this->assign('count',$count);
        $page=new Page($count,10);
        $show=$page->show();
        $info=M('Consult')->table('xueches_consult s,xueches_citys c')->order('ntime desc')
            ->field('s.id,s.order1,s.title,s.content,s.picurl,s.picname,s.flag,s.ntime,s.update_people,
                s.touch_count,c.cityname,c.id as cityid')->where($where)
            ->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('http',C('HTTP'));
        $this->assign('info',$info);
        $this->assign('page',$show);
        $this->assign('firstRow',$page->firstRow);

        $this->assign('get',$_GET);
        $this->display();
    }

    public function consult(){
        if(IS_AJAX){
            $_POST['update_people']=session('admin_name');
            $_POST['ntime']=date('Y-m-d H:i:s',time());
            if(I('id')){
                $log['done'] = '修改驾校资讯 ID_'.I('id');
                M('consult')->where(array('id'=>$_POST['id']))->save($_POST);
                $res=editorPic('consult','Consult_logo',$_POST['id'],'');
                $url=U('Consult/index',array('pid'=>I('pid'),'p'=>I('p')));
            }else{
                $id=M('consult')->add($_POST);
                $log['done'] = '添加驾校资讯 ID_'.$id;
                $res=UploadPic('consult','Consult_logo',$id);
                $url=U('Consult/index',array('pid'=>I('pid'),'p'=>I('p')));
            }
            if($res){
                D('AdminLog')->logout($log);
                $this->success('操作成功',$url);
            }else{
                $this->error('操作失败',$url);
            }
        }else{
            if(I('id')){
                $consult=M('Consult')->where(array('id'=>$_GET['id']))->find();
                $this->assign('consult',$consult);
                $this->assign('btn','编辑');
            }
            $this->assign('get',$_GET);
            $citys=D('citys')->city_one(array('flag'=>1),'id,cityname',1);
            $this->assign('citys',$citys);
            $this->display();
        }
    }

    public function first_index(){
        $where = 's.flag=1 and s.cityid=c.id';
        $count=M('Consult')
            ->table('xueches_consult s,xueches_citys c')->where($where)->count();
        $this->assign('count',$count);
        $page=new Page($count,10);
        $show=$page->show();
        $info=M('Consult')->table('xueches_consult s,xueches_citys c')->order('order1')
            ->field('s.id,s.order1,s.title,s.picurl,s.picname,s.flag,s.ntime,s.update_people,
                s.touch_count,s.content,c.cityname,c.id as cityid')->where($where)
            ->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('http',C('HTTP'));
        $this->assign('info',$info);
        $this->assign('page',$show);
        $this->assign('get',$_GET);
        $this->assign('firstRow',$page->firstRow);
        $this->display();
    }
//删除驾校资讯
    public function del_consult(){
        $id = I('id');
        $res = del_pic('consult','Consult_logo',$id);
        M('consult')->where(array('id'=>$id))->delete();
        if($res){
            $log['done'] = '删除驾校资讯 ID_'.$id;
            D('AdminLog')->logout($log);
            $this->redirect('Admin/Consult/index',array('p'=>I('p'),'pid'=>I('pid')),0,"<script>alert('删除成功')</script>");
        }else{
            $this->redirect('Admin/Consult/index',array('p'=>I('p'),'pid'=>I('pid')),0,"<script>alert('删除失败')</script>");
        }
    }


    public function statusUpdate(){
        $id=I('id');
        $flag=M('consult')->where(array('id'=>$id))->getField('flag');
        if($flag==1){
            $data['flag']=0;
            $data['order1']=0;
        }else{
            $data['flag']=1;
        }
        $res=M('consult')->where(array('id'=>$id))->save($data);
        $url = U('Admin/Consult/index',array('pid'=>I('pid'),'p'=>I('p')));
        if($res){
            $log['done'] = '设置/取消首页驾校资讯 ID_'.$id;
            D('AdminLog')->logout($log);
            $this->success('操作成功',$url);
        }else{
            $this->error('操作失败',$url);
        }
    }

    public function setPriority(){
        $row=M('consult')->save($_POST);
        $url = U('Admin/Consult/first_index',array('pid'=>I('pid'),'p'=>I('p')));
        if($row){
            $log['done'] = '首页驾校资讯优先级更新 ID_'.I('id');
            D('AdminLog')->logout($log);
            $this->success('优先级更新成功',$url);
        }else{
            $this->error('优先级更新失败',$url);
        }
    }
}