<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
class TrainClassController extends CommonController {
    //课程管理
    public function train_class(){
        $type=$_GET['type'];
        $field="tr.id,tr.name,tr.cartype,tr.way,tr.officeprice,tr.wholeprice,tr.advanceprice,
            tr.include,tr.waittime,tr.class_type,tr.type,tr.shuttle_way,tr.class_time2,
            tr.lastupdate,tr.class_time3,jztype.jztype";
        $where['_string']="tr.jztype=jztype.id and tr.type = '$type' and tr.type_id = {$_GET['id']}";
        $count=M('trainclass')->table('xueches_trainclass tr,xueches_type jztype')
            ->where($where)->count();
        $page = new \Think\Page($count,10);
        $_GET['page'] = $page->show();
        $class=M('trainclass')->table('xueches_trainclass tr,xueches_type jztype')
            ->field($field)->limit($page->firstRow.','.$page->listRows)->where($where)->select();
        $this->assign('class',$class);
        $_GET['nickname'] = M('School')->where(array('id'=>$_GET['id']))->getField('nickname');
        $this->assign('get',$_GET);
        switch($type){
            case 'jx':
                $this->assign('url',U('Admin/School/jx_list',array('pid'=>I('pid'),'p'=>I('pp'))));
                break;
            case 'jl':
                $this->assign('url',U('Admin/Coach/index_list',array('pid'=>I('pid'),'p'=>I('pp'))));
            break;
            case 'zd':
                $this->assign('url',U('Admin/Guider/index_list',array('pid'=>I('pid'),'p'=>I('pp'))));
                break;
        }
        $this->assign('count',$count);
       $this->display();
    }
    //删除课程
    public function batch_operate_del(){
        $id_arr = explode(',',I('str'));
        $count = count($id_arr);
        foreach($id_arr as $v){
            $class_name = M('trainclass')->where(array('id'=>$v))->getField('name');
            $log['done'] = "课程删除信息: => $class_name";
            M('trainclass')->delete($v);
            D('AdminLog')->logout($log);
        }
        M('School')->where(array('id'=>I('type_id')))->setDec('class_num',$count);
        $this->redirect('train_class',array('id'=>I('type_id'),'pid'=>I('pid'),'type'=>I('type'),'p'=>I('p'),'pp'=>I('pp')));
    }
    //添加课程
    public function add_class(){
        if(IS_POST){
            $data = M('trainclass')->create();
            $data['lastupdate'] = session('admin_name');
            $res = M('trainclass')->add($data);

            if($res){
                M('school')->where(array('id'=>$_POST['type_id']))->setInc('class_num',1);
                $url=U('Admin/TrainClass/train_class?id='.I('type_id').'&type='.I('type').'&p='.I('p'),'&pid='.I('pid').'&pp='.I('pp'));
                $log['done'] = "课程添加信息: => {$_POST['name']}";
                D('AdminLog')->logout($log);
                $this->success('操作成功',$url);
            }else{
                $this->error('操作失败');
            }
        }else{
            $jztype=M('type')->select();
            $this->assign('jztype',$jztype);
            $_GET['nickname'] = M('School')->where(array('id'=>I('id')))->getField('nickname');
            $this->assign('get', $_GET);
            $this->display();
        }
    }
    public function edit_class(){
        if(IS_AJAX){
            $_POST['lastupdate'] = session("admin_name");
            $class = M('trainclass')->where(array('id'=>$_POST['id']))->getField('name');
            $res=M('trainclass')->save($_POST);

            if($res){
                $url=U('Admin/TrainClass/train_class?id='.I('school_id').'&type='.I('type').'&pid='.I('pid').'&p='.I('p').'&pp='.I('pp'));
                $log['done'] = "课程信息:$class => {$_POST['name']}";
                D('AdminLog')->logout($log);
                $this->success('编辑成功',$url);
            }else{
                $this->error('编辑失败');
            }
        }else{
            $where['_string']='s.id=t.type_id';
            $where['t.id']=$_GET['id'];
            $where['t.type']=$_GET['type'];
            $data=M('school')->table('xueches_school s,xueches_trainclass t')
                ->field('s.id,s.type,s.nickname,t.id as tid,t.way,t.name,t.type_id,t.cartype,
                t.officeprice,t.wholeprice,t.class_type,t.include,t.advanceprice,t.waittime,
                t.shuttle_way,t.class_time2,t.class_time3,t.jztype,t.lastupdate')->where($where)->find();
            $jztype=M('type')->select();
            $this->assign('jztype',$jztype);
            $this->assign('data',$data);
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/TrainClass/train_class',array('id'=>$data['type_id'],'pid'=>$_GET['pid'],'p'=>I('p'),'pp'=>I('pp'),'type'=>$_GET['type'])));
            $this->display();
        }
    }
/*----------------------------------2017-11-14shenyanyan----------------------------*/
//后台客服新建订单时  在意向课程里  在文本框中输入驾校 关键词 然后匹配数据库里的数据并显示
    public function search_school(){
        $where = "type = 'jx' and nickname like '%{$_POST['search_key']}%'";
        $school = M('School')->where($where)->field('id,nickname')->select();
        $this->success($school);
    }
/*--------------------------------2017-11-14shenyanyan---------------------------*/
//通过所选的驾校的id来获取课程
    public function get_class_name(){
        $data['trainclass'] = M("trainclass")->field("id,name")->where(array('type_id'=>I('id')))->select();
        $school_base = M('train')->field("trainaddress_id")->where(array('type_id'=>I('id')))->find();
        if($school_base){
            $data['class_base'] = M("trainaddress")->field("id,trname")->where("id in ({$school_base['trainaddress_id']})")->select();
        }
        if(empty($data['class_base'])||empty($data['trainclass'])){
            $data = '';
        }
        $this->success($data);
    }
//点击课程 通过课程id得到课程的价格
    public function return_prices(){
        $data=M('trainclass')->field("id,officeprice,wholeprice,advanceprice,(wholeprice-advanceprice) as whole1")
            ->where(array('id'=>I('id')))->find();
        $this->success($data);
    }
}

