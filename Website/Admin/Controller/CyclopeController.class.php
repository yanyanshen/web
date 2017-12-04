<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class CyclopeController extends CommonController{
    public function index(){
        $where = "";
        foreach($_GET as $k => $v){
            if($k == 'cityid' ){
                if($v){
                    $where .= "cityid = {$_GET['cityid']}";
                }
            }elseif($k == 'title'){
                if($_GET['cityid']){
                    $where .= " and title like '%".$_GET['title']."%' ";
                }else{
                    $where .= " title like '%".$_GET['title']."%' ";
                }
            }elseif($k == 'type'){
                if($v){
                    $where .= " and type = {$_GET['type']}";
                }
            }
        }
        $count = M('cyclope')->where($where)->count();
        $page = new Page($count,7);
        $info = M('cyclope')->where($where)->order('set_header desc,ntime desc')
            ->limit($page->firstRow.','.$page->listRows)->select();
        $show = $page->show();
        $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
        foreach($info as $k=>$v){
            $info[$k]['update'] = M('admin')->where("id=".$v['admin_id'])->getField('username');
        }
        $this->assign('citys',$citys_list);
        $this->assign('info',$info);
        $this->assign('firstRow',$page->firstRow);
        $this->assign('page',$show);
        $this->assign('count',$count);
        $this->assign('get',$_GET);
        $this->display();
    }
    /*添加*/
    public function add(){
        if(IS_AJAX){
            $_POST['admin_id']=session('admin_id');//管理员id
            $_POST['ntime']=time();//添加时间
            if(empty($_FILES['image'])){
                $this->error('请上传图片');
            }else{
                $id=M('cyclope')->add($_POST);//插入数据
                if($id){
                    $src = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                        //获取文件后缀名的几种方法
    //            $ext = substr(strrchr($name,'.'),+1);
    //            $ext = substr($name,strrpos($name,'.')+1);
    //            $ext = pathinfo($name)['extension'];
    //            $ext = end(explode('.', $name));
                        $ext = pathinfo($name,PATHINFO_EXTENSION);
                        $name = md5(uniqid(microtime(true),true)).".$ext";
                        $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                        $res = M('cyclope')->where(array('id'=>$id))->save(array('picurl'=>$ret['access_url'],'picname'=>$name));
                        if($res){
                            $log['done'] = "百科添加: => {$_POST['title']}";
                            D('AdminLog')->logout($log);
                            $this->success('添加成功',U('cyclope/index',array('pid'=>$_POST['pid'],'p'=>$_POST['p'])));
                        }else{
                            $this->error('添加失败');
                        }
                    }
                }
        }else{
            $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
            $this->assign('citys',$citys_list);
            $this->assign('get',$_GET);
            $this->display();
        }
    }

    /*子内容展示*/
    public function content_index(){
        $type_id = I('id');
        $where = "a.id = c.admin_id and c.type_id = $type_id";
        foreach($_GET as $k => $v){
            if($k == 'title' && $v != ''){
                $where .= "  and c.title like '%".$_GET['title']."%' ";
            }elseif($k == 'update' && $v != ''){
                $where .= "  and a.username like '%".$_GET['update']."%'";
            }
        }
        $info = M('CyclopeContent')->table('xueches_admin a,xueches_cyclope_content c')
            ->field('a.username,c.id,c.title,c.content,c.ntime,c.picurl,c.type,c.type_id')
            ->where($where)->select();
        $citys_list = D('citys')->city_one("flag = 1",'id,cityname',1);
        $this->assign('citys',$citys_list);
        $this->assign('info',$info);
        $res = M('cyclope')->field('id,cityid,type')->where("id = $type_id")->find();
        $this->assign('res',$res);
        $this->assign('count',count($info));
        $this->assign('get',$_GET);
        $this->assign('url',U('Admin/Cyclope/index',array('p'=>$_GET['p'],'pid'=>$_GET['pid'])));
        $this->display();
    }
    /*子内容添加*/
    public function content_add(){
        if(IS_AJAX){
            $_POST['admin_id']=session('admin_id');
            $_POST['ntime']=time();
            $id = M('cyclope_content')->add($_POST);
            if($id){
                if(!empty($_FILES['image'])){
                    $src = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                    //获取文件后缀名的几种方法
                    //            $ext = substr(strrchr($name,'.'),+1);
                    //            $ext = substr($name,strrpos($name,'.')+1);
                    //            $ext = pathinfo($name)['extension'];
                    //            $ext = end(explode('.', $name));
                    $ext = pathinfo($name,PATHINFO_EXTENSION);
                    $name = md5(uniqid(microtime(true),true)).".$ext";
                    $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                    $res = M('CyclopeContent')->where(array('id'=>$id))->save(array('picurl'=>$ret['access_url'],'picname'=>$name));
                }else{
                    $res = 1;
                }
                if($res){
                    $log['done'] = "百科添加: => {$_POST['title']}";
                    D('AdminLog')->logout($log);
                    $url = U('Admin/Cyclope/content_index?id='.I('type_id').'&pid='.I('pid').'&p='.I('p'));
                    $this->success('添加成功',$url);
                }else{
                    $url = U('Admin/Cyclope/content_index?type_id='.I('type_id').'&pid='.I('pid').'&p='.I('p'));
                    $this->error('添加失败',$url);
                }
            }
        }else{
            $this->assign('get',$_GET);
            $this->assign('url',U('Admin/Cyclope/content_index',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id'))));
            $this->display();
        }
    }
/*-------------------------------2017-10-17腾讯云存储视频图片代码---------------------------------------------*/
    public function add_video(){
//上传文件到腾讯云
        if(IS_AJAX){
            $_POST['admin_id']=session('admin_id');//管理员id
            $_POST['ntime']=time();//添加时间
            $_POST['type'] = 1;//视频
            if(empty($_FILES['image'])||empty($_FILES['video'])){
                $this->error('请上传文件');
            }else{
                $id = M('CyclopeContent')->add($_POST);//插入数据
                if($id){
                    $src = $_FILES['image']['tmp_name'];
                    $name = $_FILES['image']['name'];
                    $ext = pathinfo($name,PATHINFO_EXTENSION);
                    $name = md5(uniqid(microtime(true),true)).".$ext";
                    $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                    $res = M('CyclopeContent')->where(array('id'=>$id))->save(array('picurl'=>$ret['access_url'],'picname'=>$name));
                    if($res){
                        if($_FILES['video']){
                            $src = $_FILES['video']['tmp_name'];
                            $name = $_FILES['video']['name'];
                            $ext = pathinfo($name,PATHINFO_EXTENSION);
                            $name = md5(uniqid(microtime(true),true)).".$ext";
                            $ret = cloudCos($src,$name,'cyclope/'.date('Y-m-d'));//存储到腾讯云上
                            $res = M('CyclopeContent')->where(array('id'=>$id))->save(array('videourl'=>$ret['access_url'],'videoname'=>$name));
                            if($res){
                                $log['done'] = "百科视频添加: => {$_POST['tile']}";
                                D('AdminLog')->logout($log);
                                $this->success('上传成功！',U('Admin/Cyclope/content_index',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id'))));
                            }else{
                                $this->error('上传失败');
                            }
                        }else{
                            $this->error('请上传视频文件');
                        }
                    }
                }
            }
        }else{
            $this->assign('url',U('Admin/Cyclope/content_index',array('p'=>I('p'),'pid'=>I('pid'),'id'=>I('type_id'))));
            $this->assign('get',$_GET);
            $this->display();
        }
    }

/*-------------------------------2017-10-19百科置顶操作shenyanyan---------------------------------------------*/
    public function set_header(){
        $set_header = M('Cyclope')->where(array('id'=>I('id')))->getField('set_header');
        if($set_header == 0){
            $log['done'] = "百科置顶设置:$set_header => 1";
            $data['set_header'] = 1;
        }else{
            $log['done'] = "百科置顶设置:$set_header => 0";
            $data['set_header'] = 0;
        }
        $res = M('Cyclope')->where(array('id'=>I('id')))->save($data);
        if($res){
            D('AdminLog')->logout($log);
            $this->redirect('index',array('pid'=>I('pid'),'p'=>I('p')),0,"<script>alert('操作成功')</script>");
        }
    }

/*-------------------------------2017-10-23百科热门资讯shenyanyan---------------------------------------------*/
    public function Hnew(){
        $set_header = M('Cyclope')->where(array('id'=>I('id')))->getField('Hnew');
        if($set_header == 0){
            $log['done'] = "热门百科设置:$set_header => 1";
            $data['Hnew'] = 1;
        }else{
            $log['done'] = "热门百科设置:$set_header => 0";
            $data['Hnew'] = 0;
        }
        $res = M('Cyclope')->where(array('id'=>I('id')))->save($data);
        if($res){
            D('AdminLog')->logout($log);
            $this->redirect('index',array('pid'=>I('pid'),'p'=>I('p')),0,"<script>alert('操作成功')</script>");
        }
    }
/*----------------------------------2017-11-02shenyanyan-----------------------------*/
//百科/教育语言删除
    function del(){
        switch(I('type')){
            case 'cyclope':
                //确认是否有子内容 然后删除
                $info = M('CyclopeContent')->where(array('type_id'=>I('id')))->select();
                if(count($info)){
                    foreach($info as $k=>$v){
                        $time = date('Y-m-d',$v['ntime']);
                        cloudMove("cyclope/$time/{$v['picname']}");
                        if($v['type']){
                            cloudMove("cyclope/$time/{$v['videoname']}");
                        }
                    }
                    M('CyclopeContent')->where(array('type_id'=>I('id')))->delete();
                }
                $info1 = M('Cyclope')->where(array('id'=>I('id')))->find();
                $time = date('Y-m-d',$info1['ntime']);
                cloudMove("cyclope/$time/{$info1['picname']}");
                $res= M('Cyclope')->where(array('id'=>I('id')))->delete();
                if($res){
                    $this->redirect('index',array('pid'=>I('pid'),'p'=>I('p'),0,"<script>alert('删除成功')</script>"));
                }else{
                    echo 'false';
                }
                break;
            case 'cyclope_content':
                $info = M('CyclopeContent')->where(array('id'=>I('id')))->find();
                $time = date('Y-m-d',$info['ntime']);
                cloudMove("cyclope/$time/{$info['picname']}");
                if($info['type']){
                    cloudMove("cyclope/$time/{$info['videoname']}");
                }
                $res = M('CyclopeContent')->where(array('id'=>I('id')))->delete();
                if($res){
                    $this->redirect('content_index',array('pid'=>I('pid'),'p'=>I('p'),'id'=>I('tid'),0,"<script>alert('删除成功')</script>"));
                }else{
                    echo 'false';
                }
                break;
            case 'language':
                //判断语言教育下的 简介图片是否存在
                $abstract = M('LanguageAbstractPic')->where(array('type_id'=>I('id')))->select();

                if(count($abstract)){
                    foreach($abstract as $k1=>$v1){
                        $time = date('Y-m-d',$v1['ntime']);
                        cloudMove("language/$time/{$v1['picname']}");
                    }
                    M('LanguageAbstractPic')->where(array('type_id'=>I('id')))->delete();
                }
                //判断语言教育下的 环境图片是否存在
                $environment = M('LanguageEnvironmentPic')->where(array('type_id'=>I('id')))->select();
                if(count($environment)){
                    foreach($environment as $k2=>$v2){
                        $time = date('Y-m-d',$v2['ntime']);
                        cloudMove("language/$time/{$v2['picname']}");
                    }
                    M('LanguageEnvironmentPic')->where(array('type_id'=>I('id')))->delete();
                }

                $info = M('Language')->where(array('id'=>I('id')))->find();
                $time = date('Y-m-d',$info['ntime']);
                cloudMove("language/$time/{$info['picname']}");
                $res= M('Language')->where(array('id'=>I('id')))->delete();
                if($res){
                    $this->redirect('Admin/Language/index',array('pid'=>I('pid'),'p'=>I('p'),0,"<script>alert('删除成功')</script>"));
                }else{
                    echo 'false';
                }
                break;
            case 'language_abstract_pic':
                $info = M('LanguageAbstractPic')->where(array('id'=>I('id')))->find();

                $time = date('Y-m-d',$info['ntime']);
                cloudMove("language/$time/{$info['picname']}");
                $res = M('LanguageAbstractPic')->where(array('id'=>I('id')))->delete();
                if($res){
                    $this->redirect('Admin/Language/abstract_pic',array('pid'=>I('pid'),'id'=>I('tid'),'type'=>I('type1'),'p'=>I('p')),0,"<script>alert('删除成功')</script>");
                }else{
                    echo 'false';
                }
                break;
            case 'language_environment_pic':
                $info = M('LanguageEnvironmentPic')->where(array('id'=>I('id')))->find();
                $time = date('Y-m-d',$info['ntime']);
                cloudMove("language/$time/{$info['picname']}");
                $res = M('LanguageEnvironmentPic')->where(array('id'=>I('id')))->delete();
                if($res){
                    $this->redirect('Admin/Language/abstract_pic',array('pid'=>I('pid'),'p'=>I('p'),'id'=>I('tid'),'type'=>I('type1')),0,"<script>alert('删除成功')</script>");
                }else{
                    echo 'false';
                }
                break;
        }
    }
}