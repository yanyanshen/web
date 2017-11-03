<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload;
use Think\Page;
use Admin\Common\Controller\CommonController;
class SchoolController extends CommonController {
    public function jx_list(){
        $this->assign('get',$_GET);
        $where = "school.cityid=city.id and school.type='jx'";
        foreach($_GET as $k=>$v){
            if($k=='cityid' && $v != 0){
                $where.=" and school.cityid ={$_GET['cityid']} ";
            }elseif($k=='nickname' && $v != ''){
                $where.=" and school.nickname like '%".$_GET['nickname']."%' ";
            }elseif($k=='account' && $v != ''){
                $where.=" and school.account like '%".$_GET['account']."%' ";
            }
        }
//        $order = 'school.ntime desc';
        $field = 'school.*,city.cityname,city.id as cid,school.nickname,school.address,school.signature,school.score,
                school.type,school.evalutioncount,school.ntime,school.order,school.praisecount,school.allcount,school.lastupdate,
                school.coach_num,school.passedcount,school.connectteacher,school.introduction,school.picurl,student_num,
                school.picname,school.class_num,school.account,school.recommand,school.week,school.hot,school.type';
        $count = M('School')->table('xueches_school school,xueches_citys city')->where($where)->count();
        $Page=new Page($count,14);
        $show=$Page->show();
        $data = M('School')->table('xueches_school school,xueches_citys city')
            ->field($field)->where($where)
//            ->order($order)
            ->limit($Page->firstRow.','.$Page->listRows)->select();

        //城市
        $citys=M('citys')->field('id,cityname')->where("flag=1")->select();
        $this->assign('page',$show);// 赋值分页输出
        $this->assign('firstRow',$Page->firstRow);
        $this->assign('count', $count);
        $this->assign('city', $citys);
        $this->assign('jx_list', $data);
        $this->assign('http', C('HTTP'));
        $this->assign('empty', '<h1>暂无数据</h1>');
        $this->assign('get',$_GET);
        $this->display();
    }


