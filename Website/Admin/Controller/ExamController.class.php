<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Common\Controller\CommonController;
use Think\Upload;
class ExamController extends CommonController{
//后台试题excel表导入数据
    public function exam(){
        $this->assign('http',C('HTTP'));
        $_GET['url'] = U('Admin/Exam/add_exam',array('pid'=>I('pid'),'id'=>I('type_id')));
        $this->assign('get',$_GET);
        $this->display();
    }

//excel表上传代码
//上传excel表格
    public function import_excel(){ //试题增加页面展示
        if(empty($_FILES['excelname'])){//判断上传文件是否为空
            $this->error('null');
        }else{//文件不为空时
            $file=$_FILES['excelname'];
            $file_array=explode('.',$file['name']);
            $file_extension=$file_array[count($file_array)-1];//获取文件后缀名
            //判断是否是 excel文件
            if(strtolower($file_extension)!='xls'){
                $this->error('type',U('Admin/Exam/exam',array('pid'=>I('pid'),'type_id'=>I('type_id'))));
            }
            //以时间来命名上传的文件

            //设置上传路径
            $Exceldest="./Uploads/Exceldest/file".date('Y-m-d',time());
            if(!file_exists($Exceldest)){
                mkdir("$Exceldest");
            }
            //把文件移到指定目录
            $tmp_name=$file['tmp_name'];
            $result=move_uploaded_file($tmp_name,$Exceldest.'/'.$file['name']);
            //判断文件是否上传成功
            if(!$result){
                $this->error('file_error',U('Admin/Exam/exam',array('pid'=>I('pid'),'type_id'=>I('type_id'))));
            }
            /*上传成功后的excel的数据*/
            $data=ImportExcel($Exceldest.'/'.$file['name']);
            $data=array_slice($data,1);
            $result = $this->addData($data);
            $log['done'] = '通过excel表进行交规题添加';
            D('AdminLog')->logout($log);
            $this->success('导入成功',U('Admin/Exam/chapter_list',array('pid'=>I('pid'))));
        }
    }


    //将数据添加到数据表里
    public function addData($data){
        foreach ($data as $k => $v) {
            $addData ['question'] = $v [1];
            $addData ['s1'] = $v [2];
            $addData ['s2'] = $v [3];
            $addData ['s3'] = $v [4];
            $addData ['s4'] = $v [5];
            $addData ['answer'] = $v [6];
            $addData ['analysis'] = $v [7];
            $addData ['ifmul'] = $v [8];
            if($v[9]==0){
                $addData ['image']=$v[9];
            }else{
                $addData ['image'] = C('HTTP').'/Uploads/Exceldest/images/'.$v [9];
            }
            $addData ['chapter'] = $v [10];
            $addData ['cityid'] = $v [11];
            $addData ['type'] = $v [12];
            $addData ['subject'] = $v [13];
            M('exam')->add($addData);
        }
        return $data;
    }
/*
 * User：沈艳艳
 * Date：2017/09/05
 * 试题列表
 */
    public function exam_list(){
        $exam_list = D('Exam')->exam_list($_GET);
        $this->assign('exam_list',$exam_list);
        $this->assign('get',$_GET);
        $this->display();
    }
/*
 * User：沈艳艳
 * Date：2017/09/05
 * 章节列表
 */
    public function chapter_list(){
        $subject_list = M('subject')->select();
        $this->assign('subject_list',$subject_list);
        $this->assign('get',$_GET);
        $this->display();
    }
/*
 * User：沈艳艳
 * Date：2017/09/06
 * 章节试题添加
 */
    public function add_exam(){
        if(IS_AJAX){
            $res = D('Exam')->add_exam($_POST);
            if($res) {
                $log['done'] = '交规题添加: => '.$_POST['question'];
                D('AdminLog')->logout($log);
                $this->success('添加成功',U('Admin/Exam/chapter_list',array('pid'=>I('pid'))));
            }else{
                $this->error('添加失败',U('Admin/Exam/add_exam',array('id'=>I('id'),'pid'=>I('pid'))));
            }
        }else{
            $id = I('id');
            $subject_info = M('subject')->where(array('id'=>$id))->find();
            $this->assign('subject_info',$subject_info);
            $province = M('province')->select();
            $this->assign('province',$province);
            $_GET['url'] = U('Admin/Exam/chapter_list',array('pid'=>I('pid')));
            $this->assign('get',$_GET);
            $this->display();
        }
    }
/*
 * User：沈艳艳
 * Date：2017/09/05
 * 删除试题
 */
    public function del_exam($id,$pid,$p){
        $info = M('exam')->where(array('id'=>$id))->find();
        $log['done'] = '交规题删除: => '.$info['question'];
        if($info['image']){
            $upload = new Upload();
            $upload->rootPath="./Uploads";
            $info = M('exam')->where("id = {$id}")->find();
            unlink($upload->rootPath . $info['image']);
        }
        $res = M('exam')->where(array('id'=>$id))->delete();
        if($res){
            D('AdminLog')->logout($log);
            $this->redirect('Admin/Exam/exam_list',array('pid'=>$pid,'p'=>$p),0,"<script>alert('操作成功')</script>");
        }else{
            $this->redirect('Admin/Exam/exam_list',array('pid'=>$pid,'p'=>$p),0.1,"<script>alert('操作失败')</script>");
        }
    }
/*---------------------2017-12-13shenyanyan-----------------*/
//试题导出
    public function push(){
        $res = D('Exam')->push($_GET);
        $this->success($res);
    }
}