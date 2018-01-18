<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class StudentController extends CommonController {
    public function stu_list(){
        $Dao = M("user");
        $where='';
        if(!empty($_GET)){
            foreach($_GET as $key=>$val) {
                if($key=='truename'){
                    $where.=" $key like '%".urldecode($val)."%' and";
                }elseif($key=='account' && $val != 0){
                    $where.=" $key like'%".urlencode($val)."%' and";
                }elseif($key=='cityid' && $val != 0){
                    $where.=" $key=".urlencode($val)." and";
                }
            }$where=rtrim($where,'and ');
        }
        $count = $Dao->where($where)->count();//表中总得条数
        //id，账号，性别，userid,注册时间，昵称，头像，手机号，地址，科目驾照类型，最后更新人
        $field="id,account,ntime,truename,subject,lastupdate,verify,sex";
        $p = new Page($count,12);//实例化对象 -----总条数    每页显示多少条
        $page = $p->show();//$page就是下面的数字分页
        //$list是每一页的结果
        $list = $Dao->field($field)->where($where)->limit($p->firstRow.','.$p->listRows)->select();
        foreach($list as $k=>$v){
            $list[$k]['listcount']=M('order')->where("userid='{$v["id"]}'")->count();
            $list[$k]['apply_count']=M('apply')->where("mid='{$v["id"]}'")->count();
        }
        $city = M('citys')->where("flag = 1")->select();
        $this->assign('city', $city);

        $this->assign('get', $_GET);
        $this->assign('page', $page);
        $this->assign('count', $count);
        $this->assign('list', $list);
        $this->assign('http', C('HTTP'));
        $this->display();
    }
//批量,单个删除学员
    public function batch_operate_del(){
        $id_arr = explode(',',I('str'));
        foreach($id_arr as $v){
            $user = M('User')->field('account,truename')->where(array('id'=>$v))->find();
            $log['done'] = "学员删除信息: => {$user['truename']}({$user['account']})";
            D('AdminLog')->logout($log);
            M('user')->delete($v);
        }
        $this->redirect('Admin/Student/stu_list',array('pid'=>I('pid'),'p'=>I('p')));
    }
    //添加学员
    public function add_stu(){
        if(IS_AJAX){
            $user = M('user');
            $user->startTrans();
            $stu['ntime']=time();
            $stu['phone']=$_POST['cd_tel'];
            $stu['account'] = $_POST['cd_tel'];
            $stu['truename'] = $_POST['truename'];
            $stu['pass'] = $_POST['pass'];
            $stu['sex'] = $_POST['sex'];
            $stu['lastupdate'] = session('admin_name');
            $res = $user->add($stu);
            if($res){
                $user->commit();
                $log['done'] = "学生添加信息: => {$_POST['truename']}({$_POST['cd_tel']})";
                D('AdminLog')->logout($log);
                $this->success('添加成功',U('Admin/Student/add_stu',array('pid'=>I('pid'))));
            }else{
                $user->rollback();
                $this->error('添加失败',U('Admin/Student/add_stu',array('pid'=>I('pid'))));
            }
        }else{
            $this->assign('get',$_GET);
            $this->display();
        }
    }
    //学员详情
    public function stu_info($id){
        if(!empty($_POST)){
            $_POST['ntime'] = time();
            $_POST['lastupdate'] = session('admin_name');
            $user = M('user')->where($_POST)->field('account,truename')->find();
            $log['done'] = "学员信息:{$user['truename']} => {$user['account']}";
            if(M('user')->save($_POST)){
                D('AdminLog')->logout($log);
                $this->redirect('stu_list',array('p'=>I('p'),'pid'=>I('pid')),0.1,"<script>alert('更新成功')</script>");
            }else{
                $this->redirect('stu_list',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('id')),0.1,"<script>alert('更新失败')</script>");
            }
        }else{
            $field="account,truename,sex,ntime,jz_type,subject,address,cityid,verify,phone,birthday";
            $stu=M('user')->field($field)->where("id=$id")->find();
            $city=M('citys')->where(array('flag'=>1))->field('id,cityname')->select();
            $this->assign('stu',$stu);
            $this->assign('city',$city);

            $this->assign('get',$_GET);
            $this->display();
        }
    }
    //改变启用还是禁用
    public function verify($id,$flag){
        if($flag==1){
            $log['done'] = "学员登录状态:1 => 0";
            $flag=0;
        }else{
            $log['done'] = "学员登录状态:0 => 1";
            $flag=1;
        }
        if(M('user')->where("id=$id")->setField('verify',$flag)){
            D('AdminLog')->logout($log);
            $message="<script>alert('更新失败');</script>";
            $t=0;
        }else{
            $t=0.1;
            $message="<script>alert('更新失败');</script>";
        }
        $this->redirect('stu_list',array('p'=>I('p'),'pid'=>I('pid')),$t,$message);
    }
