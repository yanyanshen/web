<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class GuiderController extends CommonController {
    function index_list(){
        $Dao = M("school");
        $where = "s.boss_id=b.id and ca.id=s.category_id and city.id=s.cityid and s.type='zd'";
        foreach($_GET as $k=>$v){
            if($k=='cityid'){
                $where.="and s.cityid ={$_GET['cityid']}";
            }elseif($k=='nickname'){
                $where.="and s.nickname like '%".$_GET['nickname']."%'";
            }elseif($k=='account'){
                $where.="and s.account like '%".$_GET['account']."%'";
            }
        }
        $count = $Dao
            ->table('xueches_boss b,xueches_school s,xueches_guider_category ca,xueches_citys city')
            ->where($where)
            ->count();
        $field="s.id,s.school_id,s.account,s.picurl,s.picname,s.sex,s.nickname,s.score,s.ntime,s.carnumber,s.class_num,
                s.serialId,s.numberId,s.address,s.cityid,s.verify,s.lastupdate,s.type,s.recommand,s.week,s.hot,s.student_num,
                ca.category_name,ca.id as caid,city.cityname,city.id as cityid";
        $p = new Page($count,10);
        $page = $p->show();
        $list = $Dao
            ->field($field)
            ->table('xueches_boss b,xueches_school s,xueches_guider_category ca,xueches_citys city')
            ->where($where)
            ->order("s.id desc")
            ->limit($p->firstRow.','.$p->listRows)
            ->select();
        //城市
        $citys=M('citys')->field('id,cityname')->where("flag=1")->select();
        $this->assign('page', $page);
        $this->assign('count', $count);
        $this->assign('city', $citys);
        $this->assign('get', $_GET);
        $this->assign('http', C('HTTP'));
        $this->assign('firstRow', $p->firstRow);
        $this->assign('list', $list);
        $this->display();
    }


    public function add_zd(){
        if(IS_AJAX){
            $school_id=M('School')->where(array('nickname'=>$_POST['school_nickname'],'type'=>'jx'))->getField('id');
            $_POST['type']='zd';
            $_POST['school_id']=$school_id;
            $_POST['time']=time();
            $id=M('school')->add($_POST);
            session('type_id',$id);
            if($id){
                $aa=M('School')->where(array('id'=>$school_id,'type'=>'zd'))->setInc('guider_num',1);
                $res=UploadPic('School','guider_logo',$id);
            }
            $this->success(1,U('Admin/Guider/index_list',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
        }else{
            $category=M('GuiderCategory')->field('id,category_name')->select();
            $this->assign('category', $category);
            $citys=M('citys')->field('id,cityname')->where("flag=1")->select();
            $this->assign('city',$citys);

            $boss=M('boss')->where(array('type'=>'zd'))->field('id,boss_name')->select();
            $this->assign('boss',$boss);

            $nickname=session('nickname');
            session('nickname',null);
            $this->assign('school_nickname',$nickname);
            $this->assign('url',U('Admin/Guider/index_list',array('p'=>$_GET['p'],'pid'=>$_GET['pid'])));
            $this->assign('get',$_GET);
            $this->display();
        }

    }
    public function uploadMulPic(){
        $data['time']=time();
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = "./Uploads/guider_logo/";
        if (!file_exists($upload->rootPath)) {
            mkdir($upload->rootPath);
        }
        $info=$upload->upload();
        if(!$info){
            $res=$upload->getError();
        }else{
            $data['type_id']=session('type_id');
            $data['type']='zd';
            $data['picurl']=$info['file']['savepath'];
            $data['picname']=$info['file']['savename'];
            M('pic')->add($data);
        }
    }


    //对教练进行编辑
    public function editor_zd(){
        if(!empty($_POST)){
            $where['id']=$_POST['id'];
            $school_id=M('School')->where(array('nickname'=>$_POST['school_nickname'],'type'=>'jx'))->getField('id');
            $_POST['school_id']=$school_id;
            $_POST['ntime']=time();
            D('school')->jx_editor($where,$_POST);//更新数据
            $res=editorPic('School','guider_logo',$_POST['id'],'pic');
            if($res){
                $this->success($res,U('Admin/Guider/index_list',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
            }else{
                $this->error(0);
            }
        }else{
            $id=$_GET['id'];
            $where['id']=$id;
            $where['type']='zd';
            $data=D('school')->school_list($where);
            $school_nickname=D('School')->school_list(array('id'=>$data['school_id'],'type'=>'jx'),'nickname');
            $this->assign('school_nickname',$school_nickname['nickname']);
            $category=M('GuiderCategory')->field('id,category_name')->select();
            $this->assign('category',$category);
            $boss=M('boss')->where(array('type'=>'zd'))->field('id,boss_name')->select();
            $this->assign('boss',$boss);
            $city=M('citys')->field("id,cityname")->where("flag=1")->select();
            $this->assign("city",$city);
            $this->assign("jl",$data);
            $nickname=session('nickname');
            session('nickname',null);
            $this->assign('nickname',$nickname);
            $picInfo=M('pic')->where(array('type_id'=>$id,'type'=>'zd'))->select();
            $this->assign("picInfo",$picInfo);
            $this->assign("get",$_GET);
            $this->display();
        }
    }
/*
 * User：沈艳艳
 * Date：2017/09/04
 * 指导员分类列表
 */
    public function category_index(){
        if(IS_AJAX){
            if($_POST['category_name'] == ''){
                $this->error('分类名称不能为空');
            }
            $_POST['time']=time();
            $_POST['update_people']=session("admin_name");
            if($_POST['cid']){
                $res=M('GuiderCategory')->where(array('id'=>$_POST['cid']))->save($_POST);
            }else{
                $cid=M('GuiderCategory')->where(array('category_name'=>$_POST['category_name']))->getField('id');
                if($cid){
                    $res=M('GuiderCategory')->where(array('id'=>$cid))->save($_POST);
                }else{
                    $res=M('GuiderCategory')->add($_POST);
                }
            }
            if($res){
                $this->success('添加成功');
            }else{
                $this->error('添加失败');
            }
        }else{
            $info=M('GuiderCategory')->select();
            $this->assign('category',$info);
            $this->display();
        }
    }

/*
 * User：沈艳艳
 * Date：2017/09/04
 * 编辑指导员分类
 */
    public function edit_category(){
        $category_name=M('GuiderCategory')->where(array('id'=>$_GET['id']))->getField('category_name');
        $this->assign('category_name',$category_name);
        $this->assign('id',$_GET['id']);
        $this->assign('btn','编辑');
        $this->category_index();
    }
}
