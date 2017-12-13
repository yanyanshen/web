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
        $count = $Dao->table('xueches_boss b,xueches_school s,xueches_coach_category ca,xueches_citys city')
            ->where($where)->count();
        $field="s.*,ca.category_name,ca.id as caid,city.cityname,city.id as cityid";
        $p = new Page($count,10);
        $page = $p->show();
        $list = $Dao->field($field)
            ->table('xueches_boss b,xueches_school s,xueches_coach_category ca,xueches_citys city')
            ->where($where)->limit($p->firstRow.','.$p->listRows)
            ->order('s.order desc')
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
            $_POST['ntime']=time();
            $_POST['lastupdate']=session('admin_name');
            $id=M('School')->add($_POST);
            if($id){
                $log['done'] = '教练添加: => '.$_POST['nickname'];
                D('AdminLog')->logout($log);
                M('School')->where(array('id'=>$_POST['school_id'],'type'=>'jx'))->setInc('coach_num',1);
            }
            $res=UploadPic('School','Coach_logo',$id);
            if($res){
                $this->success('添加成功',U('Admin/Coach/index_list',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
            }else{
                $this->success('添加失败',U('Admin/Coach/add_jl',array('p'=>$_POST['p'],'pid'=>$_POST['pid'],'type'=>I('type'))));
            }
        }else{
            $category=M('CoachCategory')->field('id,category_name')->select();
            $this->assign('category', $category);

            $citys=M('citys')->field('id,cityname')->where("flag=1")->select();
            $this->assign('city',$citys);

            $boss=M('boss')->where(array('type'=>I('type')))->field('id,boss_name')->select();
            $this->assign('boss',$boss);

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
            $log['done'] = "教练信息:$nickname1 => {$_POST['nickname']}";
            D('school')->jx_editor($where,$_POST);//更新数据
            $res=editorPic('School','Coach_logo',$_POST['id']);
            if($res){
                D('AdminLog')->logout($log);
                M('School')->where(array('id'=>$_POST['school_id'],'type'=>'jx'))->setInc('coach_num',1);
                $this->success('编辑成功',U('Admin/Coach/index_list',array('p'=>$_POST['p'],'pid'=>$_POST['pid'])));
            }else{
                $url = U('Admin/Coach/editor_jl',array('p'=>$_POST['p'],'pid'=>$_POST['pid'],'id'=>$_POST['id'],'type'=>I('type')));
                $this->error('编辑失败',$url);
            }
        }else{
            $id=$_GET['id'];
            $where['id']=$id;
            $where['type']= $_GET['type'];
            $data=D('school')->school_list($where);
            $school_nickname = D('School')->school_list(array('id'=>$data['school_id'],'type'=>'jx'),'nickname');
            $this->assign('school_nickname',$school_nickname['nickname']);
            $category=M('CoachCategory')->field('id,category_name')->select();
            $this->assign('category',$category);
            $boss=M('boss')->where(array('type'=>'jl'))->field('id,boss_name')->select();
            $this->assign('boss',$boss);
            $city=M('citys')->field("id,cityname")->where("flag=1")->select();
            $this->assign("city",$city);
            $this->assign("jl",$data);
            $this->assign('url',U('Admin/Coach/index_list',array('p'=>$_GET['p'],'pid'=>$_GET['pid'])));
            $this->assign("get",$_GET);
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
/*-------------------------------2017-12-07shenyanyan------------------------*/
//教练排行榜
    public function coach_top(){
        $where['_string']="c.id=s.cityid and s.recommand=1 and s.type='jl'";
        $info=M('School')->table('xueches_school s,xueches_citys c')
            ->field('s.id as school_id,s.nickname,s.connectteacher,s.score,s.address,s.picurl,s.picname,
                s.student_num,s.class_num,s.account,s.order,s.type,c.cityname')
            ->where($where)->order('s.order')->select();
        $this->assign('jx_list',$info);
        $this->assign('http',C('HTTP'));
        $this->assign('count',count($info));
        $this->assign('get',$_GET);
        $this->display();
    }
}