/*
 * User：沈艳艳
 * Date：2017/08/30
 * 评价列表
 */
    public function evaluate_list(){
        if(!$_GET['create_time1']){
            $_GET['create_time1'] = date('Y-m-01', strtotime(date("Y-m-d")));
        }
        $this->assign('create_time1',$_GET['create_time1']);
        $this->assign('create_time2',$_GET['create_time2']);
        $this->assign('nickname',$_GET['nickname']);

        $field = 'id,truename,lastip,content,ntime,score,sid,flag';
        $evaluate = D('Evaluate')->evaluate_list($_GET,$field);
        $this->assign('evaluate',$evaluate[0]);

        $this->assign('count',$evaluate[1]);

        $no_reply = M('Evaluate')->where(array('flag'=>0))->count();
        $this->assign('no_reply',$no_reply);
        $this->assign('page',$evaluate[2]);
        $this->assign('firstRow',$evaluate[3]);
        $this->assign('get',$_GET);
        $this->display();
    }
/*
 * User：沈艳艳
 * Date：2017/08/30
 * 客服回复
 */
    public function evaluate_reply(){
        if(IS_AJAX){
            $_POST['ntime'] = date('Y-m-d H:i:s',time());
            $_POST['lastupdate'] = session("admin_name");
            $_POST['content'] = filter_string($_POST['content']);
            $last_id = M('EvaluateReply')->add($_POST);
            if($last_id){
                M('evaluate')->where(array('id'=>$_POST['eid']))->save(array('flag'=>1));
                $log['done'] = "【添加评价回复】{$_POST['content']}";
                D('AdminLog')->logout($log);
                $this->success('回复成功',U('evaluate_list',array('p'=>I('p'),'pid'=>I('pid'))));
            }else{
                $this->error('回复失败',U('evaluate_reply',array('id'=>$_POST['eid'],'p'=>I('p'),'pid'=>I('pid'))));
            }
        }else{
            $info = M('Evaluate')->where(array('id'=>I('id')))->find();
            $info['until'] = M('EvaluateUntil')->field('ntime,content')->where(array('eid'=>I('id')))->find();
            $info['nickname'] = M('School')->where(array('id'=>$info['sid']))->getField('nickname');
            $reply = M('EvaluateReply')->field('content,ntime,lastupdate')->order('ntime desc')->where(array('eid'=>$_GET['id']))->select();

            $this->assign('info',$info);
            $this->assign('reply',$reply);
            $this->assign('get',$_GET);
            $this->display();
        }
    }
/*
 * User：沈艳艳
 * Date：2017/08/30
 * 删除评价
 */
    public function evaluate_del(){
        $id = I('id');
        M('evaluate')->startTrans();
        $res = M('evaluate')->where(array('id'=>$id))->delete();
        if($res) {
            M('evaluate')->commit();
            M('EvaluateUntil')->where(array('eid' => $id))->delete();
            M('EvaluateReply')->where(array('eid' => $id))->delete();
            $log['done'] = '驾校评价删除id: => '.$id;
            D('AdminLog')->logout($log);
            $this->redirect('evaluate_list', array('p'=>I('p'),'pid'=>I('pid')), 0.1, "<script>alert('操作成功')</script>");
        }else{
                M('evaluate')->rollback();
                $this->redirect('evaluate_list', array('p'=>I('p'),'pid'=>I('pid')),0.1,"<script>alert('操作失败')</script>");
            }
        }
