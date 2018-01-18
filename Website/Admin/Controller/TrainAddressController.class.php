<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class TrainAddressController extends CommonController {
    public function index(){
        if($_GET['cityid']){
            $cityid=$_GET['cityid'];
            $this->assign('cityid',$cityid);
            $where['cityid']=$cityid;
        } else{
            $citysInfo = getCity();
            $now_city = substr($citysInfo,0,9);
            $city=D('citys')->city_one(array('cityname'=>array('like',"%$now_city%")),'id,cityname');
            $where['cityid']=$city['id'];
            $this->assign('cityid',$city['id']);
        }
        $citys=D('citys')->city_one(array('flag'=>1),'id,cityname',1);
        $this->assign('citys',$citys);

        $count=M('trainaddress')->where($where)->count();
        $this->assign('count',$count);
        $page=new Page($count,20);
        $show=$page->show();
        $train_address=M('trainaddress')->where($where)->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('page',$show);
        $this->assign('firstRow',$page->firstRow);
        $this->assign('train',$train_address);
        $this->assign('get',$_GET);
        $this->display();
    }
    //添加基地   编辑
    public function add_trainaddress(){
        if(IS_AJAX){
            $trainaddress = M('trainaddress')->where(array('id'=>$_POST['id']))->find();
            $_POST['time']=time();
            if($_POST['id']){
                $log['done'] = "基地信息:{$trainaddress['trname']} => {$_POST['trname']}";
                $res=M('trainaddress')->where(array('id'=>$_POST['id']))->save($_POST);
            }else{
                $res=M('trainaddress')->add($_POST);
                $log['done'] = "基地添加: => {$trainaddress['trname']}";
            }

            if($res){
                D('AdminLog')->logout($log);
                $url=U('Admin/TrainAddress/index?cityid='.$_POST['cityid'].'&p='.I('p').'&pid='.I('pid'));
                $this->success('操作成功',$url);
            }else{
                $url=U('Admin/TrainAddress/add_trainaddress?cityid='.$_POST['cityid'].'&p='.I('p').'&pid='.I('pid').'&id='.I('id'));
                $this->error('操作失败',$url);
            }
        }else{
            if($_GET['id']){
                $this->assign('id',$_GET['id']);
                $train=M('trainaddress')->where(array('id'=>$_GET['id']))->field('id,trname,address,cityid')->find();
                $this->assign('cityid',$train['cityid']);
                $this->assign('trname',$train['trname']);
                $this->assign('address',$train['address']);
                $this->assign('btn','编辑');
            }else{
                $cityid=$_POST['cityid'];
                $this->assign('cityid',$cityid);
            }
            $citys=D('citys')->city_one(array('flag'=>1),'id,cityname',1);
            $this->assign('citys',$citys);
            $this->assign('get',$_GET);
            $this->display();
        }
    }


    public function del_train(){
        $cityid=$_GET['cityid'];
        $trname= M('trainaddress')->field('trname')->where(array('id'=>I('id'),'cityid'=>$cityid))->find();
        $res = M('trainaddress')->where(array('id'=>I('id'),'cityid'=>$cityid))->delete();
        if($res){
            $log['done'] = "基地删除: => {$trname['trname']}";
            D('AdminLog')->logout($log);
            $this->redirect('Admin/TrainAddress/index',array('cityid'=>$cityid,'p'=>I('p'),'pid'=>I('pid')),0,"<script>alert('删除成功')</script> ");
        }else{
            $this->redirect('Admin/TrainAddress/index',array('cityid'=>$cityid,'p'=>I('p'),'pid'=>I('pid')),0.1,"<script>alert('删除失败')</script> ");
        }
    }

    public function train_address(){
        $type=$_GET['type'];
        switch ($type){
            case 'jx':
                $url='School/jx_list?pid='.$_GET['pid']."&p=".$_GET['p'].'&type='.$_GET['type'];
                break;
            case 'jl':
                $url='Coach/index_list?pid='.$_GET['pid']."&p=".$_GET['p'].'&type='.$_GET['type'];
                break;
            case 'zd':
                $url='Guider/index_list?pid='.$_GET['pid']."&p=".$_GET['p'].'&type='.$_GET['type'];
                break;
        }
        $where['id']=$_GET['id'];
        $where['type']=$type;
        $data=D('school')->school_list($where,"id,nickname,cityid");
        $cityname=M('citys')->where("id={$data['cityid']}")->find();
        $this->assign("cityname",$cityname['cityname']);
/*改驾校已经有的基地*/
        $trainid=M('train')->field("trainaddress_id")->where("type_id={$_GET['id']} ")->find()['trainaddress_id'];
        $trainArr=explode(',',$trainid);
        $this->assign("trainArr",$trainArr);
        /*驾校所在的城市的总的基地*/
        $train=M('trainaddress')->field("id,trname,address")->where("cityid={$data['cityid']}")->select();
        $this->assign("train",$train);
        $this->assign("url",$url);
        $this->assign('get',$_GET);
        $this->display();
    }
//更新驾校基地
    public function trainsave(){
        $trainaddress_id=$_POST['trainaddress_id'];
        $strId='';
        foreach($trainaddress_id as $v){
            $strId.=$v.',';
        }
        $strId=substr($strId,0,-1);
        $_POST['trainaddress_id']=$strId;


        $where['type_id']=$_POST['type_id'];
        $data=M('train')->where($where)->field('trainaddress_id,id')->find();
        if($data){
            $log['done'] = "驾校/教练/指导员基地信息:{$data['trainaddress_id']} => {$_POST['trainaddress_id']}";
            $res=M('train')->where(array('id'=>$data['id']))->save($_POST);
            D('AdminLog')->logout($log);
        }else{
            $res=M('train')->add($_POST);
            $log['done'] = "驾校/教练/指导员基地信息: => {$_POST['trainaddress_id']}";
            D('AdminLog')->logout($log);
        }
        if($res){
            $url=U('Admin/TrainAddress/train_address?id='.$_POST['type_id'].'&type='.$_POST['type']."&pid=".$_POST['pid'].'&p='.$_POST['p']);
            $this->success('更新成功',$url);
        }else{
            $url=U('Admin/TrainAddress/train_address?id='.$_POST['type_id'].'&type='.$_POST['type']."&pid=".$_POST['pid'].'&p='.$_POST['p']);
            $this->error('更新失败',$url);
        }
    }

}
