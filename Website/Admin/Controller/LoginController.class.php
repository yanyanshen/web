<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Verify;
class LoginController extends Controller{
    public function login(){
        if(IS_AJAX){
            $admin=D('Admin');
            $data=$admin->create();
            $data['username']=trim(I('post.username'));
            $data['password']=md5(trim(I('post.password')));
            //判断账号密码是否一致;
            $info=$admin->where($data)->find();
            if($info){
                //判断账号状态;
                if($info['status']==1) {
                    //更新数据;
                    $info['lastlogin'] = time();
                    $info['lastip'] = I("server.REMOTE_ADDR");
                    $info['online']=1;
                    $info['login_num']= $info['login_num']+1;
                    $admin->where(array('id' => $info['id']))->field('lastlogin,lastip,online,login_num')->save($info);
                    //写入session;
                    session('admin_id', $info['id']);
                    session('admin_name', $info['username']);
                    $log['done'] = '登录';
                    D('AdminLog')->logout($log);
                    $this->success('登陆成功');
                }else{
                    $this->error('你的账号被停权');
                }
            }else{
                $this->error('密码错误');
            }
        }else {
            $this->display();
        }
    }
    //验证码的生成
    public function  verify(){
        $config=array(
            'fontSize'=>80,
            'length'  =>2,
            'useCurve'=>false,
            'useNoise'=>false,
            'codeSet' =>'123456789'
        );
        $verify=new Verify($config);
        $verify->entry();
    }
    //验证码匹配
    public function chkVerify(){
        $verify=new Verify();
        $code=I('post.verify');
        if($verify->check($code,'')){
            echo 'true';
        }else{
            echo 'false';
        }
    }
//验证登录名是否存在
    public function chkAdmin(){
        $username=trim(I('post.username'));
        $info=M('Admin')->where(array('username'=>$username))->find();
        if($info){
            echo 'true';
        }else{
            echo 'false';
        }
    }
//后台首页修改口令
    public function edit_pass(){
        $data['password'] = md5(trim(I('password')));
        $data['id'] = session('admin_id');
        if(trim(I('password'))==''){
            $this->error('密码不能为空');
        }else{
            //添加修改日志
            $log['done'] = '修改口令';
            D('AdminLog')->logout($log);
            $res = D('Admin')->edit_pass($data);
            if($res){
                session('[destroy]');
                $this->success('修改成功，请重新登录！','http://www.517xc.cn/index.php/Admin/Index/index');
            }else{
                $this->error('密码未改变');
            }
        }
    }
//退出
    public function logout(){
        $admin_id = session('admin_id');
        $log['done'] = '退出';
        D('AdminLog')->logout($log);
        M('admin')->where("id = $admin_id")->save(array('online'=>0));//变更在线状态
        session('[destroy]');   //thinkphp中清除session方法
        $this->redirect('Admin/Login/login');   //完成后跳转到相应的页
    }
}