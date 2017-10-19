<?php
namespace Mobile\Controller;
use Think\Controller;
class CyclopeController extends Controller{
    public function baike(){
        $this->display();
    }
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
        $this->assign('http',C('http'));
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
//        print_r($info);

        $this->assign('info',$info);
        $this->assign('kemu',I('kemu'));
        $this->assign('http',C('HTTP'));
        $this->assign('empty',"<h1>暂无内容</h1>");
        $this->display();
    }
}