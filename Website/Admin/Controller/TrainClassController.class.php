<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class TrainClassController extends CommonController {
    //课程管理
    function train_class(){
        $type=$_GET['type'];
       $field="tr.id,tr.name,tr.cartype,tr.way,tr.officeprice,tr.wholeprice,tr.advanceprice,tr.timing,tr.week,
            tr.include,tr.hot,tr.waittime,tr.class_type,tr.type,tr.recommand,tr.shuttle_way,tr.class_time2,
            tr.class_time3,jztype.jztype";
        $where['_string']="tr.jztype=jztype.id and tr.type = '$type' and tr.type_id = {$_GET['id']}";
        $count=M('trainclass')
            ->table('xueches_trainclass tr,xueches_type jztype')
            ->where($where)->count();
//        $page=new Page($count,4);
//        $show=$page->show();
        $class=M('trainclass')
            ->table('xueches_trainclass tr,xueches_type jztype')
            ->field($field)
            ->where($where)
//            ->limit($page->firstRow.','.$page->listRows)
            ->select();
        //        $this->assign('firstRow',$page->firstRow);
//        $this->assign('page',$show);
        $this->assign('class',$class);
        $nickname=M('School')->where(array('id'=>$_GET['id']))->getField('nickname');
        $this->assign('nickname',$nickname);
        $this->assign('get',$_GET);
        $this->assign('url',U('Admin/School/jx_list',array('pid'=>I('pid'),'p'=>I('p'))));
        $this->assign('count',$count);
       $this->display();
    }
    //删除课程
    function del_class($id,$t,$p,$iid){
//        if(M('trainclass')->delete($iid)){
//            $message='';
//            $tt=0;
//        }else{
//            $tt=0.1;
//            $message="<script>alert('删除成功')</script>";
//        }
//        $this->redirect("class_Manage",array('id'=>$id,'p'=>$p,'t'=>$t),$tt,$message);
    }
    //添加课程
    function add_class(){
        $jztype=M('type')->select();
        $this->assign('jztype',$jztype);
        $this->assign('post',$_POST);
        $this->display();
    }
    function edit_class(){
        if(IS_AJAX){
            $res=M('trainclass')->where(array('id'=>$_POST['id']))->save($_POST);
            if($res){
                $url=U('Admin/TrainClass/train_class?id='.$_POST['school_id'].'&type='.$_POST['type'].'&pid='.$_POST['pid'].'&p='.$_POST['p']);
                $this->success(1,$url);
            }else{
                $this->error(0);
            }
        }else{
            $where['_string']='s.id=t.type_id';
            $where['t.id']=$_GET['id'];
            $where['t.type']=$_GET['type'];
            $data=M('school')
                ->table('xueches_school s,xueches_trainclass t')
                ->field('s.id,s.type,s.nickname,t.id as tid,t.week,t.type_id,t.hot,t.week,t.way,t.name,
                t.recommand,t.cartype,t.officeprice,t.wholeprice,t.class_type,t.include,t.advanceprice,t.waittime,
                shuttle_way,class_time2,class_time3,jztype')
                ->where($where)
                ->find();
            $jztype=M('type')->select();
            $this->assign('jztype',$jztype);
            $this->assign('data',$data);
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/TrainClass/train_class',array('id'=>$data['type_id'],'pid'=>$_GET['pid'],'type'=>$_GET['type'])));
            $this->display();
        }
    }

    public function save_class(){
        $timing=M('School')->where(array('id'=>$_POST['type_id']))->getField('timing');
        if($timing){
            $_POST['timing']=1;
        }else{
            $_POST['timing']=0;
        }
       $res=M('trainclass')->add($_POST);
        if($res){
            M('school')->where(array('id'=>$_POST['type_id']))->setInc('class_num',1);
            $url=U('Admin/TrainClass/train_class?id='.$_POST['type_id'].'&type='.$_POST['type']);
            $this->success(1,$url);
        }else{
            $this->error(0);
        }
    }

   //课程  热搜、特价、计时培训 状态更改
    public function status_update(){
        $info=M('Trainclass')->where(array('id'=>$_POST['id']))->find();
        if($info[$_POST['btn']]){
            $data[$_POST['btn']]=0;
            $res=M('Trainclass')->where(array('id'=>$_POST['id']))->save($data);
            if(!M('Trainclass')->where(array('type_id'=>$info['type_id'],$_POST['btn']=>1))->count()){
                M('school')->where(array('id'=>$info['type_id']))->save($data);
            }
        }else{
            $data[$_POST['btn']]=1;
            $res=M('Trainclass')->where(array('id'=>$_POST['id']))->save($data);
            M('school')->where(array('id'=>$info['type_id']))->save($data);
        }
        if($res){
            $this->success(1);
        }else{
            $this->error(0);
        }

    }



}
