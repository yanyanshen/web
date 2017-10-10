<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
use Think\Page;
use Admin\Common\Controller\CommonController;
class EnvironmentController extends CommonController{
    //驾考环境
    public function index(){
        $id=$_GET['id'];
        $type=$_GET['type'];
        $where['type_id']=$id;
        $where['type']=$type;

        $nickname=D('School')->school_list(array('id'=>$id,'type'=>$type),'nickname');
        $info=D('environment')->environment_list($where,'id,picurl,picname,time',1);
        $this->assign('nickname',$nickname['nickname']);
        $this->assign('id',$id);
        $this->assign('get',$_GET);
        print_r($_GET);
        $this->assign('http',C('HTTP'));
        $this->assign('info',$info);
        $this->assign('count',count($info));
        $this->display();
    }

    //添加图片

    public function add_img(){
        $type=$_POST['type'];
        $id=I('post.id');
        session('id',$id);
        session('type',$type);
        switch($type){
            case 'jx':
                session('file_name','School_logo/Environment_logo');
                break;
            case 'jl':
                session('file_name','Coach_logo/Environment_logo');
                break;
            case 'zd':
                session('file_name','guider_logo/Environment_logo');
                break;
        }
        session('table','environment');
        if(!$type||!$id){
            $this->error(0);
        }else{
            $url=U('index',array('id'=>$id,'type'=>$type));
            $this->success(1,$url);
        }
    }


    public function uploadMulPic(){
        $data['time']=time();
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $file_name=session('file_name');
        $upload->rootPath = "./Uploads/$file_name/";
        if (!file_exists($upload->rootPath)) {
            mkdir($upload->rootPath);
        }
        $info=$upload->upload();
        if(!$info){
            $res=$upload->getError();
        }else{
            $data['picurl']=$info['file']['savepath'];
            $data['picname']=$info['file']['savename'];
            $data['type']=session('type');
            $data['type_id']=session('id');
            $res=M(session('table'))->add($data);
        }
        $message="<script>alert('上传成功')</script>";
        $this->redirect("index",array('id'=>session('id'),'type'=>session('type')),0,$message);
    }


    function del_img(){
        $type=$_GET['type'];
        $id=$_GET['id'];
        switch($type){
            case 'jx':
                $file_name='School_logo/Environment_logo';
                break;
            case 'jl':
                $file_name='Coach_logo/Environment_logo';
                break;
            case 'zd':
                $file_name='guider_logo/Environment_logo';
                break;
        }
        del_pic('environment',$file_name,$id);
        $this->assign('id',$id);
        $this->assign('type',$type);
        $this->redirect('index',array('id'=>$_GET['pid'],'type'=>$type),0,"<script>alert('删除成功')</script>");
    }
}