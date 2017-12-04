<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
use Think\Page;
class ConsultController extends CommonController{
    public function index(){
        $where = "s.cityid=c.id and s.flag=0";
        $count=M('Consult')->table('xueches_consult s,xueches_citys c')->where($where)->count();
        $this->assign('count',$count);
        $page=new Page($count,10);
        $show=$page->show();
        $info=M('Consult')->table('xueches_consult s,xueches_citys c')->order('ntime desc')
            ->field('s.id,s.order1,s.title,s.content,s.picurl,s.flag,s.ntime,s.update_people,
                s.touch_count,c.cityname,c.id as cityid')->where($where)
            ->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('http',C('HTTP'));
        $this->assign('info',$info);
        $this->assign('page',$show);
        $this->assign('firstRow',$page->firstRow);

        $this->assign('get',$_GET);
        $this->display();
    }

    public function consult(){
        if(IS_AJAX){
            $_POST['update_people']=session('admin_name');
            $_POST['ntime']=date('Y-m-d H:i:s',time());
            //原来的信息
            if(I('id')){
                $consult = M('Consult')->where(array(I('id')))->find();
                $log['done'] = "驾校资讯信息:{$consult['title']} => {$_POST['title']}";
                $res = M('consult')->where(array('id'=>$_POST['id']))->save($_POST);
            }else{
                if($_FILES['image']){
                    $src = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                    $ext = pathinfo($name,PATHINFO_EXTENSION);
                    $name = md5(uniqid(microtime(true),true)).".$ext";
                    $ret = cloudCos($src,$name,'consult');//存储到腾讯云上
                    $_POST['picurl'] = $ret['access_url'];
                    $_POST['picname'] = $name;

                    $res=M('consult')->add($_POST);

                    $log['done'] = "驾校资讯信息: =>{$_POST['title']}";
                }else{
                    $this->error('请上传文件');
                }
            }
            if($res){
                D('AdminLog')->logout($log);
                $this->success('操作成功',U('Consult/index',array('pid'=>I('pid'),'p'=>I('p'))));
            }else{
                $this->error('操作失败');
            }
        }else{
            if(I('id')){
                $consult=M('Consult')->where(array('id'=>$_GET['id']))->find();
                $this->assign('consult',$consult);
                $this->assign('btn','编辑');
            }
            $this->assign('get',$_GET);
            $citys=D('citys')->city_one(array('flag'=>1),'id,cityname',1);
            $this->assign('citys',$citys);
            $this->display();
        }
    }

    public function first_index(){
        $where = 's.flag=1 and s.cityid=c.id';
        $count=M('Consult')
            ->table('xueches_consult s,xueches_citys c')->where($where)->count();
        $this->assign('count',$count);
        $page=new Page($count,10);
        $show=$page->show();
        $info=M('Consult')->table('xueches_consult s,xueches_citys c')->order('order1')
            ->field('s.id,s.order1,s.title,s.picurl,s.flag,s.ntime,s.update_people,
                s.touch_count,s.content,c.cityname,c.id as cityid')->where($where)
            ->limit($page->firstRow.','.$page->listRows)->select();
        $this->assign('http',C('HTTP'));
        $this->assign('info',$info);
        $this->assign('page',$show);
        $this->assign('get',$_GET);
        $this->assign('firstRow',$page->firstRow);
        $this->display();
    }
//删除驾校资讯
    public function del_consult(){
        $id = I('id');
        $info = M('consult')->where(array('id'=>$id))->find();
        if($info){
            $log['done'] = '驾校资讯删除: => '.$info['title'];
            cloudMove("consult/{$info['picname']}");
            $res = M('consult')->where(array('id'=>$id))->delete();
        }else{
            echo '未查到数据';
        }
        if($res){
            D('AdminLog')->logout($log);
            $this->redirect('Admin/Consult/index',array('p'=>I('p'),'pid'=>I('pid')),0,"<script>alert('删除成功')</script>");
        }else{
            echo 'false';
        }
    }


    public function statusUpdate(){
        $id=I('id');
        $flag=M('consult')->where(array('id'=>$id))->getField('flag');

        if($flag==1){
            $log['done'] = "驾校资讯首页推荐:$flag=>0";
            $data['flag']=0;
            $data['order1']=0;
        }else{
            $log['done'] = "驾校资讯首页推荐:$flag=>1";
            $data['flag']=1;
        }
        $res=M('consult')->where(array('id'=>$id))->save($data);
        $url = U('Admin/Consult/index',array('pid'=>I('pid'),'p'=>I('p')));
        if($res){
            D('AdminLog')->logout($log);
            $this->success('操作成功',$url);
        }else{
            $this->error('操作失败',$url);
        }
    }

    public function setPriority(){
        $consult = M('consult')->where(array('id'=>I('id')))->find();
        $log['done'] = "驾校资讯优先级:{$consult['order1']} => {$_POST['order1']}";
        $row=M('consult')->save($_POST);
        $url = U('Admin/Consult/first_index',array('pid'=>I('pid'),'p'=>I('p')));
        if($row){
            D('AdminLog')->logout($log);
            $this->success('优先级更新成功',$url);
        }else{
            $this->error('优先级更新失败',$url);
        }
    }
}