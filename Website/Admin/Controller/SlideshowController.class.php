<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
use Admin\Common\Controller\CommonController;
class SlideshowController extends CommonController{
    //驾考环境
    public function index(){
        $data = D('Slideshow')->slideshow_list('','*',1,'list_flag desc');
        $this->assign('http',C('HTTP'));
        $this->assign('info',$data);
        $this->assign('get',$_GET);
        $this->display();
    }

    //添加图片

    public function add_slide(){
        if(IS_AJAX){
            $_POST['lastupdate'] = session('admin_name');
            $id = M('slideshow')->add($_POST);
            $res = UploadPic('slideshow','Slideshow_logo',$id);
            if($res){
                $log['done'] = '添加轮播图 ID_'.$id;
                D('AdminLog')->logout($log);
                $this->success('操作成功',U('Admin/Slideshow/index',array('pid'=>I('pid'))));
            }else{
                $this->error('操作失败',U('Admin/Slideshow/add_slide',array('pid'=>I('pid'))));
            }
        }else{
            $this->assign('get',$_GET);
            $this->display();
        }
    }
/*
 * User：沈艳艳
 * Date：2017/09/07
 * 编辑轮播图
 */
    public function edit_slide(){
        if(IS_AJAX){
            if(!$_POST['flag']){
                $_POST['flag'] = 1;
            }
            if(!$_POST['list_flag']){
                $_POST['list_flag'] = 0;
            }
            $_POST['lastupdate'] = session('admin_name');
            $info = M('slideshow')->save($_POST);
            $res = editorPic('slideshow','Slideshow_logo',$_POST['id']);
            if($info || $res){
                $log['done'] = '编辑轮播图 ID_'.$_POST['id'];
                D('AdminLog')->logout($log);
                $this->success('操作成功',U('Admin/Slideshow/index',array('pid'=>I('pid'),'p'=>I('p'))));
            }else{
                $this->success('操作失败',U('Admin/Slideshow/edit_slide',array('pid'=>I('pid'),'p'=>I('p'),'id'=>I('id'))));
            }
        }else{
            $info = M('slideshow')->where(array('id'=>$_GET['id']))->find();
            $this->assign('info',$info);
            $this->assign('http',C('HTTP'));
            $_GET['url'] = U('Admin/Slideshow/index',array('pid'=>I('pid'),'p'=>I('p')));
            $this->assign('get',$_GET);
            $this->display();
        }
    }
/*
 * User：沈艳艳
 * Date：2017/09/07
 * 删除轮播图
 */
    function del_img(){
        $id=$_GET['id'];
        $res = del_pic('slideshow','Slideshow_logo',$id);
        if($res){
            $log['done'] = '删除轮播图 ID_'.$res;
            D('AdminLog')->logout($log);
            $this->redirect('index',array('pid'=>I('pid'),'p'=>I('p')),0,"<script>alert('删除成功')</script>");
        }else{
            $this->redirect('index',array('pid'=>I('pid'),'p'=>I('p')),0,"<script>alert('删除失败')</script>");
        }
    }
/*
 * User：沈艳艳
 * Date：2017/09/07
 * 更改；轮播图的状态
 */
    public function change_status(){
        $info = M('slideshow')->where(array('id'=>$_GET['id']))->find();
        foreach($_GET as $k=>$v){
            if($k == 'flag'){
                if($info['flag'] == 1){
                    $data['flag'] = 0;
                    $log['done'] = "修改轮播图 ID_{$_GET['id']} 状态为：禁止";
                }else{
                    $data['flag'] = 1;
                    $log['done'] = "修改轮播图 ID_{$_GET['id']} 状态为：展示";
                }
            }elseif($k == 'list_flag'){
                if($info['list_flag'] == 1){
                    $data['list_flag'] = 0;
                    $log['done'] = '取消搜索页轮播图 ID_'.$_GET['id'];
                }else{
                    $data['list_flag'] = 1;
                    $log['done'] = '设置搜索页轮播图 ID_'.$_GET['id'];
                }
            }
        }
        $res = M('slideshow')->where(array('id'=>I('id')))->save($data);
        if($res){
            D('AdminLog')->logout($log);
            $massage = "<script>alert('操作成功')</script>";
        }else{
            $massage = "<script>alert('操作失败')</script>";
        }
        $this->redirect('index',array('pid'=>I('pid'),'p'=>I('p')),0,$massage);
    }







//七牛demo  上传图片  删除图片
    public function aa(){
        $config = array(
            'maxSize'    =>   5*1024*1024,
            'rootPath'   =>    './Uploads/',
            'savePath'   =>    '',
            'saveName'   =>    array('uniqid',''),
            'exts'       =>    array('jpg', 'gif', 'png', 'jpeg','mp4'),
            'autoSub'    =>    true,
            'subName'    =>    array('date','Ymd'),
        );
        $setting=C('config_qiniu');
        $Upload = new Upload($config,'Qiniu',$setting);
        //好了，然后我们就可以很简单的使用了，如下：
        $info=$Upload->upload($_FILES);  //这里是Form表单提交
//        $info = new QiniuStorage($setting);
//        $info=$info->del('20170505_590bd90108e34.jpg');//$file是图片的名字
        dump($info);
    }

    public function upload_video() {
        $setting=C('UPLOAD_SITEIMG_QINIU');

//转码是使用的队列名称。
        $pipeline = 'guronge';

//要进行转码的转码操作。
        $fops = "avthumb/flv/vb/1.25m";

//可以对转码后的文件进行使用saveas参数自定义命名，当然也可以不指定文件会默认命名并保存在当间。
        $savekey = '###';
        $fops = $fops.'|saveas/'.$savekey;

        $policy = array(
            'persistentOps' => $fops,
            'persistentPipeline' => $pipeline,
// 'persistentNotifyUrl' => U('Uploadqn/notifyurl')
        );

        $setting['driverConfig'] = array_merge($setting['driverConfig'], $policy);

        $upload = new \Think\Upload($setting);// 实例化上传类
        $upload->maxSize = 0;// 设置附件上传大小
        $upload->exts = array('mp4', 'flv', 'avi');// 设置附件上传类型
        $upload->savePath = 'video/';// 设置附件上传目录
        $info = $upload->upload();
        ob_end_clean();
        if(!$info) {// 上传错误提示错误信息
//echo $upload->getError();
            echo 'error';
        }else{// 上传成功
// var_dump($info);die;
            echo $tmp = 'http://www.scutephp.com/'.$info["Filedata"]['savepath'].$info["Filedata"]['savename'];
        }
    }


}