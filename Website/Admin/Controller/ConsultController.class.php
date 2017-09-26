<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
use Think\Page;
class ConsultController extends CommonController{
    public function index(){
        $where = "s.cityid=c.id";
        $count=M('Consult')
            ->table('xueches_consult s,xueches_citys c')
            ->where($where)->count();
        $this->assign('count',$count);
        $page=new Page($count,10);
        $show=$page->show();
        $info=M('Consult')
            ->table('xueches_consult s,xueches_citys c')
            ->order('ntime desc')
            ->field('s.id,s.order1,s.title,s.content,s.picurl,s.picname,s.flag,s.ntime,s.update_people,
                s.touch_count,c.cityname,c.id as cityid')
            ->where($where)
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        $this->assign('http',C('HTTP'));
        $this->assign('info',$info);
        $this->assign('page',$show);
        $this->assign('firstRow',$page->firstRow);
        $add = M('AuthRule')->where("pid = ".I('pid'))->find();//添加资讯链接
        $this->assign('add',$add);
        $this->display();
    }

    public function consult(){
        if(IS_AJAX){
            $_POST['update_people']=session('admin_name');
            $_POST['ntime']=date('Y/m/d');
            if($_POST['id']){
                M('consult')->where(array('id'=>$_POST['id']))->save($_POST);
                $res=editorPic('consult','Consult_logo',$_POST['id'],'');
                $url=U('Consult/index?id='.$_POST['id']);
            }else{
                $id=M('consult')->add($_POST);
                $res=UploadPic('consult','Consult_logo',$id);
                $url=U('Consult/index');
            }
            if($res){
                $this->success(1,U('Consult/index'));
            }else{
                $this->error(0,$url);
            }
        }else{
            $citys=D('citys')->city_one(array('flag'=>1),'id,cityname',1);
            $this->assign('citys',$citys);
            $this->display();
        }
    }

    public function first_index(){
        $where = 's.flag=1 and s.cityid=c.id';
        $count=M('Consult')
            ->table('xueches_consult s,xueches_citys c')
            ->where($where)
            ->count();
        $this->assign('count',$count);
        $page=new Page($count,10);
        $show=$page->show();
        $info=M('Consult')
            ->table('xueches_consult s,xueches_citys c')
            ->order('order1')
            ->field('s.id,s.order1,s.title,s.picurl,s.picname,s.flag,s.ntime,s.update_people,
                s.touch_count,s.content,c.cityname,c.id as cityid')
            ->where($where)
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        $this->assign('http',C('HTTP'));
        $this->assign('info',$info);
        $this->assign('page',$show);
        $this->assign('firstRow',$page->firstRow);
        $this->display();
    }


    public function editor_consult(){
        $consult=M('Consult')->where(array('id'=>$_GET['id']))->find();
        $citys=D('citys')->city_one(array('flag'=>1),'id,cityname',1);
        $this->assign('citys',$citys);
        $this->assign('cityid',$consult['cityid']);
        $this->assign('consult',$consult);
        $this->assign('http',C('HTTP'));
        $this->assign('btn','编辑');
        $this->display('consult');
    }


    public function del_consult(){
        $id = $_GET['id'];
        $res = del_pic('consult','Consult_logo',$id);
        M('consult')->where(array('id'=>$id))->delete();
        if($res){
            $this->redirect('index','',0,"<script>alert('删除成功')</script>");
        }
    }


    public function statusUpdate(){
        $id=$_POST['id'];
        $flag=M('consult')->where(array('id'=>$id))->getField('flag');
        if($flag==1){
            $data['flag']=0;
            $data['order1']=0;
        }else{
            $data['flag']=1;
        }
        $res=M('consult')->where(array('id'=>$id))->save($data);
        if($res){
            $this->success(1);
        }else{
            $this->error(0);
        }
    }

    public function setPriority(){
        $row=M('consult')->save($_POST);
        if($row){
            $this->success('优先级更新成功');
        }
    }
}