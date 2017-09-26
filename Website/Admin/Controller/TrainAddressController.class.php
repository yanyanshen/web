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
        $page=new Page($count,10);
        $show=$page->show();
        $train_address=M('trainaddress')
            ->where($where)
            ->limit($page->firstRow.','.$page->listRows)
            ->order('time desc')
            ->select();
        $this->assign('page',$show);
        $this->assign('firstRow',$page->firstRow);
        $this->assign('train',$train_address);
        $this->display();
    }

    //添加基地   编辑
    public function add_trainaddress(){
        if(IS_AJAX){
            $_POST['time']=time();
            if($_POST['id']){
                $res=M('trainaddress')->where(array('id'=>$_POST['id']))->save($_POST);
            }else{
                $res=M('trainaddress')->add($_POST);
            }

            if($res){
                $url=U('Admin/TrainAddress/index?cityid='.$_POST['cityid']);
                $this->success($_POST,$url);
            }else{
                $this->error(0,'');
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
            $this->display();
        }
    }


    public function del_train(){
        $id=$_GET['id'];
        $cityid=$_GET['cityid'];
        $res=M('trainaddress')->where(array('id'=>$id,'cityid'=>$cityid))->delete();
        if($res){
            $this->redirect('Admin/TrainAddress/index',array('cityid'=>$cityid),0,"<script>alert('删除成功')</script> ");
        }else{
            $this->redirect('Admin/TrainAddress/index',array('cityid'=>$cityid),0,"<script>alert('失败')</script> ");
        }
    }

    public function train_Address(){
        $type=$_GET['type'];
        switch ($type){
            case 'jx':
                $url='School/jx_list?pid='.$_GET['pid'];
                break;
            case 'jl':
                $url='Coach/index_list?pid='.$_GET['pid'];
                break;
            case 'zd':
                $url='Guider/index_list?pid='.$_GET['pid'];
                break;
        }
        $where['id']=$_GET['id'];
        $where['type']=$type;
        $data=D('school')->school_list($where,"id,nickname,cityid");
        $cityname=M('citys')->where("id={$data['cityid']}")->find();
        $this->assign("cityname",$cityname['cityname']);
        $this->assign("id",$_GET['id']);
/*改驾校已经有的基地*/
        $trainid=M('train')->field("trainaddress_id")->where("type_id={$_GET['id']} ")->find()['trainaddress_id'];
        $trainArr=explode(',',$trainid);
        $this->assign("trainArr",$trainArr);
        /*驾校所在的城市的总的基地*/
        $train=M('trainaddress')->field("id,trname,address")->where("cityid={$data['cityid']}")->select();
        $this->assign("train",$train);
        $this->assign("type",$type);
        $this->assign("url",$url);
        $this->assign("pid",$_GET['pid']);
        $this->display();
    }
    //更新基地
    function trainsave(){
//        $type=$_POST['type'];
        $trainaddress_id=$_POST['trainaddress_id'];
        $strId='';
        foreach($trainaddress_id as $v){
            $strId.=$v.',';
        }
        $strId=substr($strId,0,-1);
        $_POST['trainaddress_id']=$strId;


        $where['type_id']=$_POST['type_id'];
        $data=M('train')->where($where)->field('id')->find();
        if($data){
            $res=M('train')->where(array('id'=>$data['id']))->save($_POST);
        }else{
            $res=M('train')->add($_POST);
        }
        if($res){
            $url=U('Admin/TrainAddress/train_Address?id='.$_POST['type_id'].'&type='.$_POST['type']);
            $this->success(1,$url);
        }else{
            $this->error(0);
        }
    }

}
