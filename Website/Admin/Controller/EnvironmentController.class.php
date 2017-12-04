<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
use Think\Upload;
class EnvironmentController extends CommonController{
/*-----------------------------------2017-10-31shenyanyan---------------------------------*/
//驾校/教练/指导员简介图片
    public function abstract_pic(){
        switch(I('type')){
            case 'jx':
            //判断是简介图片还是环境图片
                if(I('t')){
                    $title = '驾校环境图片';
                }else{
                    $title = '驾校简介图片';
                }
                $url = U('Admin/School/jx_list',array('pid'=>I('pid'),'p'=>I('p')));
                break;
            case 'jl':
                if(I('t')){
                    $title = '教练环境图片';
                }else{
                    $title = '教练简介图片';
                }
                $url = U('Admin/Coach/index_list',array('pid'=>I('pid'),'p'=>I('p')));
                break;
            case 'zd':
                if(I('t')){
                    $title = '指导员环境图片';
                }else{
                    $title = '指导员简介图片';
                }
                $url = U('Admin/Guider/index_list',array('pid'=>I('pid'),'p'=>I('p')));
                break;
        }

//设置添加驾校/教练/指导员环境、简介图片
        $_GET['add_url'] = U('Admin/Environment/abstract_pic_add',array('pid'=>I('pid'),'p'=>I('p'),'id'=>I('id'),'type'=>I('type'),'t'=>I('t')));
        if(I('t')){
            $info = M("environment")->where(array('type_id'=>I('id'),'type'=>I('type')))->select();
        }else{
            $info = M("pic")->where(array('type_id'=>I('id'),'type'=>I('type')))->select();
        }
        $_GET['title'] = $title;//设置标题
        $this->assign('info',$info);
        $this->assign('count',count($info));
        $this->assign('get',$_GET);

        $this->assign('url',$url);
        $this->display();
    }

//驾校/教练/指导员简介图片添加
    public function abstract_pic_add(){
        if(IS_AJAX){
            if(empty($_FILES['image'])){
                $this->error('请选择上传文件');
            }else{
                $_POST['ntime'] = time();
                $_POST['lastupdate'] = session('admin_name');
                if(I('t')){
                    $id = M('Environment')->add($_POST);
                }else{
                    $id = M('Pic')->add($_POST);
                }
                switch(I('type')){
                    case 'jx':
                        $file = 'School_logo';
                        if(I('t')){
                            $log['done'] = '驾校环境图片添加id: => '.$id;
                        }else{
                            $log['done'] = '驾校简介图片添加id: => '.$id;
                        }
                        break;
                    case 'jl':
                        $file = 'Coach_logo';
                        if(I('t')){
                            $log['done'] = '教练环境图片添加id: => '.$id;
                        }else{
                            $log['done'] = '教练简介图片添加id: => '.$id;
                        }
                        break;
                    case 'zd':
                        $file = 'guider_logo';
                        if(I('t')){
                            $log['done'] = '指导员环境图片添加id: => '.$id;
                        }else{
                            $log['done'] = '指导员简介图片添加id: => '.$id;
                        }
                        break;
                }
                if(I('t')){
                    $res=UploadPic('Environment',$file,$id);
                }else{
                    $res=UploadPic('Pic',$file,$id);
                }
                if($res){
                    D('AdminLog')->logout($log);
                    $this->success('添加成功', U('Admin/Environment/abstract_pic',
                        array('id'=>I('type_id'),'pid'=>I('pid'),'p'=>I('p'),'type'=>I('type'),'t'=>I('t'))));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            if(I('type') == 'jx'){
                if(I('t')){
                    $_GET['title'] = '驾校环境图片';
                }else{
                    $_GET['title'] = '驾校简介图片';
                }
            }elseif(I('type') == 'jl'){
                if(I('t')){
                    $_GET['title'] = '教练环境图片';
                }else{
                    $_GET['title'] = '教练简介图片';
                }
            }elseif(I('type') == 'zd'){
                if(I('t')){
                    $_GET['title'] = '指导员环境图片';
                }else{
                    $_GET['title'] = '指导员简介图片';
                }
            }
            $nickname = M('School')->where(array('id'=>I('id')))->getField('nickname');
            $this->assign('nickname',$nickname);
            $this->assign('url', U('Admin/Environment/abstract_pic',
                array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('id'),'type'=>I('type'),'t'=>I('t'))));
            $this->assign('get',$_GET);
            $this->display();
        }
    }

//删除驾校/教练/指导员简介图片
    public function abstract_pic_del($id,$pid,$type,$type_id,$t,$p){
        switch($type){
            case 'jx':
                $file_name = 'School_logo';
                if($t){
                    $table = 'environment';
                    $log['done'] = '驾校环境图片删除id => '.$id;
                }else{
                    $table = 'pic';
                    $log['done'] = '驾校简介图片删除id => '.$id;
                }
                break;
            case 'jl':
                $file_name = 'Coach_logo';
                if($t){
                    $table = 'environment';
                    $log['done'] = '教练环境图片删除id: => '.$id;
                }else{
                    $table = 'pic';
                    $log['done'] = '教练简介图片删除id: => '.$id;
                }
                break;
            case 'zd':
                $file_name = 'guider_logo';
                if($t){
                    $table = 'environment';
                    $log['done'] = '指导员环境图片删除id: => '.$id;
                }else{
                    $table = 'pic';
                    $log['done'] = '指导员简介图片删除id => '.$id;
                }
                break;
        }
        //更新图片信息
        $upload = new  Upload();
        $upload->rootPath="./Uploads/$file_name/";
        $info = M($table)->where("id = {$id}")->find();
        unlink($upload->rootPath . $info['picurl'] . $info['picname']);
        $res = M($table)->where("id={$id}")->delete();
        if($res){
            D('AdminLog')->logout($log);
            $this->redirect('abstract_pic',array('id'=>$type_id,'type'=>$type,'pid'=>$pid,'t'=>$t,'p'=>$p),0,"<script>alert('删除成功')</script>");
        }else{
            echo 'false';
        }
    }
}