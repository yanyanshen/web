<?php
namespace Mobile\Controller;
use Think\Controller;
class ConsultController extends Controller{
    public function studyNew(){
        session('mobile_return',U('Mobile/Consult/studyNew'));
        $num = 4;//请求条数
        $page = $_POST['page']?$_POST['page']:1;
        $cityid = M('citys')->where(array('cityname'=>session('city')))->getField('id');
        $info = M('consult')->where(array('cityid'=>$cityid))
            ->page($page,$num)->order('flag desc')->select();
        foreach($info as $k=>$v){
            if(strlen($v['touch_count'])>=4){
                $info[$k]['touch_count']=sprintf("%.4f", $v['touch_count']/10000).'万';
            }
        }
            /*推荐*/
            if(IS_AJAX){//判断ajax请求
                $page = $_POST['page']?$_POST['page']:1;
                $num = 4;
                $info = M('consult')->where(array('cityid'=>$cityid))->page($page,$num)
                    ->order('flag desc')->select();
                foreach($info as $k=>$v){
                    if(strlen($v['touch_count'])>=4){
                        $info[$k]['touch_count']=sprintf("%.4f", $v['touch_count']/10000).'万';
                    }
                }
                $count = count($info);

                if ($count < 0) {//判断是否到尾�?
                    $info[]['id'] = 0;//到尾页返�?
                }
                echo json_encode($info);
                exit;//中断后面的display()
            }

        $this->assign('info',$info);
        $this->assign('http', C('HTTP'));
        $this->assign('empty', "<h1 style='height: 30px;background-color: #ffffff;padding-top: 10px;text-align: center;font-size: 15px'>暂无数据</h1>");
        $this->display();
    }

    //驾考资讯详情
    public function studyNew_detail(){
         M('consult')->where(array('id'=>I('id')))->setInc('touch_count',1);//浏览量加1
        $info=M('consult')->where(array('id'=>I('id')))->find();
        if(strlen($info['touch_count'])>=4){
            $info['touch_count']=sprintf("%.4f", $info['touch_count']/10000).'万';
        }
        $this->assign('info',$info);
        $this->assign('url',session('mobile_return'));
        $this->display();
    }
}