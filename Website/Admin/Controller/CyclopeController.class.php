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
        $this->assign('get',$_GET);
        $this->display();
    }
    /*添加*/
    public function add(){
        if(IS_AJAX){
            $_POST['admin_id']=session('admin_id');//管理员id
            $_POST['ntime']=time();//添加时间
            if(empty($_FILES['image'])){
                $this->error('请上传图片');
            }else{
                $id=M('cyclope')->add($_POST);//插入数据
                if($id){
                    $src = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                        //获取文件后缀名的几种方法
    //            $ext = substr(strrchr($name,'.'),+1);
    //            $ext = substr($name,strrpos($name,'.')+1);
    //            $ext = pathinfo($name)['extension'];
    //            $ext = end(explode('.', $name));
                        $ext = pathinfo($name,PATHINFO_EXTENSION);
                        $name = md5(uniqid(microtime(true),true)).".$ext";
                        $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                        $res = M('cyclope')->where(array('id'=>$id))->save(array('picurl'=>$ret['access_url']));
                        if($res){
                            $log['done'] = '添加百科内容';
                            D('AdminLog')->logout($log);
                            $this->success('添加成功',U('cyclope/index',array('pid'=>$_POST['pid'],'p'=>$_POST['p'])));
                        }else{
                            $this->error('添加失败');
                        }
                    }
                }
        }else{
//            $ret = cloudMove('cyclope/2017-10-17/904b45b2fed9a878bf86fe099cfd0d86.jpg');
//            print_r($ret);
            $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
            $this->assign('citys',$citys_list);
            $this->assign('get',$_GET);
            $this->display();
        }
    }

    /*子内容展示*/
    public function content_index(){
        $type_id = I('id');
        $where = "a.id = c.admin_id and c.type_id = $type_id";
        foreach($_GET as $k => $v){
            if($k == 'title' && $v != ''){
                $where .= "  and c.title like '%".$_GET['title']."%' ";
            }elseif($k == 'update' && $v != ''){
                $where .= "  and a.username like '%".$_GET['update']."%'";
            }
        }
        $info = M('CyclopeContent')
            ->table('xueches_admin a,xueches_cyclope_content c')
            ->field('a.username,c.id,c.title,c.content,c.ntime,c.picurl,c.type,c.type_id')
            ->where($where)
            ->select();
        $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
        $this->assign('citys',$citys_list);
        $this->assign('info',$info);
        $res =M('cyclope')->field('id,cityid,type')->where("id = $type_id")->find();
        $this->assign('res',$res);

        $this->assign('title',$_GET['title']);
        $this->assign('update',$_GET['update']);
        $this->assign('count',count($info));
        $this->assign('get',$_GET);
        $this->assign('url',U('Admin/Cyclope/index',array('p'=>$_GET['p'],'pid'=>$_GET['pid'])));
        $this->display();
    }
    /*子内容添加*/
    public function content_add(){
        if(IS_AJAX){
            $_POST['admin_id']=session('admin_id');
            $_POST['ntime']=time();
            if(empty($_FILES['image'])){
                $this->error('请上传文件');
            }else{
                $id=M('cyclope_content')->add($_POST);
                if($id){
                    $src = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                        //获取文件后缀名的几种方法
    //            $ext = substr(strrchr($name,'.'),+1);
    //            $ext = substr($name,strrpos($name,'.')+1);
    //            $ext = pathinfo($name)['extension'];
    //            $ext = end(explode('.', $name));
                        $ext = pathinfo($name,PATHINFO_EXTENSION);
                        $name = md5(uniqid(microtime(true),true)).".$ext";
                        $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                        $res = M('CyclopeContent')->where(array('id'=>$id))->save(array('picurl'=>$ret['access_url']));
                        if($res){
                            $log['done'] = '添加百科子内容';
                            D('AdminLog')->logout($log);
                            $url = U('Admin/Cyclope/content_index?id='.$_POST['type_id'].'&pid='.$_POST['pid'].'&p='.$_POST['p']);
                            $this->success('添加成功',$url);
                        }else{
                            $this->error('添加失败');
                        }
                    }
            }
        }else{
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/Cyclope/content_index',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id'))));
            $this->display();
        }
    }
/*-------------------------------2017-10-17腾讯云存储视频图片代码---------------------------------------------*/
    public function add_video(){
        //上传文件到腾讯云
        if(IS_AJAX){
            $_POST['admin_id']=session('admin_id');//管理员id
            $_POST['ntime']=time();//添加时间
            $_POST['type'] = 1;//视频
            if(empty($_FILES['image'])||empty($_FILES['video'])){
                $this->error('请上传文件');
            }else{
                $id = M('CyclopeContent')->add($_POST);//插入数据
                if($id){
                    $src = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                    $ext = pathinfo($name,PATHINFO_EXTENSION);
                    $name = md5(uniqid(microtime(true),true)).".$ext";
                    $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                    $res = M('CyclopeContent')->where(array('id'=>$id))->save(array('picurl'=>$ret['access_url']));
                    if($res){
                        if($_FILES['video']){
                            $src = $_FILES['video']['tmp_name'];
                            $name = $_FILES['video']['name'];
                            $ext = pathinfo($name,PATHINFO_EXTENSION);
                            $name = md5(uniqid(microtime(true),true)).".$ext";
                            $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                            $res = M('CyclopeContent')->where(array('id'=>$id))->save(array('videourl'=>$ret['access_url']));
                            if($res){
                                $log['done'] = '添加百科视频';
                                D('AdminLog')->logout($log);
                                $this->success('添加成功',U('Admin/Cyclope/content_index',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id'))));
                            }else{
                                $this->error('上传失败');
                            }
                        }
                    }
                }
            }
        }else{
            print_r($_GET);
            $this->assign('url',U('Admin/Cyclope/content_index',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id'))));
            $this->assign('get',$_GET);
            $this->display();
        }
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



}