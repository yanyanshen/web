<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
use Think\Page;

class LanguageController extends CommonController{
/*---------------------------2017-10-24shenyanyan获取语言教育列表-----------------------------*/
    public function index(){
//判断是否有语言添加的权限
        $pid = I('pid');
        $add_language = D('AuthRule')->getRule($pid,'语言添加');
        $_GET['add_language'] = $add_language['name'];
//判断是否有语言编辑的权限
        $add_language = D('AuthRule')->getRule($pid,'语言编辑');
        $_GET['language_edit'] = $add_language['name'];

//判断是否有语言简介图片按钮的权限
        $add_language = D('AuthRule')->getRule($pid,'简介图片');
        $_GET['abstract_pic'] = $add_language['name'];
//判断是否有语言教育评价按钮的权限
        $add_language = D('AuthRule')->getRule($pid,'语言教育评价');
        $_GET['language_comment'] = $add_language['name'];

        $list = D('Language')->index($_GET);//使用模型获得语言列表
        $citys=M('citys')->field('id,cityname')->where("flag=1")->select();
        $this->assign('city', $citys);
        $this->assign('get',$_GET);
        $this->assign('list',$list);
        $this->display();
    }
/*-------------------------------2017-10-24语言教育添加------------------------------*/
    public function add_language(){
        if(IS_AJAX){
            $_POST['lastupdate'] = session('admin_name');
            $_POST['ntime'] = time();
            if(empty($_FILES['image'])){
                $this->error('请选择上传文件');
            }else{
                $id = D('language')->add_language($_POST);
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
                    $ret = cloudCos($src,$name,'language/'.date('Y-m-d'));//存储到腾讯云上
                    $res = M('Language')->where(array('id'=>$id))->save(array('picurl'=>$ret['access_url']));
                    if($res){
                        $this->success('添加成功',U('Admin/Language/index',array('pid'=>I('pid'),'p'=>I('p'))));
                    }else{
                        $this->error('添加失败');
                    }
                }else{
                    $this->error('语言教育已存在，请重新添加');
                }

            }
        }else{
            $city=M('citys')->field("id,cityname")->where("flag=1")->select();
            $this->assign('city',$city);
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/Language/index',array('pid'=>I('pid'),'p'=>I('p'))));
            $this->display();
        }
    }
/*
 * 语言编辑
 */
    public function language_edit(){
        if(IS_AJAX){
            $_POST['lastupdate'] = session('admin_name');
            $res = M('Language')->save($_POST);
            if($res){
                $log['done'] = '编辑语言教育';
                D('AdminLog')->logout($log);
                $this->success('编辑成功',U('Admin/Language/index',array('pid'=>I('pid'),'p'=>I('p'))));
            }else{
                $this->error('编辑失败');
            }
        }else{
            $info = M('Language')->where(array('id'=>I('id')))->find();
            $this->assign('info',$info);
            $city = M('citys')->field("id,cityname")->where("flag=1")->select();
            $this->assign('city',$city);
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/Language/index',array('pid'=>I('pid'),'p'=>I('p'))));
            $this->display();
        }
    }

//简介图片展示
    public function abstract_pic(){
        switch(I('type')){
            case '0':
                $table = 'LanguageAbstractPic';
                $title = '教育简介图片';
                break;
            case '1':
                $table = 'LanguageEnvironmentPic';
                $title = '教育环境图片';
                break;
        }
        //设置添加教育教育简介图片 和  教育环境图片的链接
        $_GET['add_url'] = U('Admin/Language/abstract_pic_add',array('pid'=>I('pid'),'p'=>I('p'),'id'=>I('id'),'type'=>I('type')));
        $_GET['title'] = $title;//设置标题
        $info = M("$table")->where(array('type_id'=>I('id')))->select();
        $this->assign('info',$info);
        $this->assign('count',count($info));
        $this->assign('get',$_GET);

        $this->assign('url',U('Admin/Language/index',array('pid'=>I('pid'),'p'=>I('p'))));
        $this->display();
    }
