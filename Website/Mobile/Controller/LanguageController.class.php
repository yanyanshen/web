<?php
namespace Mobile\Controller;
use Think\Controller;
class LanguageController extends Controller{
/*------------------2017-10-26shenyanyan------------------*/
//语言教育列表
    public function language_list(){
        session('mobile_return',U('Mobile/Language/language_list'));

        $this->assign('get',$_GET);
        if (I('city')) {
            session('city', I('city'));
        }
        $city_name = session('city');
        $cityid = M('citys')->where(array('cityname'=>array('like',"%$city_name%")))->getField('id');
        $where = "cityid = $cityid";
        if(I('language_keyword')){
            session('language_keyword',I('language_keyword'));
        }else{
            session('language_keyword',null);
        }

        if(session('language_keyword')){
            $where .= " and nickname like '%".session('language_keyword')."%'";
        }

        if(IS_AJAX){
            $page = $_POST['page']?$_POST['page']:1;
            $num = 15;
            $info = M('Language')->where(session('where'))->page($page,$num)->select();
            $count = count($info);

            if ($count <= 0) {//判断是否到尾�?
                $info[]['id'] = 0;//到尾页返�?
            }
            echo json_encode($info);
            exit;//中断后面的display()
        }
        session('where',$where);
        $page = $_POST['page']?$_POST['page']:1;
        $info = M('Language')->where($where)->page($page,15)->select();
        $this->assign('info',$info);
        $this->display();
    }
//语言教育详情页
    public function language_detail(){
        $info = M('Language')->where(array('id'=>I('id')))->find();
        //语言教育评价数  、评价列表
        $info['comment_count'] = M('LanguageComment')->where(array('type_id'=>I('id')))->count();
        $info['comment'] = M('LanguageComment')->where(array('type_id'=>I('id')))->limit(0,5)->select();
        //语言教育课程查询
        $info['class'] = M('LanguageClass')->where(array('type_id'=>I('id')))->select();
        //语言教育简介图片
        $info['abstract_pic'] = M('LanguageAbstractPic')->where(array('type_id'=>I('id')))->select();
        $info['environment_pic'] = M('LanguageEnvironmentPic')->where(array('type_id'=>I('id')))->select();
        $this->assign('info',$info);
        $this->assign('get',$_GET);
        $this->assign('mobile_return',session('mobile_return'));
        $this->display();
    }
//语言教育评论页面
    public function language_comment(){
        if(IS_AJAX){
            $_POST['id'] = session('type_id');
            if(session('total')){
                $_POST['total'] = 1;
            }
            if(session('new')){
                $_POST['new'] = 1;
            }

            $info= $this->evaluate($_POST);
            $count = count($info);
            if($count <= 0){
                $info[][0] = 0;//到尾页返回0
            }
            echo json_encode($info);
            exit;

        }else{
            if(I('status') == 'total'){
                session('new',null);
                session('total',1);
                $_POST['total'] = 1;
            }elseif(I('status') == 'new'){
                session('new',1);
                session('total',null);
                $_POST['new'] = 1;
            }else{
                session('new',null);
                session('total',null);
            }
            $id = I('id');
            if($id){
                session('type_id',I('id'));
            }
            $_POST['id'] = $id;
            $info = $this->evaluate($_POST);
            //最新条数
            $date = date('Y-m-t',strtotime('-1 month'));
            $_GET['new'] = M('LanguageComment')->where(array('type_id'=>$id,"ntime > '$date'"))->count();
            //总条数
            $_GET['comment_count'] = M('LanguageComment')->where(array('type_id'=>$id))->count();
            $this->assign('info',$info);
            $this->assign('get',$_GET);
            $this->display();
        }
    }

    public function  evaluate($post){
        $where = "type_id = {$post['id']}";
        foreach($post as $k=>$v){
            if($k == 'total'){
                $where .= '';
            }elseif($k == 'new'){
                $date = date('Y-m-t',strtotime('-1 month'));
                $where .= " and ntime > '$date'";
            }
        }
        $num = 15;
        $page = $post['page']?$post['page']:1;
        $info =  M('LanguageComment')
            ->field('id,username,content,ntime,score')
            ->where($where)
            ->page($page,$num)
            ->select();//用户评价
        return $info;
    }
/*--------------------------2017-10-27shnayanyan---------------------------*/
//语言教育课程详情页面
    public function language_class_detail(){
        //课程数据查询
        $_GET['info'] = M('LanguageClass')->where(array('id'=>I('id')))->find();

        $id = M('Language')->where(array('id'=> $_GET['info']['type_id']))->getField('id');
        $_GET['url'] = U('Mobile/Language/language_detail',array('id'=>$id));//返回详情页链接
        $this->assign('get',$_GET);
        $this->display();
    }

//语言教育课程报名信息填写页面
    public function language_apply(){
        if(IS_AJAX){
            $_POST['ntime'] = date('Y-m-d H:i:s',time());
            $_POST['lastupdate'] = $_POST['truename'];
            $res = M('LanguageApply')->add($_POST);
            if($res){
                $url = U('Mobile/Language/language_detail',array('id'=>I('type_id')));
                $this->success('您好，您的信息已经提交成功，稍后会有客服与您联系！',$url);
            }else{
                $url = U('Mobile/Language/language_apply',array('id'=>I('type_id')));
                $this->error('网络差，请稍后再试！',$url);
            }
        }else{
            $_GET['nickname'] = M('Language')->where(array('id'=>I('id')))->getField('nickname');
            $this->assign('get',$_GET);
            $this->display();
        }
    }
}