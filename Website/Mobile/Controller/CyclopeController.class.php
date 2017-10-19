<?php
namespace Mobile\Controller;
use Think\Controller;
class CyclopeController extends Controller{
    public function baike(){
        //展示热门话题
        $this->set_header();
        $this->display();
    }
/*------------------------------------2017-10-19热门话题展示-------------------------------------*/
    public function set_header(){
        $info = M('cyclope')->where(array('set_header'=>1))->field('id,title,picurl,type')->select();
        $this->assign('info',$info);
    }
/*------------------------------------2017-10-19热门话题展示-------------------------------------*/
/*科目展示*/
    public function kemu(){
        $kemu = I('kemu');
        $info = M('cyclope')->where("type = $kemu")->select();
        foreach($info as $k=>$v){
            if(strlen($v['count'])>=4){
                $info[$k]['count'] = sprintf("%4",$v['count']/10000).'万';
            }
        }
        $this->assign('info',$info);
        $this->assign('kemu',$kemu);
        $this->assign('empty',"<h1>暂无内容</h1>");
        $this->display();
    }
    /*视频*/
    public function baike_detail(){
        $id = I('id');
        $info = M('cyclope_content')
            ->where(array('type_id'=>$id))
            ->field('title,content,ntime,picurl,videourl,od,type')
            ->order("od desc")
            ->select();
        M('cyclope')->where("id = $id")->setInc('count',1);
        $this->assign('info',$info);
        $this->assign('kemu',I('kemu'));
        $this->assign('empty',"<h1>暂无内容</h1>");
        $this->display();
    }
}