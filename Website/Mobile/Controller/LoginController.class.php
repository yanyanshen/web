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
                    
                    $log['done'] = '用户注册信息: =>'.trim(I('cd_name'));
                    $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];;
                    D('UserLog')->add_user_log($log);
                    $this->success('注册成功',U('Mobile/User/user_center'));
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
            'useNoise'=>false,
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
                   $log['uid'] = $info['id'];
                   $log['done'] = '用户登录';
                   $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                   D('UserLog')->add_user_log($log);
                   $this->success('登录成功',U('Mobile/User/user_center'));
                }
            }else{
                $this->error('网络繁忙，请稍候再试！',U('Mobile/Login/login'));
            }
        }else{
            $this->display();
        }
    }
//登录时验证手机号是否已经注册    未登录时用户修改密码查询手机号是否被注册
    public function checkPhone(){
        $account=trim(I('username'));
        $id=M('user')->where(array('account'=>$account))->getField('id');
        if(!$id){
            echo  'false';
        }else{
            echo  'true';
        }
    }
/*
 * User：沈艳艳
 * Date：2017/08/28
 * 注册账户验证用户名是否已被使用
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
            $log['mid'] = session('mid');
            D('UserLog')->add_user_log($log);
            session('mid',null);
            $this->success('密码重置成功',U('Mobile/Login/login'));
        }else{
            if(trim(I('order_pwd')) == trim(I('new_pwd'))){
                $this->success('密码重置成功',U('Mobile/Login/login'));
            }else{
                $url = U("Mobile/User/resetPassword");
                $this->error('网络忙请稍候再试',$url);
            }
        }
    }

    /*
  * 未登录的时候忘记密码密码重置代码实现*/
    public function forgetPassword(){
        $account = trim(I('username'));
        $data['pass'] = md5(trim(I('pass')));
        $user = M('user');
        $pass = $user->field('id,pass')->where(array('account'=>$account))->find();
        $res = $user->where(array('account'=>$account))->save($data);
        if($res){
            $log['done'] = '密码重置';
            $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
            $log['uid'] = $pass['id'];
            D('UserLog')->add_user_log($log);
            $this->success('密码重置成功',U('Mobile/Login/login'));
        }else{
            if($pass['pass'] == md5(trim(I('pass')))){
                $this->success('密码重置成功',U('Mobile/Login/login'));
            }else{
                $url = U("Mobile/User/forgetPassword");
                $this->error('网络忙请稍候再试',$url);
            }
        }
    }
}