    //删除驾校
    function del_school($id,$pid,$p,$type){
        M('school')->startTrans();
        switch($type){
            case 'jx':
                $url = 'Admin/School/jx_list';
                $res = del_pic('School','School_logo',$id);
                break;
            case 'jl':
                $url = 'Admin/Coach/index_list';
                $res = del_pic('School','Coach_logo',$id);
                break;
            case 'zd';
                $url = 'Admin/Guider/index_list';
                $res = del_pic('School','guider_logo',$id);
                break;
        }

        if($res){
            M('school')->commit();
            //删除基地
            if(M('train')->where("type_id={$id}")->select()){
                M('train')->where("type_id={$id}")->delete();
            }
            //删除课程
            if(M('trainclass')->where("type_id={$id}")->find()){
                M('trainclass')->where("type_id={$id}")->delete();
            }
            //删除地标
            if(M('lands')->where("type_id={$id}")->find()){
                M('lands')->where("type_id={$id}")->delete();
            }
            $log['done'] = '删除驾校 ID_'.$id;
            D('AdminLog')->logout($log);
            $message='删除成功';
            $tt=0;
        }else{
            M('school')->rollback();
            $message="<script>alert('删除失败')</script>";
            $tt=0.1;
        }
        $this->redirect($url,array('p'=>$p,'pid'=>$pid),$tt,$message);
    }
//添加驾校
    function add_jx(){
        if(!empty($_POST)){
            $where['nickname']=$_POST['nickname'];
            $field='id';
            $data=D('School')->school_list($where,$field);
            if($data){
                $this->error(0);
            }else{
                $where['cityname']=$_POST['cityid'];
                $city_list=D('Citys')->city_one($where);
                $_POST['cityid']=$city_list['id'];
                $_POST['ntime']=time();
                $_POST['lastupdate']=session('admin_name');
                $id=D('School')->add_jx($_POST);
            }
            $res=UploadPic('School','School_logo',$id);
            if($res){
                $log['done'] = '驾校添加 ID_'.$id;
                D('AdminLog')->logout($log);
                $this->success('添加成功',U('Admin/School/jx_list',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
            }else{
                $this->error('添加失败',U('Admin/School/add_jx',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
            }
        }else{
            $city=M('citys')->field("id,cityname")->where("flag=1")->select();
            $this->assign("city",$city);
            $this->assign("get",$_GET);
            $this->display();
        }
    }
    //对驾校进行编辑
    public function jx_editor(){
        $this->assign('get',$_GET);
        if(!empty($_POST)){
            $where['id']=$_POST['id'];
            $_POST['lastupdate']=session('admin_name');
            D('School')->jx_editor($where,$_POST);//更新数据
            $res=editorPic('School','School_logo',$_POST['id']);
            if($res){
                $log['done'] = '驾校编辑 ID_'.I('id');
                D('AdminLog')->logout($log);
                $this->success('编辑成功',U('Admin/School/jx_list?pid='.$_POST['pid'].'&p='.$_POST['p']));
            }else{
                $this->error('编辑失败',U('Admin/School/jx_editor?pid='.$_POST['pid'].'&p='.$_POST['p'].'&type='.I('type').'&id='.I('id')));
            }
        }else{
            $id=$_GET['id'];
            $where['id']=$id;
            $data=D('School')->school_list($where);
            $city=M('citys')->field("id,cityname")->where("flag=1")->select();
            $this->assign("city",$city);
            $this->assign("id",$id);
            $this->assign("jx",$data);
            $this->display();
        }
    }


    //本周驾校
    public function week_list(){
        $where['_string']='t.type_id=s.id and c.id=s.cityid';
        $where['t.week']=1;
//        $where['t.type']='jx';
        $info=M('School')->table('xueches_school s,xueches_trainclass t,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.week,s.type,
                s.class_num,s.account,t.id,t.name,t.officeprice,t.wholeprice,t.advanceprice,t.waittime,c.cityname')
            ->where($where)
            ->order('s.week')
            ->select();
        $this->assign('week_list',$info);
        $this->assign('http',C('HTTP'));
        $this->assign('count',count($info));
        $this->display();
    }


    //热搜驾校
    public function hot_list(){
        $where['_string']='t.type_id=s.id and c.id=s.cityid';
        $where['t.hot']=1;
//        $where['t.type']='jx';
        $info=M('School')->table('xueches_school s,xueches_trainclass t,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.hot,s.type,
                s.class_num,s.account,t.id,t.name,t.officeprice,t.wholeprice,t.advanceprice,t.waittime,c.cityname')
            ->where($where)
            ->order('s.hot')
            ->select();
        $this->assign('jx_list',$info);
        $this->assign('count',count($info));
        $this->assign('http',C('HTTP'));
        $this->display();
    }
//推荐驾校
    public function recommand_list(){
        $where['_string']='t.type_id=s.id and c.id=s.cityid';
        $where['t.recommand']=1;
//        $where['t.type']='jx';
        $info=M('School')->table('xueches_school s,xueches_trainclass t,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.recommand,
                s.allcount,s.class_num,s.account,t.id,t.name,t.officeprice,t.wholeprice,t.advanceprice,t.waittime,
                s.type,c.cityname')
            ->where($where)
            ->order('s.recommand')
            ->select();
        $this->assign('jx_list',$info);
        $this->assign('http',C('HTTP'));
        $this->assign('count',count($info));
        $this->display();
    }
    //设置热搜驾校的优先级
    public function setPriority(){
        if(IS_AJAX){
            $nav=D('School');
            $data=$nav->create();
            if($data){
                $row=$nav->setPriority($data);
                if($row){
                    $log['done'] = '优先级更新 ID_'.$data['id'];
                    D('AdminLog')->logout($log);
                    $this->success('优先级更新成功');
                }
            }else{
                $this->error($nav->getError());
            }
        }

    }
}
