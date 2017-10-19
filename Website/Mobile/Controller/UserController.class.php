<?php
namespace Mobile\Controller;
use Think\Controller;
class UserController extends Controller{
    public function _empty($name){
        //把所有城市的操作解析到city方法
        echo "页面有误";
    }

    //用户中心模板渲染
    public function user_center(){
        print_r(aa());
        exit;
        $user=M('user')->where(array('id'=>session('mid')))->find();
        $this->assign('user',$user);
        $this->display();
    }

    /*@沈艳艳*/
    public function show_order(){
        $Order = M('Order');
        $orderInfo = $Order->where(array('id'=>session('mid')))->find();
        $this->assign('orderInfo',$orderInfo);
        $this->display();
    }
    //学车指南模板渲染
    public function study_guide(){
        $this->display();
    }

    //用户中心关于我们模板渲染
    public function AboutUs(){
        $this->display();
    }

    //用户中心隐私条款模板渲染
    public function privacy(){
        $this->display();
    }

    //学车指南中学车流程模板渲染
    public function xclc(){
        $this->display();
    }
    //学车指南中驾考大纲模板渲染
    public function jkdg(){
        $this->display();
    }
    //学车指南中择校指南模板渲染
    public function zxzn(){
        $this->display();
    }

    //学车指南中报名须知模板渲染
    public function bmxz(){
        $this->display();
    }

    //学车指南中学车须知模板渲染
    public function xcxz(){
        $this->display();
    }

    //学车指南中体检事项模板渲染
    public function tjsx(){
        $this->display();
    }

    //学车指南中学车费用模板渲染
    public function xcfy(){
        $this->display();
    }

    //学车指南中作弊处理模板渲染
    public function zbcl(){
        $this->display();
    }

    //学车指南中残疾人学车模板渲染
    public function cjrxc(){
        $this->display();
    }

    /*设置模板渲染*/
    public function setUp(){
        if(session('mid')){
            $this->display();
        }else{
            $this->redirect('Mobile/Login/login');
        }
    }

    /*密码重置模板渲染*/
    public function resetPassword(){
        $this->display();
    }

    /*忘记密码模板渲染*/
    public function forgetPassword(){
        $this->display();
    }

    public function request_by_curl($remote_server, $post_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $remote_server);
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'mypost=' . $post_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERAGENT, "jb51.net's CURL Example beta");
        $data = curl_exec($ch);
        curl_close($ch);

        return $data;
    }

    /*用户中心订单模板渲染  数据展示*/
    public function order_center(){
        $status = $_POST['status']?$_POST['status']:0;
        if(IS_AJAX){
            if($status == 0){
                $order_info = session('order_info');
            }else{
                $order_info = D('Order')->order_center($status);
            }
            if(!empty($order_info)){
                $order_info = json_encode($order_info);
            }else{
                $order_info = 0;
            }
            echo $order_info;
            exit;
        }else{
            $order_info = D('Order')->order_center($status);
            $this->assign('order_info',$order_info);
            session('order_info',$order_info);
        }
        $this->assign('http',C('HTTP'));
        $this->assign('empty',"<h2>暂无订单</h2>");
        $this->display();
    }
    /*用户中心订单详情模板渲染  数据展示*/
    public function order_center_details(){
        $id = I('id');
        $order_detail = D('Order')->order_center_details($id);
        $this->assign('info',$order_detail);
        $this->assign('http',C('HTTP'));
        $this->display();
    }
    /*退出*/
    public function login_out(){
        if(IS_AJAX){
            $log['done'] = '退出网站';
            $log['uid'] = session('mid');
            $log['url'] = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URL'];
            D('UserLog')->add_user_log($log);
            session('mid',null);
            echo 1;
            return false;
        }
        $this->display();
    }
/*预约报名记录 模板渲染*/
    public function order_apply(){
        $apply_info = M('apply')->where(array('mid'=>session('mid')))->select();
        $this->assign('apply_info',$apply_info);
        $this->assign('empty',"<h1>暂无数据</h1>");
        $this->display();
    }

}