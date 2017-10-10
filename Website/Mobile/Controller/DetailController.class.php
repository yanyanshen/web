<?php
namespace Mobile\Controller;
use Think\Controller;
class DetailController extends Controller{
    //驾校详情页
    public function index(){
        $where['type_id']=I('id');
        $info=M('school')
            ->where(array('id'=>I('id')))
            ->field('nickname,fullname,id,introduction,picurl,picname,evalutioncount,
                phone,allcount,timing,address,type,age,teachage,driverage,school_id')
            ->find();
       if($info['type']!='jx'){
           $info['school_id']=M('school')->where(array('id'=>$info['school_id']))->getField('nickname');
       }
        if(strlen($info['allcount'])>=5){
            $info['allcount']=sprintf("%.1f",$info['allcount']/10000).'万';
        }
        $this->assign('info',$info);//驾校

        $classprice=M('trainclass')->where($where)->getField('wholeprice');
        $this->assign('classprice',$classprice);//显示的课程价格

        $class=M('trainclass')->where(array('type_id'=>I('id')))->select();
        $this->assign('class',$class);//驾校课程

        $picinfo=M('pic')->field('picurl,picname,type')->where(array('type_id'=>I('id')))->select();
        $this->assign('picinfo',$picinfo);//驾校简介图片

//评价展示
        $evaluate = D('Evaluate')->index(I('id'),5);
        $this->assign('evaluate',$evaluate);
        $this->assign('evaluate_count',count($evaluate));
        $this->assign('id',I('id'));
        $this->assign('http',C('HTTP'));
        $this->assign('empty',"<h1>暂无信息</h1>");
        $this->display();
    }

    //课程详情页
    public function course_details(){
        $cid=I('id');
        $info=M('trainclass')->where(array('id'=>$cid))->find();
        $info['jztype']=M('type')->where(array('id'=>$info['jztype']))->getField('jztype');
        $this->assign('id',$info['type_id']);
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
            $until = M('evaluate')
                ->alias('e')
                ->join('xueches_evaluate_until ep ON e.id = ep.eid')
                ->where("e.sid = $id and e.append = 1")
                ->count();
            $this->assign('total',$total);
            $this->assign('until',$until);
            $this->assign('new',$new);
            $this->assign('get',$_GET);
            $this->display();
        }
    }
}