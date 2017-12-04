<?php
namespace Mobile\Controller;
use Think\Controller;
class CyclopeController extends Controller{
    public function baike(){
        //展示百科热门话题
        $this->set_header();
        //展示百科热门资讯
        $this->Hnew();
        $this->display();
    }
/*------------------------------------2017-10-19热门话题展示shenyanyan-------------------------------------*/
    public function set_header(){
        session('mobile_return',U('Mobile/Cyclope/baike'));
        $info = M('cyclope')->where(array('set_header'=>1))->field('id,title,picurl,type')->select();
        foreach($info as $k=>$v){
            if(strlen($v['count'])>=4){
                $info[$k]['count'] = sprintf("%4",$v['count']/10000).'万';
            }
        }
        $this->assign('info',$info);
    }
/*------------------------------------2017-10-19热门话题展示shenyanyan-------------------------------------*/

/*------------------------------------2017-10-23百科热门资讯展示shenyanyan-------------------------------------*/
    public function Hnew(){
        session('mobile_return',U('Mobile/Cyclope/baike'));
        $info = M('cyclope')->where(array('Hnew'=>1))->field('id,title,picurl,type,count,ntime')->select();
        foreach($info as $k=>$v){
            if(strlen($v['count'])>=4){
                $info[$k]['count'] = sprintf("%4",$v['count']/10000).'万';
            }
        }
        $this->assign('Hnew',$info);
    }
/*------------------------------------2017-10-23百科热门资讯展示shenyanyan-------------------------------------*/

/*科目展示*/
    public function kemu(){
        $kemu = I('kemu');
        session('mobile_return',U('Mobile/Cyclope/kemu',array('kemu'=>$kemu)));
        $info = M('cyclope')->where("type = $kemu")->select();
        foreach($info as $k=>$v){
            if(strlen($v['count'])>=4){
                $info[$k]['count'] = sprintf("%4",$v['count']/10000).'万';
            }
        }
        $this->assign('info',$info);
        $this->assign('kemu',$kemu);
        $this->assign('empty',"<h1 style='font-size: 20px;text-align: center;height: 30px;padding-top: 12px'>没有查到数据</h1>");
        $this->display();
    }
    /*视频*/
    public function baike_detail(){
        $id = I('id');
        $info = M('cyclope_content')->where(array('type_id'=>$id))
            ->field('title,content,ntime,picurl,videourl,od,type')
            ->order("od desc")->select();
        M('cyclope')->where("id = $id")->setInc('count',1);
        $this->assign('info',$info);
        $this->assign('kemu',I('kemu'));
        $this->assign('mobile_return',session('mobile_return'));
        $this->assign('empty',"<h1 style='font-size: 20px;text-align: center;height: 30px;padding-top: 12px'>没有查到数据</h1>");
        $this->display();
    }
}