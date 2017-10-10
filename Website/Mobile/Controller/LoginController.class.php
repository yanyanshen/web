<?php
namespace Mobile\Controller;
use Think\Controller;
use Think\Verify;

class LoginController extends Controller{
    public function register(){
        if(IS_AJAX){
            $data['account']=trim(I('cd_tel'));
            $data['truename']=trim(I('cd_name'));
            $data['lastupdate']=trim(I('cd_name'));
            $data['pass']=md5(trim(I('cd_passwd')));
            $data['ntime']=time();
            $citysInfo = getCity();
            $cityname = substr($citysInfo,0,9);
            $data['cityid'] = M('citys')->where(array('cityname'=>array('like',"%$cityname%")))->getField('id');
            $user = M('user');
            $id = $user->where(array('account'=>trim(I('cd_tel'))))->getField('id');
            $user->startTrans();
            if(!$id){
                $info = M('user')->add($data);
                if(!$info){
                    $user->rollback();
                    $this->error('网络忙，请稍候再试');
                }else{
                    $user->commit();
                    $log['uid'] = $info;
                    $log['done'] = '用户注册';
                    $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];;
                    D('UserLog')->add_user_log($log);
                    $this->success('注册成功',U('Mobile/Login/login'));
                }
            }else{
                $this->error('网络忙，请稍候再试',U('Mobile/Login/register'));
            }
        }else{
            $this->display();
        }
    }
/*
 * User:沈艳艳
 * Date:2017/09/27
 * 注册时验证码生成
 */

    //验证码的生成
    public function  verify(){
        $config=array(
            'fontSize' => 80,
            'length'   => 4,
            'userCurve'=>false,
//            'useNoise'=>false,
            'codeSet' => '1234567890'
        );
        $verify = new \Think\Verify($config);
        $verify->entry();
    }
/*
 * User:沈艳艳
 * Date:2017-09-28
 * 验证码验证
 */
    public function verify_check(){
        $verify = new Verify();
        $code = I('post.verify');
        if($verify->check($code,'')){
            echo 'true';
        }else{
            echo 'false';
        }
    }
    public function login(){
        if(IS_AJAX){
            $account = trim(I('username'));
            $pass = trim(I('password'));
            $where['account'] = $account;
            $where['pass'] = md5($pass);
            $info = M('user')->where($where)->find();
            if($info){
               if($info['verify'] == 1){
                    $this->error('账号被禁止',U('Mobile/Login/login'));
                }else{
                    $data['lasttime'] = time();
                    $data['lastip'] = getIp();
                    M('user')->where(array('id'=>$info['id']))->save($data);
                    session('mid',$info['id']);
                   $log['uid'] = session('mid');
                   $log['done'] = '用户登录';
                   $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                   D('UserLog')->add_user_log($log);
                    $this->success('登录成功',U('Mobile/Index/index'));
                }
            }else{
                $this->error('网络繁忙，请稍候再试！',U('Mobile/Login/login'));
            }
        }else{
            $this->display();
        }
    }
//登录时验证手机号是否存在
    public function checkPhone(){
        $account=trim(I('username'));
        $id=M('user')->where(array('account'=>$account))->getField('id');
        if(!$id){
            echo  'false';
        }else{
            echo  'true';
        }
    }
//重设密码时查看手机是否是在是用户注册的手机号
    public function chkTel(){
        $account=trim(I('username'));
        $info = M('user')->where(array('id'=>session('mid')))->getField('account');
        if($info == $account){
            echo  'true';
        }else{
            echo  'false';
        }
    }
/*
 * User：沈艳艳
 * Date：2017/08/28
 * 验证用户名是否存在
 */
    public function reg_checkName(){
        $truename = trim(I('cd_name'));
        $id = M('user')->where(array('truename'=>$truename))->getField('id');
        if(!$id){
            echo  'true';
        }else{
            echo  'false';
        }
    }
    /*
     * 注册时验证数据库里是否有该手机号*/
    public function reg_checkPhone(){
        $account=trim(I('cd_tel'));
        $id=M('user')->where(array('account'=>$account))->getField('id');
        if(!$id){
            echo  'true';
        }else{
            echo  'false';
        }
    }

    /*
    * 重置密码时  密码是否正确*/
    public function pwd_check(){
        $order_pwd = md5(trim(I('order_pwd')));
        $user = M('user');
        $pass = $user->where(array('id'=>session('mid')))->getField('pass');
        if($order_pwd == $pass){
            echo 'true';
        }else{
            echo 'false';
        }
    }

    /*
   * 重置密码代码实现*/
    public function resetPassword(){
        if(!session('mid')){
             $this->redirect('Mobile/Login/login');
        }
        $order_pwd = md5(trim(I('order_pwd')));
        $data['pass'] = md5(trim(I('new_pwd')));
        $user = M('user');
        $pass = $user->where(array('id'=>session('mid'),'pass'=>$order_pwd))->save($data);
        if($pass){
            $log['done'] = '密码重置';
            $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $log['uid'] = session('mid');
            D('UserLog')->add_user_log($log);
            session('mid',null);
            $this->success('密码重置成功');
        }else{
            if(trim(I('order_pwd')) == trim(I('new_pwd'))){
                $this->success('密码重置成功');
            }else{
                $url = U("Mobile/User/resetPassword");
                $this->error('网络忙请稍候再试',$url);
            }
        }
    }

    /*
  * 忘记密码密码重置代码实现*/
    public function forgetPassword(){
        $account = trim(I('username'));
        $data['pass'] = md5(trim(I('pass')));
        $user = M('user');
        $pass = $user->where(array('id'=>session('mid'),'account'=>$account))->getField('pass');
        $res = $user->where(array('id'=>session('mid'),'account'=>$account))->save($data);
        if($res){
            $log['done'] = '密码重置';
            $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $log['uid'] = session('mid');
            D('UserLog')->add_user_log($log);
            session('mid',null);
            $this->success('密码重置成功');
        }else{
            if($pass == md5(trim(I('pass')))){
                $this->success('密码重置成功');
            }else{
                $url = U("Mobile/User/forgetPassword");
                $this->error('网络忙请稍候再试',$url);
            }
        }
    }
}