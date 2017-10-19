<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class CyclopeController extends CommonController{
    public function index(){
        $where = "";
        foreach($_GET as $k => $v){
            if($k == 'cityid'){
                if($v){
                    $where .= "cityid = {$_GET['cityid']}";
                }
            }elseif($k == 'title'){
                if($_GET['cityid']){
                    $where .= " and title like '%".$_GET['title']."%' ";
                }else{
                    $where .= " title like '%".$_GET['title']."%' ";
                }
            }elseif($k == 'type'){
                if($v){
                    $where .= " and type = {$_GET['type']}";
                }
            }
        }
        $count = M('cyclope')->where($where)->count();
        $page = new Page($count,7);
        $info = M('cyclope')
            ->where($where)
            ->order('ntime desc')
            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        $show = $page->show();
        $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
        foreach($info as $k=>$v){
            $info[$k]['update'] = M('admin')->where("id=".$v['admin_id'])->getField('username');
        }
        $this->assign('citys',$citys_list);
        $this->assign('info',$info);
        $this->assign('firstRow',$page->firstRow);
        $this->assign('page',$show);
        $this->assign('cityid',$_GET['cityid']);
        $this->assign('title',$_GET['title']);
        $this->assign('type',$_GET['type']);
        $this->assign('count',$count);
        $this->assign('http',C('HTTP'));
        $this->assign('pid',I('pid'));
        $this->display();
    }
    /*添加*/
    public function add(){
        if(I('id')){
            $id = I('id');
            $cyclope = M('cyclope')->where("id = $id")->find();
            $this->assign('cyclope',$cyclope);
            $this->assign('btn',"编辑");
        }
        if(IS_AJAX){
            if($_POST['id']){
                M('cyclope')->where(array('id'=>$_POST['id']))->save($_POST);
                $res=editorPic('Cyclope','cyclope_logo',$_POST['id'],'');
                $url=U('Admin/Cyclope/index?id='.$_POST['id']);
            }else{
                $_POST['admin_id']=session('admin_id');
                $_POST['ntime']=time();
                $id=M('cyclope')->add($_POST);
                $res=UploadPic('Cyclope','cyclope_logo',$id);
                $url=U('Admin/Cyclope/index');
            }
            if($res){
                $this->success(1,U('Admin/Cyclope/index',array('pid'=>$_POST['pid'])));
            }else{
                $this->error(0,$url);
            }
        }else{
            $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
            $this->assign('citys',$citys_list);
            $this->display();
        }
    }
/*-------------------------------2017-10-17腾讯云存储视频图片代码---------------------------------------------*/
    public function cos_save(){
        //上传文件到腾讯云
        if(!empty($_FILES)){
            $src = $_FILES['img']['tmp_name'];
            $name = $_FILES['img']['name'];
            //获取文件后缀名的几种方法
//            $ext = substr(strrchr($name,'.'),+1);
//            $ext = substr($name,strrpos($name,'.')+1);
//            $ext = pathinfo($name)['extension'];
//            $ext = end(explode('.', $name));
            $ext = pathinfo($name,PATHINFO_EXTENSION);
            $name = md5(uniqid(microtime(true),true)).".$ext";
            $api = videoOperate($src,$name);
            print_r($api);
        }
        echo "<pre>";
        $this->assign('get',$_GET);
        $this->display();
        exit;
    }
/*-------------------------------2017-10-17腾讯云存储视频图片代码---------------------------------------------*/

/*删除*/
    function del_cyclope(){
        $id = $_GET['id'];
        $type_id = $_GET['type_id'];
        if($id){
            $url = 'Admin/Cyclope/content_index?id='.I('tid').'&type='.I('type');
            del_pic('CyclopeContent','cyclope_logo',$id);
        }elseif($type_id){
//更新图片信息
            $upload = new  \Think\Upload();
            $picInfo=M('CyclopeContent')->field('picurl,picname')->where(array('type_id'=>$type_id))->select();
            $upload->rootPath="./Uploads/cyclope_logo/";
            //删除子内容图
            foreach($picInfo as $k=>$v){
                 unlink($upload->rootPath. $v['picurl'] . $v['picname']);
            }
            M('CyclopeContent')->where(array('type_id'=>$type_id))->delete();
            //删除内容图片
            del_pic('Cyclope','cyclope_logo',$type_id);
            $url = 'Admin/Cyclope/index?pid='.I('pid');
        }
        $this->redirect($url,'',0,"<script>alert('删除成功')</script>");
    }


    /*内容*/
    public function content_index(){
        $type_id = I('id');
        $type = I('type');
        $this->assign('type',$type);
        $this->assign('id',$type_id);
        $where = "a.id = c.admin_id and c.type_id = $type_id and type = $type";
            foreach($_GET as $k => $v){
                if($k == 'title' && $v != ''){
                    $where .= "  and c.title like '%".$_GET['title']."%' ";
                }elseif($k == 'update' && $v != ''){
                    $where .= "  and a.username like '%".$_GET['update']."%'";
                }
            }
        $count = M('CyclopeContent')
            ->table('xueches_admin a,xueches_cyclope_content c')
            ->where($where)
            ->count();

        $page = new Page($count,10);
        $info = M('CyclopeContent')
            ->table('xueches_admin a,xueches_cyclope_content c')
            ->field('a.username,c.id,c.title,c.content,c.ntime,c.picname,c.picname,c.type,c.picurl,c.picname,c.type_id')
            ->where($where)
            ->limit($page->firstRow.','.$page->listRows)
            ->select();

        $show = $page->show();
        $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
        $this->assign('citys',$citys_list);
        $this->assign('info',$info);

        $res =M('cyclope')->field('id,cityid,type')->where("id = $type_id")->find();
        $this->assign('res',$res);

        $this->assign('firstRow',$page->firstRow);
        $this->assign('page',$show);
        $this->assign('title',$_GET['title']);
        $this->assign('update',$_GET['update']);
        $this->assign('count',$count);
        $this->assign('http',C('HTTP'));
        $this->display();
    }
/*子内容和编辑*/
    public function content_add(){
        if(IS_AJAX){
            if($_POST['id']){
                $_POST['type_id'] = M('CyclopeContent')->where(array('id'=>$_POST['id']))->getField('type_id');
                $_POST['admin_id'] = session('admin_id');
                M('CyclopeContent')->save($_POST);
                $res = editorPic('CyclopeContent','cyclope_logo',$_POST['id'],'');
            }else{
                $_POST['admin_id']=session('admin_id');
                $_POST['ntime']=time();
                unset($_POST['id']);
                $id=M('cyclope_content')->add($_POST);
                $res=UploadPic('cyclope_content','cyclope_logo',$id);
            }
            if($res){
                $url = U('Admin/Cyclope/content_index?id='.$_POST['type_id'].'&type='.$_POST['type']);
                $this->success(1,$url);
            }else{
                $this->error(0,'');
            }
        }else{
            if(I('id')){
                $id = I('id');
                $this->assign('id',$id);
                $cyclope = M('CyclopeContent')->where(array('id'=>$id))->find();
                $this->assign('cyclope',$cyclope);
                $this->assign('btn','编辑');
                $info = M('cyclope')->field('type,cityid')->where(array('id'=>$cyclope['type_id']))->find();
            }else{
                $type_id = I('type_id');
                $this->assign('type_id',$type_id);
                $info = M('cyclope')->field('type,cityid')->where(array('id'=>$type_id))->find();
            }
            $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
            $this->assign('citys',$citys_list);
            $this->assign('info',$info);
            $this->assign('type',I('type'));
            $this->display();
        }
    }
}