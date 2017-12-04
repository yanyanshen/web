<?php
namespace Mobile\Controller;
use Think\Controller;
class DetailController extends Controller{
    //驾校详情页
    public function index(){
        $this->assign('mobile_return',session('mobile_return'));
        $info=M('school')->where(array('id'=>I('id')))
            ->field('id,nickname,minprice,fullname,introduction,picurl,picname,evalutioncount,phone,allcount,timing,
            address,type,age,teachage,driverage,school_id')->find();
       if(I('type') !='jx'){
           $info['school_id']=M('school')->where(array('id'=>$info['school_id']))->getField('nickname');
       }
        if(strlen($info['allcount'])>=5){
            $info['allcount']=sprintf("%.1f",$info['allcount']/10000).'万';
        }
        $this->assign('info',$info);//驾校

        $class=M('trainclass')->where(array('type_id'=>I('id')))->select();
        $this->assign('class',$class);//驾校课程

        $abstract_pic=M('Pic')->field('picurl,picname,type')->where(array('type_id'=>I('id'),'type'=>I('type')))->select();
        $this->assign('abstract_pic',$abstract_pic);//驾校简介图片

        $picinfo=M('environment')->field('id,picurl,picname,type')->where(array('type_id'=>I('id'),'type'=>$info['type']))->select();
        $this->assign('picinfo',$picinfo);//驾校环境图片
//评价展示
        $evaluate = D('Evaluate')->index(I('id'),5);
        $this->assign('evaluate',$evaluate);
        $this->assign('evaluate_count',count($evaluate));

        $this->assign('http',C('HTTP'));
        $this->assign('empty',"<h1 style='font-size: 20px;text-align: center;height: 30px;padding-top: 12px'>没有查到数据</h1>");
        $this->display();
    }

    //课程详情页
    public function course_details(){
        $cid=I('id');
        $info=M('trainclass')->where(array('id'=>$cid))->find();
        $info['jztype']=M('type')->where(array('id'=>$info['jztype']))->getField('jztype');
        $this->assign('info',$info);

        $this->display();
    }

/*
 * User：沈艳艳
 * Date：2017-09-12
 * 评论页面
 */
    public function evaluate(){
        if(IS_AJAX){
            $_POST['id'] = session('sid');
            if(session('total')){
                $_POST['total'] = 1;
            }
            if(session('new')){
                $_POST['new'] = 1;
            }
            if(session('until')){
                $_POST['until'] = 1;
            }
            $evaluate= D('Evaluate')->evaluate($_POST);
            $count = count($evaluate);
            if($count < 0){
                $evaluate[][0] = 0;//到尾页返回0
            }else{
                echo json_encode($evaluate);
            }
        }else{
            if(I('status') == 'total'){
                session('new',null);
                session('until',null);
                session('total',1);
                $_POST['total'] = 1;
            }elseif(I('status') == 'new'){
                session('new',1);
                session('total',null);
                session('until',null);
                $_POST['new'] = 1;
            }elseif(I('status') == 'until'){
                session('new',null);
                session('total',null);
                session('until',1);
                $_POST['until'] = 1;
            }else{
                session('new',null);
                session('total',null);
                session('until',null);
            }
            $id = I('id');
            if($id){
                session('sid',I('id'));
            }
            $_POST['id'] = $id;
            $evaluate= D('Evaluate')->evaluate($_POST);
            $this->assign('evaluate',$evaluate);
            $date = date('Y-m-t',strtotime('-1 month'));
            $total = M('evaluate')->where(array('sid'=>$id))->count();
            $new = M('evaluate')->where(array('sid'=>$id,"ntime > '$date'"))->count();
            $until = M('evaluate')->alias('e')->join('xueches_evaluate_until ep ON e.id = ep.eid')
                ->where("e.sid = $id and e.append = 1")->count();
            $this->assign('total',$total);
            $this->assign('until',$until);
            $this->assign('new',$new);
            $this->assign('get',$_GET);
            $this->assign('empty',"<h1 style='font-size: 20px;text-align: center;height: 30px;padding-top: 12px'>没有查到数据</h1>");
            $this->display();
        }
    }
}