/*----------------------------------2017-10-30shenyanyan---------------------------*/
//驾校预约报名列表
    public function school_apply(){
        //消息中心
        $count = D('Order')->order_count();
        $this->assign('count',$count);

        session('admin_return',U('Admin/Student/school_apply',array('pid'=>I('pid'),'p'=>I('p'))));
        foreach($_GET as $k=>$val){
            if($k == 'create_time1' && $val != ''){
                $where .= "ntime >= '$val' and ";
            }elseif($k == 'create_time2' && $val != ''){
                $where .= "ntime <= '$val' and ";
            }elseif($k == 'truename' && $val != ''){
                $where .= "truename like '%$val%' and ";
            }elseif($k == 'lastupdate' && $val != ''){
                $where .= "lastupdate like '%$val%' and ";
            }elseif($k == 'phone' && $val != ''){
                $where .= "phone like '%$val%' and ";
            }elseif($k == 'visit_time1' && $val != ''){
                $where .= "visit_time >= '$val' and ";
            }elseif($k == 'visit_time2' && $val != ''){
                $where .= "visit_time <= '$val' and ";
            }elseif($k == 'visit' && $val == 0){
                $where .= "visit = 0 and ";
            }elseif($k == 'flag' && $val == 0){
                $where .= "flag = 0 and ";
            }elseif($k == 'mid' && $val != 0 ){
                $where .= "mid = $val and ";
            }
        }$where = rtrim($where,' and ');

        $count = M('Apply')->where($where)->count();
        $Page = new Page($count,10);
        $_GET['page'] = $Page->show();
        $_GET['firstRow'] = $Page->firstRow;
        $_GET['info'] = M('Apply')->limit($Page->firstRow.','.$Page->listRows)
            ->order('ntime desc')->field('*')->where($where)->select();
        $_GET['count'] = $count;
        $_GET['count1'] = M('Apply')->where("flag = 0")->count();
        $_GET['count2'] = M('Apply')->where("visit = 0")->count();

        $this->assign('get',$_GET);
        $this->display();
    }
//学员预约列表里的flag visit 状态改变
    public function flag_visit(){
        $type = I('type');
        $id = I('id');
        $info = M('apply')->where(array('id'=>$id))->getField($type);
        if($info == 0){
            $_POST[$type] = 1;
            $log['done'] = "学员驾校预约订单状态:{$_POST[$type]} => 1";
        }else{
            $_POST[$type] = 0;
            $log['done'] = "学员驾校预约订单状态:{$_POST[$type]} => 0";
        }
        $res = M('apply')->save($_POST);
        if($res){
            D('AdminLog')->logout($log);
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }
//学员预约处理订单页面
    public function apply_handler(){
        if(IS_AJAX){
            $_POST['visit_time'] = date('Y-m-d H:i:s',time());
            $_POST['lastupdate'] = session('admin_name');
            $res = M('Apply')->save($_POST);
            if($res){
                $log['done'] = '学员预约订单处理 ID_'.$_POST['id'];
                D('AdminLog')->logout($log);
                $this->success('操作成功',U('Admin/Student/school_apply',array('pid'=>I('pid'),'p'=>I('p'))));
            }else{
                $this->error('操作失败',U('Admin/Student/apply_handler',array('pid'=>I('pid'),'p'=>I('p'))));
            }
        }else{
            $_GET['url'] = U('Admin/Student/school_apply',array('pid'=>I('pid'),'p'=>I('p')));
            $info = M('Apply')->alias('a')->join('xueches_user u ON a.mid = u.id')
                ->field('a.truename,a.address,a.customer_inform,a.visit_time,a.lastupdate,a.sex,u.truename as user,a.phone')
                ->where(array('a.id'=>I('id')))
                ->find();
            $this->assign('get',$_GET);
            $this->assign('info',$info);
            $this->display();
        }
    }
/*---------------------2017-01-12shenyanyan-------------------*/
//添加评价功能
    public function add_evaluate(){
        if(IS_AJAX){
            $_POST['content'] = filter_string($_POST['content']);
            $_POST['ntime'] = date('Y-m-d');
            $_POST['lastip'] = I("server.REMOTE_ADDR");
            if(!$_POST['content'] || !$_POST['truename']){
                $this->error('内容或评价人不能为空');
            }else{
                $res = M('evaluate')->add($_POST);
                if($res){
                    $this->success('添加成功',U('School/jx_list',array('pid'=>I('pid'),'p'=>I('p'))));
                }else{
                    $this->error('添加失败');
                }
            }
        }else{
            $this->assign('get',$_GET);
            $this->display();
        }
    }
}
