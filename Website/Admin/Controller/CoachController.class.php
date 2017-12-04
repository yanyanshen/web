<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Page;
use Admin\Common\Controller\CommonController;
class CoachController extends CommonController {
    function index_list(){
        $Dao = M("school");
        $where = "s.boss_id=b.id and ca.id=s.category_id and city.id=s.cityid and s.type='jl' ";
        foreach($_GET as $k=>$v){
            if($k=='cityid'){
                $where.="and s.cityid ={$_GET['cityid']}  ";
            }elseif($k=='nickname'){
                $where.="and s.nickname like '%".$_GET['nickname']."%' ";
            }elseif($k=='account'){
                $where.="and s.account like '%".$_GET['account']."%' ";
            }
        }
        $count = $Dao
            ->table('xueches_boss b,xueches_school s,xueches_coach_category ca,xueches_citys city')
            ->where($where)
            ->count();
        $field="s.id,s.sex,s.nickname,s.score,s.ntime,s.carnumber,s.class_num,s.type,s.picurl,s.picname,
                s.serialid,s.numberId,s.address,s.cityid,s.verify,s.lastupdate,s.order,s.account,
                s.recommand,s.week,s.hot,s.show_forbid,
                ca.category_name,ca.id as caid,city.cityname,city.id as cityid";
        $p = new Page($count,10);
        $page = $p->show();
        $list = $Dao
            ->field($field)
            ->table('xueches_boss b,xueches_school s,xueches_coach_category ca,xueches_citys city')
            ->where($where)
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


  
    public function add_jl(){
        if(IS_AJAX){
            $school_id=M('School')->where(array('nickname'=>$_POST['school_nickname'],'type'=>'jx'))->getField('id');
            $_POST['school_id']=$school_id;
            $_POST['ntime']=time();
            $_POST['lastupdate']=session('admin_name');
            $id=M('School')->add($_POST);
            if($id){
                $log['done'] = '教练添加: => '.$_POST['nickname'];
                D('AdminLog')->logout($log);
                M('School')->where(array('id'=>$school_id,'type'=>'jx'))->setInc('coach_num',1);
            }
            $res=UploadPic('School','Coach_logo',$id);
            if($res){
                $this->success('添加成功',U('Admin/Coach/index_list',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
            }else{
                $this->success('添加失败',U('Admin/Coach/add_jl',array('p'=>$_POST['p'],'pid'=>$_POST['pid'],'type'=>I('type'))));
            }
        }else{
            $citys=M('citys')->field('id,cityname')->where("flag=1")->select();
            $this->assign('city',$citys);

            $boss=M('boss')->where(array('type'=>I('type')))->field('id,boss_name')->select();
            $this->assign('boss',$boss);

            $nickname=session('nickname');
            $this->assign('school_nickname',$nickname);
            $this->assign("get",$_GET);
            $this->display();
        }

    }
    //对教练进行编辑
    public function editor_jl(){
        if(!empty($_POST)){
            $_POST['lastupdate']=session('admin_name');
            $where['id']=$_POST['id'];
            $nickname1 = M('School')->where($where)->getField('nickname');
            $school_id=M('School')->where(array('nickname'=>$_POST['school_nickname'],'type'=>'jx'))->getField('id');
            $_POST['school_id']=$school_id;
            $_POST['ntime'] = time();
            D('school')->jx_editor($where,$_POST);//更新数据
            $res=editorPic('School','Coach_logo',$_POST['id']);
            if($res){
                $log['done'] = "教练信息:$nickname1 => {$_POST['nickname']}";
                D('AdminLog')->logout($log);
                $url = U('Admin/Coach/index_list',array('p'=>$_POST['p'],'pid'=>$_POST['pid']));
                $this->success('编辑成功',$url);
            }else{
                $url = U('Admin/Coach/editor_jl',array('p'=>$_POST['p'],'pid'=>$_POST['pid'],'id'=>$_POST['id'],'type'=>I('type')));
                $this->error('编辑失败',$url);
            }
        }else{
            $id=$_GET['id'];
            $where['id']=$id;
            $where['type']= $_GET['type'];
            $data=D('school')->school_list($where);
            $school_nickname=D('School')->school_list(array('id'=>$data['school_id'],'type'=>'jx'),'nickname');
            $this->assign('school_nickname',$school_nickname['nickname']);
            $category=M('CoachCategory')->field('id,category_name')->select();
            $this->assign('category',$category);
            $boss=M('boss')->where(array('type'=>'jl'))->field('id,boss_name')->select();
            $this->assign('boss',$boss);
            $city=M('citys')->field("id,cityname")->where("flag=1")->select();
            $this->assign("city",$city);
            $this->assign("jl",$data);
            $nickname=session('nickname');
            session('nickname',null);
            $this->assign('nickname',$nickname);

            $this->assign('url',U('Admin/Coach/index_list',array('p'=>$_GET['p'],'pid'=>$_GET['pid'])));

            $this->assign("get",$_GET);
            $this->display();
        }
    }

    public function school(){
        if(IS_AJAX){
            $nickname=M('School')->where(array('id'=>$_POST['school_id'],'type'=>'jx'))->getField('nickname');
            session('nickname',$nickname);
            switch($_POST['type']){
                case 'jl':
                    $url = U('Admin/Coach/add_jl',array('pid'=>$_POST['pid'],'p'=>$_POST['p'],'type'=>'jl'));
                    break;
                case 'zd':
                    $url = U('Admin/Guider/add_zd',array('pid'=>$_POST['pid'],'p'=>$_POST['p'],'type'=>'zd'));
            }
            $this->success(1,$url);
        }else{
            $school=M('School')->field('id,nickname')->where(array('cityid'=>$_GET['cityid'],'type'=>'jx'))->select();
            $this->assign('school',$school);
            $this->assign('get',$_GET);
            $this->display();
        }
    }

    public function edit_school(){
        if(IS_AJAX){
            $nickname=M('School')->where(array('id'=>$_POST['school_id'],'type'=>'jx'))->getField('nickname');
            session('nickname',$nickname);
            switch($_POST['type']){
                case 'jl':
                    $url = U('Admin/Coach/editor_jl',array('pid'=>$_POST['pid'],'p'=>$_POST['p'],'type'=>'jl','id'=>$_POST['id']));
                    break;
                case 'zd':
                    $url = U('Admin/Guider/editor_zd',array('pid'=>$_POST['pid'],'p'=>$_POST['p'],'type'=>'zd','id'=>$_POST['id']));
            }
            $this->success(1,$url);
        }else{
            if($_GET['id']){
                $data=D('School')->school_list(array('id'=>$_GET['id'],'type'=>'jl'),'school_id');
                $this->assign('info',$data);
                $this->assign('id',$_GET['id']);
            }
            $this->assign('get',$_GET);
            $school=M('School')->field('id,nickname')->where(array('cityid'=>$_GET['cityid'],'type'=>'jx'))->select();
            $this->assign('school',$school);
            $this->display();
        }
    }
/*
 * User：沈艳艳
 * Date：2017/09/04
 * 教练分类列表/编辑教练分类/添加教练分类
 */
    public function category_index(){
        if(IS_AJAX){
            if($_POST['category_name'] == ''){
                $this->error('分类名称不能为空',U('Admin/Coach/category_index',array('pid'=>I('pid'))));
            }
            $_POST['time']=time();
            $_POST['update_people']=session('admin_name');
            if($_POST['cid']){
                $category=M('CoachCategory')->where(array('id'=>$_POST['cid']))->getField('category_name');
                $log['done'] = "教练分类信息:$category => {$_POST['category_name']}";

                $res=M('CoachCategory')->where(array('id'=>$_POST['cid']))->save($_POST);
            }else{
                $cid=M('CoachCategory')->where(array('category_name'=>$_POST['category_name']))->getField('id');
                if($cid){
                    $this->error('数据已经存在',U('Admin/Coach/category_index',array('pid'=>I('pid'))));
                }else{
                    $res=M('CoachCategory')->add($_POST);
                    $log['done'] = '教练分类信息: => '.$_POST['category_name'];
                }
            }
            if($res){
                D('AdminLog')->logout($log);
                $this->success('操作成功',U('Admin/Coach/category_index',array('pid'=>I('pid'))));
            }else{
                $this->error('操作失败',U('Admin/Coach/category_index',array('pid'=>I('pid'))));
            }
        }else{
            if(I('id')){
                //修改
                $category_name=M('CoachCategory')->where(array('id'=>$_GET['id']))->getField('category_name');
                $this->assign('category_name',$category_name);
                $this->assign('btn','编辑');
            }
            //教练列表
            $info=M('CoachCategory')->select();
            $this->assign('get',$_GET);
            $this->assign('category',$info);
            $this->display();
        }
    }

/*
 * User：沈艳艳
 * Date：2017/09/04
 * 删除教练分类
 */
    public function del_category($id,$pid,$type){
        switch($type){
            case 'jl':
                $table = 'CoachCategory';
                //原来的教练分类名称
                $coach = M("$table")->where(array('id'=>$id))->getField('category_name');
                $log['done'] = '教练分类删除 => '.$coach;
                $url = 'Admin/Coach/category_index';
                break;
            case 'zd':
                $table = 'GuiderCategory';
                //原来的指导员分类名称
                $guider = M("$table")->where(array('id'=>$id))->getField('category_name');
                $log['done'] = '指导员分类删除 => '.$guider;
                $url = 'Admin/Guider/category_index';
                break;
        }

        $res = M("$table")->where(array('id'=>$id))->delete();
        if($res){
            D('AdminLog')->logout($log);
            $this->redirect($url,array('pid'=>$pid),0,"<script>alert('删除成功')</script>");
        }else{
            $this->redirect($url,array('pid'=>I('pid')),0,"<script>alert('删除失败')</script>");
        }
    }
}
