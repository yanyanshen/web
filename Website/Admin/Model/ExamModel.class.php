<?php
namespace Admin\Model;
use Think\Model;
class ExamModel extends Model{
/*
 * User：沈艳艳
 * Date：2017/09/05
 * 试题列表
 * @param $get array 查询的条件数组
 */
    public function exam_list($get){
        $where = '';
        if(!empty($get)){
            foreach($get as $key=>$val){
                if($key == 'question' && $val != ''){
                    $where.=" question like '%".trim($val)."%' and";
                }
            }$where = rtrim($where,'and');
        }
        $count = $this->field('id,question')->where($where)->count();
        $arr['count'] = $count;

        $page = new \Think\Page($count,20);
        $show = $page->show();
        $list = $this->where($where)->field('id,question')
            ->limit($page->firstRow.','.$page->listRows)->order('id desc')->select();
        $arr['exam_list'] = $list;
        $arr['page'] = $show;
        $arr['firstRow'] = $page->firstRow;
        return $arr;
    }
/*
 * User：沈艳艳
 * Date：2017/09/08
 * 试题添加
 * @param $post array 查添加的数据
 */
    public function add_exam($post){
        $post['answer'] = strtoupper(trim($post['answer']));
        $post['image'] = $post['img'];
        if($post['subject'] == 1){
            if($post['lunshi']){
                $post['type'] = 4;
            }else{
                if($post['chapter'] == 5){
                    $post['type'] = 0;
                }elseif($post['chapter'] == 6){
                    $post['type'] = 2;
                }elseif($post['chapter'] == 7){
                    $post['type'] = 3;
                }else{
                    $post['type'] = 1;
                }
            }
        }else{
            $post['type'] = 0;
        }
        $id = M('exam')->add($post);
        if($post['img']){
            $res = $this->UploadExamPic('exam','smallpic',$id);
        }
        return 1;
    }

    //图片上传类封装
    function UploadExamPic($table,$file_name,$id){
        $upload = new \Think\Upload();
        $upload->maxSize = 3145728;
        $upload->exts = array('jpg', 'gif', 'png', 'jpeg');
        $upload->rootPath = "./Uploads/smallpic/";
        if (!file_exists($upload->rootPath)) {
            mkdir($upload->rootPath);
        }
        $info=$upload->upload();
        if(!$info){
            $res=$upload->getError();
        }else{
            $data['image']="/$file_name/".$info['image']['savepath'].$info['image']['savename'];
            $res=M($table)->field('image')->where(array('id'=>$id))->save($data);
        }
        return $res;
    }
/*-----------------------2017-12-13shenyanyan---------------------*/
//导出试题列表
    public function push($get){
        $where = '';
        if(!empty($get)){
            foreach($get as $key=>$val){
                if($key == 'question' && $val != ''){
                    $where.=" question like '%".trim($val)."%' and";
                }
            }$where = rtrim($where,'and');
        }
        $list = $this->where($where)->field('*')->select();
        $name = 'Excelfile';
        $res = push_exam($list,$name);
        return $res;
    }
}