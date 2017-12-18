<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class SchoolController extends CommonController {
    public function jx_list(){
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
        $field = 'school.*,city.cityname,city.id as cid';
        $count = M('School')->table('xueches_school school,xueches_citys city')->where($where)->count();
        $Page=new Page($count,14);
        $show=$Page->show();
        $data = M('School')->table('xueches_school school,xueches_citys city')
            ->field($field)->where($where)->order('school.order desc')
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
    function del_school($id,$pid,$type,$p){
        //要删除的驾校
        $school_name = M('School')->where(array('id'=>$id))->getField('nickname');
        M('school')->startTrans();
        switch($type){
            case 'jx':
                $url = 'Admin/School/jx_list';
                $res = del_pic('School','School_logo',$id);
                $log['done'] = "删除驾校: => $school_name";
                break;
            case 'jl':
                $url = 'Admin/Coach/index_list';
                $res = del_pic('School','Coach_logo',$id);
                $log['done'] = "删除教练: => $school_name";
                break;
            case 'zd';
                $url = 'Admin/Guider/index_list';
                $res = del_pic('School','guider_logo',$id);
                $log['done'] = "删除指导员: => $school_name";
                break;
        }

        if($res){
            M('school')->commit();
            //删除基地
            if(M('train')->where("type_id={$id}")->find()){
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
//批量删除驾校
    public function batch_operate_del(){
        switch(I('type')){
            case 'jx':
                $url = 'Admin/School/jx_list';
                $file = 'School_logo';
                break;
            case 'jl':
                $url = 'Admin/Coach/index_list';
                $file = 'Coach_logo';
                break;
            case 'zd':
                $url = 'Admin/Guider/index_list';
                $file = 'guider_logo';
                break;
        }
        $id_arr = explode(',',I('str'));
        foreach($id_arr as $v){
            if(M('train')->where("type_id={$v}")->find()){
                M('train')->where("type_id={$v}")->delete();
            }
            //删除课程
            if(M('trainclass')->where("type_id={$v}")->find()){
                M('trainclass')->where("type_id={$v}")->delete();
            }
            //删除地标
            if(M('lands')->where("type_id={$v}")->find()){
                M('lands')->where("type_id={$v}")->delete();
            }

            $school_name = M('School')->where(array('id'=>$v))->getField('nickname');
            $log['done'] = "驾校/教练/指导员删除: => $school_name";
            D('AdminLog')->logout($log);
            del_pic("School","$file",$v);
            M('School')->where(array('id'=>$v))->delete();
        }
        $this->redirect($url,array('pid'=>I('pid'),'p'=>I('p')));
    }
//添加驾校
    function add_jx(){
        if(!empty($_POST)){
            $where['nickname']=$_POST['nickname'];
            $field='id';
            $data=D('School')->school_list($where,$field);
            if($data){
                $this->error('此驾校已存在');
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
                $log['done'] = "驾校添加: => {$_POST['nickname']}";
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
            $school_name = M('School')->where($where)->getField('nickname');
            $_POST['lastupdate'] = session('admin_name');
            D('School')->jx_editor($where,$_POST);//更新数据
            $res=editorPic('School','School_logo',$_POST['id']);
            if($res){
                $log['done'] = "驾校信息:$school_name => {$_POST['nickname']}";
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
        $where['_string']="c.id=s.cityid and s.week=1 and s.type='jx'";
        $info=M('School')->table('xueches_school s,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.type,s.order,
                s.student_num,s.coach_num,s.class_num,s.account,c.cityname')
            ->where($where)->order('s.order')->select();
        $this->assign('week_list',$info);
        $this->assign('http',C('HTTP'));
        $this->assign('count',count($info));
        $this->assign('get',$_GET);
        $this->display();
    }
//热搜驾校
    public function hot_list(){
        $where['_string']="c.id=s.cityid and s.hot=1 and s.type='jx'";
        $info=M('School')->table('xueches_school s,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,s.type,
                s.class_num,s.student_num,s.account,s.order,c.cityname,s.coach_num')
            ->where($where)->order('s.order')->select();
        $this->assign('jx_list',$info);
        $this->assign('count',count($info));
        $this->assign('http',C('HTTP'));
        $this->assign('get',$_GET);
        $this->display();
    }
//推荐驾校
    public function recommand_list(){
        $where['_string']="c.id=s.cityid and s.recommand=1 and s.type='jx'";
        $info=M('School')->table('xueches_school s,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,
                s.student_num,s.coach_num,s.class_num,s.account,s.order,s.type,c.cityname')
            ->where($where)->order('s.order')->select();
        $this->assign('jx_list',$info);
        $this->assign('http',C('HTTP'));
        $this->assign('count',count($info));
        $this->assign('get',$_GET);
        $this->display();
    }
//设置热搜驾校的优先级
    public function setPriority(){
        if(IS_AJAX){
            $nav=D('School');
            $data=$nav->create();
            $order = M('School')->where(array('id'=>$data['id']))->getField('order');
            if($data){
                $row=$nav->setPriority($data);
                if($row){
                    $log['done'] = "驾校优先级信息:$order => {$data['order']}";
                    D('AdminLog')->logout($log);
                    $this->success('优先级更新成功');
                }
            }else{
                $this->error($nav->getError());
            }
        }
    }
/*-----------------------------------2017-11-08shenyanyan----------------------------*/
//驾校、教练、指导员 展示  禁止
    public function show_forbid($id,$pid,$p){
        $info = M('School')->field('id,show_forbid,type')->where(array('id'=>$id))->find();
        if($info['type'] == 'jx'){
            $url = 'Admin/School/jx_list';
        }elseif($info['type'] == 'jl'){
            $url = 'Admin/Coach/index_list';
        }elseif($info['type'] == 'zd'){
            $url = 'Admin/Guider/index_list';
        }
        if($info['show_forbid']){
            $data['show_forbid'] = 0;
            $log['done'] = "驾校/教练/指导员状态:1 => 0";
        }else{
            $data['show_forbid'] = 1;
            $log['done'] = "驾校/教练/指导员状态:0 => 1";
        }
        $res = M('School')->where(array('id'=>$id))->save($data);
        if($res){
            D('AdminLog')->logout($log);
            $this->redirect($url,array('pid'=>$pid,'p'=>$p),0,'操作成功');
        }else{
            $this->redirect($url,array('pid'=>$pid,'p'=>$p),0,'操作失败');
        }
    }
/*----------------------------------------2017-11-09shneyanyan----------------------------------*/
//驾校、教练、指导员 热搜、特价、计时培训 状态更改
    public function status_update($id,$pid,$type,$p){
        $info = M('School')->field('id,recommand,type,hot,week,timing')->where(array('id'=>$id))->find();
        if($info['type'] == 'jx'){
            $url = 'Admin/School/jx_list';
        }elseif($info['type'] == 'jl'){
            $url = 'Admin/Coach/index_list';
        }elseif($info['type'] == 'zd'){
            $url = 'Admin/Guider/index_list';
        }

        $count = M('School')->where(array("$type"=>1))->count();
        if($type == 'week' && $count >=3){
            $this->redirect($url,array('pid'=>$pid,'p'=>$p),0.01,"<script>alert('添加数量已达到最大，取消后再来设置吧！')</script>");
        }
        if($type == 'hot' && $count >=12){
            $this->redirect($url,array('pid'=>$pid,'p'=>$p),0.01,"<script>alert('添加数量已达到最大，取消后再来设置吧！')</script>");
        }

        if($info["$type"]){
            $data["$type"]=0;
        }else{
            $data["$type"]=1;
        }
        $res = M('school')->where(array('id'=>$id))->save($data);
        if($res){
            $this->redirect($url,array('pid'=>$pid,'p'=>$p),0,'操作成功');
        }else{
            $this->redirect($url,array('pid'=>$pid,'p'=>$p),0,'操作失败');
        }
    }

/*---------------------2017-12-07shenyanyan------------------*/
//热搜、推荐、本周批量取消
    public function cancel(){
        switch(I('type')){
            case 'hot':
                $data['hot'] = 0;
                $url = 'Admin/School/hot_list';
                break;
            case 'recommand':
                $data['recommand'] = 0;
                $url = 'Admin/School/recommand_list';
                break;
            case 'week':
                $data['week'] = 0;
                $url = 'Admin/School/week_list';
                break;
            case 'coach_top':
                $data['recommand'] = 0;
                $url = 'Admin/Coach/coach_top';
                break;
            case 'guider_top':
                $data['recommand'] = 0;
                $url = 'Admin/Guider/guider_top';
                break;
        }
        $id_arr = explode(',',I('str'));
        foreach($id_arr as $v){
            M('School')->where(array('id'=>$v))->save($data);
        }
        $this->redirect($url,array('pid'=>I('pid')));
    }
}
