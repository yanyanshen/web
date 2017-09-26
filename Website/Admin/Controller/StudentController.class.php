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
                if($key=='p'){
                    continue;
                }elseif($key=='truename'){
                    $where.="  $key like '%".urldecode($val)."%' and";
                }elseif($key=='account' && $val != 0){
                    echo 'account';
                    $where.="  $key like'%".urlencode($val)."%' and";
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
//            $list[$k]['apply']=M('reservation')->where("masterid='$userid'")->count();
        }
        $city = M('citys')->where("flag = 1")->select();
        $this->assign('city', $city);
        $this->assign('cityid', $_GET['cityid']);
        $this->assign('truename', $_GET['truename']);
        $this->assign('account', $_GET['account']);
        $this->assign('page', $page);
        $this->assign('count', $count);
        $this->assign('list', $list);
        $this->assign('http', C('HTTP'));
        $this->display();
    }
    //删除学员
    public function del_stu($id){
        if(M('user')->delete($id)){
            $message='';
            $tt=0;
        }else{
            $message="<script>alert('删除成功')</script>";
            $tt=0.1;
        }
        $this->redirect("stu_list",'',$tt,$message);
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
            $this->success($stu);
            if($res){
                $user->commit();
                $this->success();
            }else{
                $user->rollback();
                $this->error();
            }
        }else{
            $this->display();
        }
    }
    //学员详情
    public function stu_info($id){
        if(!empty($_POST)){
            $_POST['ntime'] = time();
            $_POST['lastupdate'] = session('admin_name');
            if(M('user')->save($_POST)){
                $message="<script>alert('更新成功');</script>";
                $this->redirect('stu_list','',0.1,$message);
            }else{
                echo "<script>alert('更新失败');</script>";
            }
        }
	$field="account,truename,sex,ntime,jz_type,subject,address,cityid,verify,phone,birthday,jz_type";
        $stu=M('user')->field($field)->where("id=$id")->find();
        $city=M('citys')->where(array('flag'=>1))->field('id,cityname')->select();
        $this->assign('stu',$stu);
        $this->assign('city',$city);
        $this->assign('id',$id);
        $this->display();
    }
    //改变启用还是禁用
    public function verify($id,$flag){
        if($flag==1){
            $flag=0;
        }else{
            $flag=1;
        }
        if(M('user')->where("id=$id")->setField('verify',$flag)){
            $log['done'] = "更改用户状态";
            D('AdminLog')->logout($log);
            $message='';
            $t=0;
        }else{
            $t=0.1;
            $message="<script>alert('修改失败');</script>";
        }
        $this->redirect('stu_list','',$t,$message);
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

        $field = 'e.id,e.lastip,e.content,e.ntime,e.score,e.sid,u.truename,u.phone,e.flag';
        $evaluate = D('Evaluate')->evaluate_list($_GET,$field);
        $this->assign('evaluate',$evaluate[0]);

        $this->assign('count',$evaluate[1]);

        $no_reply = M('Evaluate')->where(array('flag'=>0))->count();
        $this->assign('no_reply',$no_reply);
        $this->assign('page',$evaluate[2]);
        $this->assign('firstRow',$evaluate[3]);
        $this->display();
    }
/*
 * User：沈艳艳
 * Date：2017/08/30
 * 客服回复
 */
    public function evaluate_reply(){
        if(IS_AJAX){
            $_POST['ntime'] = date('Y-m-d');
            $_POST['lastupdate'] = session("admin_name");
            $_POST['content'] = filter_string($_POST['content']);
            $last_id = M('EvaluateReply')->add($_POST);
            if($last_id){
                M('evaluate')->where(array('id'=>$_POST['eid']))->save(array('flag'=>1));
                $log['done'] = "【添加评价回复】{$_POST['content']}";
                D('AdminLog')->logout($log);
                $this->success(1,U('evaluate_reply',array('id'=>$_POST['eid'])));
            }else{
                $this->error();
            }
        }
        $field = 'e.id,e.content,u.truename,e.flag,e.sid,e.ntime,e.flag';
        $info = D('Evaluate')->evaluate_list($_GET,$field);
        $reply = M('EvaluateReply')->field('content,ntime,lastupdate')->order('ntime desc')->where(array('eid'=>$_GET['id']))->select();
        $this->assign('info',$info[0]);
        $this->assign('reply',$reply);
        $this->assign('id',I('id'));
        $this->display();
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
            $log['done'] = '删除评价';
            D('AdminLog')->logout($log);
            $this->redirect('evaluate_list', '', 0.1, "<script>alert('操作成功')</script>");
        }else{
                M('evaluate')->rollback();
                $this->redirect('evaluate_list','',0.1,"<script>alert('操作失败')</script>");
            }
        }
}