//简介图片添加
    public function abstract_pic_add(){
        if(IS_AJAX){
            if(empty($_FILES['image'])){
                $this->error('请选择上传文件');
            }else{
                $_POST['ntime'] = time();
                $_POST['lastupdate'] = session('admin_name');
                $src = $_FILES['image']['tmp_name'];
                $name = $_FILES['image']['name'];
                //获取文件后缀名的几种方法
                //            $ext = substr(strrchr($name,'.'),+1);
                //            $ext = substr($name,strrpos($name,'.')+1);
                //            $ext = pathinfo($name)['extension'];
                //            $ext = end(explode('.', $name));
                $ext = pathinfo($name,PATHINFO_EXTENSION);
                $name = md5(uniqid(microtime(true),true)).".$ext";
                $ret = cloudCos($src,$name,'language/'.date('Y-m-d'));//存储到腾讯云上
                $_POST['picurl'] = $ret['access_url'];
                if($_POST['type'] == 0){
                    $table = 'LanguageAbstractPic';
                }elseif(I('type') == 1){
                    $table = 'LanguageEnvironmentPic';
                }
                $res = M("$table")->add($_POST);
                if($res){
                    $log['done'] = '添加语言教育相关图片';
                    D('AdminLog')->logout($log);
                    $this->success('添加成功',
                        U('Admin/Language/abstract_pic',array('id'=>I('type_id'),'pid'=>I('pid'),'p'=>I('p'),'type'=>I('type'))));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $nickname = M('Language')->where(array('id'=>I('id')))->getField('nickname');
            $this->assign('nickname',$nickname);
            $this->assign('url',
                U('Admin/Language/abstract_pic',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('id'),'type'=>I('type'))));
            $this->assign('get',$_GET);
            $this->display();
        }
    }
/*----------------------------2017-10-25shenyanyan------------------------*/
//教育课程展示
    public function language_class(){
        $info = M('LanguageClass')->where(array('type_id'=>I('id')))->select();
        $_GET['count'] = count($info);
        $this->assign('info',$info);
        $_GET['url'] = U('Admin/Language/index',array('pid'=>I('pid'),'p'=>I('p')));//返回上一页面链接
        $_GET['add_url'] = U('Admin/Language/language_class_add',array('pid'=>I('pid'),'p'=>I('p'),'type_id'=>I('id')));//进入语言教育 课程添加页面 链接
        $_GET['nickname'] = M('Language')->where(array('id'=>I('id')))->getField('nickname');
        $this->assign('get',$_GET);
        $this->display();
    }
//教育课程添加、编辑
    function language_class_add(){
        if(IS_AJAX){
            $_POST['lastupdate'] = session('admin_name');
            if(I('id')){
                $log['done'] = '编辑语言教育课程';
                $res = M('LanguageClass')->save($_POST);
            }else{
                $log['done'] = '添加语言教育课程';
                $_POST['ntime'] = time();
                $res = M('LanguageClass')->add($_POST);
                M('Language')->where(array('id'=>I('type_id')))->setInc('class_num',1);
            }
            if($res){
                D('AdminLog')->logout($log);
                $this->success('操作成功',U('Admin/Language/language_class',array('pid'=>I('pid'),'p'=>I('p'),'id'=>I('type_id'))));
            }else{
                $this->error('操作失败',U('Admin/Language/language_class_add',array('pid'=>I('pid'),'p'=>I('p'),'type_id'=>I('type_id'))));
            }
        }else {
            if(I('id')){
                $info = M('LanguageClass')->where(array('id'=>I('id')))->find();
                $this->assign('info',$info);
            }
            $_GET['url'] = U('Admin/Language/language_class',array('pid'=>I('pid'),'p'=>I('p'),'id'=>I('type_id')));//返回课程列表的链接
            $_GET['nickname'] = M('Language')->where(array('id'=>I('type_id')))->getField('nickname');//返回课程列表的链接
            $this->assign('get', $_GET);
            $this->display();
        }
    }
//语言教育课程删除
    public function language_class_del(){
        $res = M('LanguageClass')->where(array('id'=>I('id')))->delete();
        if($res){
            $log['done'] = '删除语言教育课程';
            D('AdminLog')->logout($log);
            M('Language')->where(array('id'=>I('type_id')))->setDec('class_num',1);
            $this->redirect('Admin/Language/language_class',array('pid'=>I('pid'),'id'=>I('type_id'),'p'=>I('p')),0.1,'删除成功');
        }else{
            $this->redirect('Admin/Language/language_class',array('pid'=>I('pid'),'id'=>I('type_id'),'p'=>I('p')),0.1,'删除失败');
        }
    }
/*------------------------2017-10-26shenyanyan------------------------*/
//教育语言评价页面
    public function language_comment(){
        $id = I('id');
        $where = "type_id = $id";
        foreach($_GET as $k => $val){
            if($k == 'ntime1' && $val != ''){
                $where .= " and ntime >= '$val'";
            }elseif($k == 'ntime2' && $val != ''){
                $where .= " and ntime <= '$val'";
            }$where = ltrim($where,'and');
        }
        $count = M('LanguageComment')->where($where)->count();
        $info = M('LanguageComment')->where($where)->select();
        $_GET['nickname'] = M('Language')->where(array('id'=>I('id')))->getField('nickname');
        $_GET['url'] = U('Admin/Language/index',array('p'=>I('p'),'pid'=>I('pid')));
        $_GET['add_url'] = U('Admin/Language/language_comment_add',array('p'=>I('p'),'pid'=>I('pid'),'type_id'=>I('id')));//添加评价链接
        $_GET['count'] = count($count);
        $_GET['info'] = $info;
        $this->assign('get',$_GET);
        $this->display();
    }

//语言教育评价添加
    public function language_comment_add(){
        if(IS_AJAX){
            $_POST['ntime'] = date('Y-m-d',time());
            $_POST['lastupdate'] = session('admin_name');
            $res = M('LanguageComment')->add($_POST);
            if($res){
                $log['done'] = '语言教育评论添加';
                D('AdminLog')->logout($log);
                $this->success('添加成功',U('Admin/Language/language_comment',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id'))));
            }else{
                $this->error('添加失败',U('Admin/Language/language_comment_add',array('p'=>I('p'),'pid'=>I('pid'),'type_id'=>I('type_id'))));
            }
        }else{
            $_GET['nickname'] = M('Language')->where(array('id'=>I('type_id')))->getField('nickname');
            $_GET['url'] = U('Admin/Language/language_comment',array('id'=>I('type_id'),'p'=>I('p'),'pid'=>I('pid')));
            $this->assign('get',$_GET);
            $this->display();
        }
    }
//删除语言教育评论
    public function language_comment_del(){
        $res = M('LanguageComment')->where(array('id'=>I('id')))->delete();
        if($res){
            $this->redirect('Admin/Language/language_comment',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id')),0.1,'删除成功');
        }else{
            $this->redirect('Admin/Language/language_comment',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id')),0.1,'删除失败');
        }
    }
}