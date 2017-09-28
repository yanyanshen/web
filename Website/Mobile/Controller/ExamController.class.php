<?php
namespace Mobile\Controller;
use Think\Controller;
class ExamController extends Controller{
/*沈艳艳
    @从首页进入理论学习页面
*/
    public function theory_study(){
        $subject=$_POST['sub_button'];
        preg_match('/[a-zA-Z][0-9]{0,1}/',$_POST['sub_button1'],$str);//匹配驾照类型
        $type=$str[0];
        $this->assign('ms',$subject);
        $this->assign('mt',$type);
        $mtid=M('type')->where(array('jztype'=>$_POST['sub_button1']))->getField('type');
        if($_POST['sub_button']=='科目一'){
            $msid=1;
        }elseif($_POST['sub_button']=='科目四'){
            $msid=2;
        }
        if(!$_POST['sub_button']){
            $msid = 1;
        }
        $this->assign('msid',$msid);
        $this->assign('mtid',$mtid);
        $this->display();
    }
/*沈艳艳
    @选择章节 科目页面
*/
    public function driver_type(){
        $type=M('type')->where(array('type'=>array('neq',5)))->select();
        $this->assign('type',$type);
        $this->assign('empty',"<h1>暂无数据</h1>");
        $this->display();
    }
/*沈艳艳
    @章节练习页面
*/
    public function chapter(){
        if(!session('mid')){
            $this->redirect('Mobile/Login/login');
        }
        $type=$_GET['mt'];
        $subject=$_GET['ms'];
        $cityname=session('city');
        $cityid=M('citys')->where(array('cityname'=>array('like',"%$cityname%")))->find();

        $sub=M('subject')->where(array('subject'=>$subject))->select();
        if(I('mc')){
            $c = 1;
        }else{
            $c = 0;
        }
        $this->assign('mc',$c);
        if($subject==1){
            if($type==1){
                $chapter1 = $this->chapter_count(1,$subject,1,0,$c);//公共题库是type=1 ，每种都有
                $chapter2 = $this->chapter_count(1,$subject,2,0,$c);
                $chapter3 = $this->chapter_count(1,$subject,3,0,$c);
                $chapter4 = $this->chapter_count(1,$subject,4,0,$c);
            }elseif($type == 2){//客车
                $chapter1 = $this->chapter_count(1,$subject,1,0,$c);//公共题库是type=1 ，每种都有
                $chapter2 = $this->chapter_count(1,$subject,2,0,$c);
                $chapter3 = $this->chapter_count(1,$subject,3,0,$c);
                $chapter4 = $this->chapter_count(1,$subject,4,0,$c);
                $chapter6 = $this->chapter_count(2,$subject,6,0,$c);
            }elseif($type == 3){//货车
                $chapter1 = $this->chapter_count(1,$subject,1,0,$c);//公共题库是type=1 ，每种都有
                $chapter2 = $this->chapter_count(1,$subject,2,0,$c);
                $chapter3 = $this->chapter_count(1,$subject,3,0,$c);
                $chapter4 = $this->chapter_count(1,$subject,4,0,$c);
                $chapter7 = $this->chapter_count(3,$subject,7,0,$c);
            }elseif($type == 4){//轮式
                $chapter1 = $this->chapter_count(4,$subject,1,0,$c);//公共题库是type=1 ，每种都有
                $chapter2 = $this->chapter_count(4,$subject,2,0,$c);
                $chapter3 = $this->chapter_count(4,$subject,3,0,$c);
                $chapter4 = $this->chapter_count(4,$subject,4,0,$c);
            }
            $chapter5 = $this->chapter_count(0,$subject,5,$cityid['province'],$c);
            $arr = subject($sub,$chapter1,$chapter2,$chapter3,$chapter4,$chapter5,$chapter6,$chapter7,$type,$c);
        }else{
            $chapter1 = $this->chapter_count(0,$subject,1,0,$c);//公共题库是type=0 ，每种都有
            $chapter2 = $this->chapter_count(0,$subject,2,0,$c);
            $chapter3 = $this->chapter_count(0,$subject,3,0,$c);
            $chapter4 = $this->chapter_count(0,$subject,4,0,$c);
            $chapter5 = $this->chapter_count(0,$subject,5,0,$c);
            $chapter6 = $this->chapter_count(0,$subject,6,0,$c);
            $chapter7 = $this->chapter_count(0,$subject,7,0,$c);
            $type=0;
            $arr = subject($sub,$chapter1,$chapter2,$chapter3,$chapter4,$chapter5,$chapter6,$chapter7,$type,$c);
        }
        session('mt',$type);
        $this->assign('sub',$arr);
        $this->display();
    }

/*沈艳艳
@每个科目每个章节的试题查询
*/
    public function chapter_practice(){
        if($_GET['mc']){
            $c = $_GET['mc'];
        }else{
            $c = 0;
        }
        $this->assign('mc',$c);
        if(IS_AJAX){
            $chapter = session('mchapter');
            $i = I('k');
            if($_POST['cancel']){
                $res=$this->collect($i,$chapter,$_POST['cancel']);
                $this->success($res);
            }elseif($_POST['analysis']){
                $res=$this->collect($i,$chapter,0,$_POST['analysis']);
                $res=explode(',',$res);
                $this->success($res[0],$res[1]);
            }else{
                $res=$this->collect($i,$chapter);
                $this->success($res);
            }
        }else{
            $chap=I('mp');
            $subject=I('ms');
            switch ($subject){
                case '1':
                    if($chap == 5){
                        $cityname = session('city');
                        $cityid = M('citys')->where(array('cityname'=>array('like',"%$cityname%")))->find();
                        $cityid = $cityid['province'];
                    }else{
                        $cityid=0;
                    }
                    break;
                case '2':
                    $cityid=0;
                    break;
            }
            $type=I('mt');
            $title=M('subject')->where(array('chapter'=>$chap))->getField('title');
            $this->assign('title',$title);
            $where = " and subject = $subject";
            $where .= " and chapter = $chap";
            $where .= " and cityid = $cityid";
            $questionid = M('exam_collect')->where(array('userid'=>session('mid')))->getField('questionid');
            if($c){
                if($questionid){
                    $where .= " and id in($questionid)";
                }
            }
            if($subject==1){//科目1
                if($type==4){
                    $count=$this->chapter_count(4,$subject,$chap,$cityid,$c);//公共题库是type=1 ，每种都有
                    $chapter=M('exam')->where("type = 1 or type=4 $where")->select();
                }else{
                    $count=$this->chapter_count($type,$subject,$chap,$cityid,$c);//公共题库是type=1 ，每种都有
                    $chapter=M('exam')->where("type = $type $where")->select();
                }
            }else{//科目4
                $count=$this->chapter_count(0,$subject,$chap,$cityid,$c);//公共题库是type=1 ，每种都有
                $chapter=M('exam')->where("type = 0 $where")->select();
            }
            session('mchapter',$chapter);
        }
        $this->assign('count',$count);
        $this->assign('chapter',$chapter);
        $this->assign('mt',$type);
        $this->assign('ms',$subject);
        $this->assign('mp',$chap);
        $this->assign('empty',"<h1>暂无数据</h1>");
        $this->display();
    }

    /*沈艳艳
    @param  string $chapter 练习的题目
    @param  string $i       第几个
    */
    public function collect($i,$chapter,$cancel=0,$analysis=0){
        $exam_collect = M('exam_collect');
        $questionid = $exam_collect->where(array('userid'=>session('mid')))->getField('questionid');
        $i = $i - 1;
        foreach($chapter as $k => $v){
            if($k  == $i){
                if($cancel){
                    $id=$v['id'];
                    $str = remove_string($questionid,$id);
                    return $str;
                }elseif($analysis){
                    return $v['id'].','.$v['ifmul'];
                }else{
                    if($questionid){
                        if(strpos($questionid,$chapter[$k]['id']) === false){
                            $data['questionid'] = $questionid.','.$v['id'];
                            $res = $exam_collect->where(array('userid'=>session('mid')))->save($data);
                        }
                    }else{
                        $data['questionid'] = $v['id'];
                        $data['userid'] = session('mid');
                        $res = $exam_collect->add($data);
                    }
                    if($res){
                        return '收藏成功';
                    }else{
                        return '已经在收藏夹里了';
                    }
                }
            }
        }
    }
    /*沈艳艳
    @param $type    驾照类型
    @param $subject 科目
    @param $chapter 章节
    @param $cityid  城市id
    @param $mc      1是我的题库 0是章节练习
    @param $count 每个科目章节的数目查询
*/
    function chapter_count($type,$subject,$chapter,$cityid=0,$c=0){
        $where  = " and subject=$subject ";
        $where .= " and chapter=$chapter  ";
        $where .= " and cityid=$cityid  ";
        if($c){
            $questionid = M('exam_collect')->where(array('userid'=>session('mid')))->getField('questionid');
            if($questionid){
                $where .= "and id in ($questionid)";
            }else{
                $count = 0;
                return $count;
            }
        }
        if($type == 4){
            $count = M('exam')->where("(type = 1 or type = 4)  $where")->count();
        }else{
            $count = M('exam')->where("type = $type $where")->count();
        }
        return $count;
    }
/*沈艳艳
@章节练习里面的多选题的判断
*/
    public function judge(){
        if(empty($_POST['ms'])){
            $this->error('请选择答案');
        }else{
            $str = '';
            $ms=$_POST['ms'];
            foreach($ms as $k=>$v){
                $str .= $v;
            }
            $str1='';
            if(strpos($str,'A')!==false){
                $str1.='A'.',';
            }if(strpos($str,'B')!==false){
                $str1.='B'.',';
            }if(strpos($str,'C')!==false){
                $str1.='C'.',';
            }if(strpos($str,'D')!==false){
                $str1.='D'.',';
            }

            $str1=substr($str1,0,-1);
            preg_match('/\d+/',$str,$idArr);
            $id=$idArr[0];
            $info=M('exam')->where(array('id'=>$id))->find();
            $arr=explode(',',$str1);
            foreach($arr as $v1){
                $str2.=$v1;
            }
            if($info['answer']==$str2){
                $res=M('exam_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->find();
                if($res){
                    M('exam_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->delete();
                }
                $this->success('回答正确',$res);
            }else{
                $data['questionid']=$id;
                $data['userid']=session('mid');
                $data['user_answer']=$str1;
                $res=M('exam_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->find();
                if($res){
                    M('exam_error')->where(array('id'=>$res['id']))->save($data);
                }else{
                    M('exam_error')->add($data);
                }
                $this->error('回答错误',$str1);
            }
        }
    }

/*沈艳艳
@章节练习里的单选题判断
*/
    public function one_judge(){
        $id=I('id');
        $data['questionid']=$id;
        $data['userid']= session('mid');
        $data['user_answer'] = I('user_answer');
        $answer=M('exam')->where(array('id'=>$id))->getField('answer');
        $info=M('exam_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->find();

        if($info){
            if($answer==I('user_answer')){
                M('exam_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->delete();
            }else{
                M('exam_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->save($data);
            }
        }else{
            if($answer!=I('user_answer')){
                M('exam_error')->add($data);
            }
        }
        $this->success($id);
    }

/*沈艳艳*
 * 我的错题页面
 * */
    public function wrong_topic(){
        if(!session('mid')){
            $this->redirect('Mobile/Login/login');
        }
        $subject=I('ms');
        $userid = session('mid');
        $count=$count=M('exam_error')
            ->table('xueches_exam_error er,xueches_exam em')
            ->where("er.questionid=em.id and er.userid=$userid and em.subject = $subject")
            ->count();
        $this->assign('count',$count);
        $this->assign('ms',$subject);
        $this->display();
    }

/*沈艳艳
    @我的错题页面里的错题查看
*/
    public function check_error(){
        $subject=I('ms');
        $userid=session('mid');
        if(IS_AJAX){
            $exam_collect = M('exam_collect');
            $i = I('k') - 1;
            $analysis = I('analysis');
            $questionid = $exam_collect->where(array('userid'=>$userid))->getField('questionid');
            $info = session('info');
            foreach($info as $k=>$v){
                if(IS_AJAX){
                    if($k == $i){
                        if($analysis){
                            $this->success($v['id'],$v['ifmul']);
                        }else{
                            if($questionid){
                                if(strpos($questionid,$info[$k]['id']) === false){
                                    $data['questionid'] = $questionid.','.$v['id'];
                                    $res = $exam_collect->where(array('userid'=>$userid))->save($data);
                                }
                            }else{
                                $data['questionid'] = $v['id'];
                                $data['userid'] = session('mid');
                                $res = $exam_collect->add($data);
                            }
                            if($res){
                                $this->success('收藏成功');
                            }else{
                                $this->error('已在收藏里了');
                            }
                        }
                    }
                }
            }
        }else{
            $info=M('exam_error')
                ->field('er.user_answer,em.*')
                ->table('xueches_exam_error er,xueches_exam em')
                ->where("er.questionid=em.id and er.userid=$userid and em.subject = $subject ")
                ->select();
            $count=M('exam_error')
                ->table('xueches_exam_error er,xueches_exam em')
                ->where("er.questionid=em.id and er.userid=$userid and em.subject = $subject")
                ->count();

            foreach($info as $k=>$v){
                if($v['ifmul']==1){
                    $info[$k]['arr']=explode(',',$v['user_answer']);
                }
            }
            session('info',$info);
        }
        $this->assign('ms',$subject);
        $this->assign('chapter',$info);
        $this->assign('count',$count);
        $this->display();
    }

    /*
     * 沈艳艳
     * 错题练习
     */

    public function error_practice(){
        $subject=I('ms');
        $this->assign('ms',$subject);
        $userid=session('mid');
        $info=M('exam_error')
            ->field('er.user_answer,em.*')
            ->table('xueches_exam_error er,xueches_exam em')
            ->where("er.questionid=em.id and er.userid=$userid and em.subject = $subject")
            ->select();
        $count=M('exam_error')
            ->table('xueches_exam_error er,xueches_exam em')
            ->where("er.questionid=em.id and er.userid=$userid and em.subject = $subject")
            ->count();
        session('info',$info);
        $this->assign('count',$count);
        $this->assign('chapter',$info);
        $this->display();
    }

    /*沈艳艳*
     * 将多选的答案用逗号分开
     * @param  string $str 字符串
     * @param  string $count 从第几个开始
     * @param  string $number 取几个
     * @return $excelData       数组
     *
     */
    public function getStr($str,$count=0,$number=1,$type=-1){
        $str1='';
        for($i=0;$i<strlen($str);$i++){
            $str1.=substr($str,$i,$number).',';
        }
        $str1=substr($str1,$count,$type);

        return $str1;
    }
/*
 * 沈艳艳
 * @所有试题解析查看
 */

    public function test_analysis(){
        $subject = I('ms');
        $type = I('mt');
        $cityname = session('city');
        $cityid = M('citys')->where(array('cityname'=>array('like',"%$cityname%")))->find();
        $where = "subject = $subject";
        if($subject == 1){
            if($type == 1){
                $where .= "  and (type = $type or cityid = {$cityid['province']})";
            }else{
                $where .= "  and (type = $type or type = 1 or cityid = {$cityid['province']})";
            }
        }else{
            $where .= "";
        }
        $info = M('exam')->where($where)->select();
        $count = count($info);
        $exam_collect = M('exam_collect');
        foreach($info as $k=>$v){
            if(IS_AJAX){
                $i = I('k') - 1;
                if($k  == $i){
                    $questionid = $exam_collect->where(array('userid'=>session('mid')))->getField('questionid');
                    if($questionid){
                        if(strpos($questionid,$info[$k]['id']) === false){
                            $data['questionid'] = $questionid.','.$v['id'];
                            $res = $exam_collect->where(array('userid'=>session('mid')))->save($data);
                        }
                    }else{
                        $data['questionid'] = $v['id'];
                        $data['userid'] = session('mid');
                        $res = $exam_collect->add($data);
                    }
                    if($res){
                        $this->success('收藏成功');
                    }else{
                        $this->error('已经在收藏夹里了');
                    }
                }
            }
            if(strlen($v['answer'])>1){
                $str=$this->getStr($v['answer']);
                $info[$k]['arr']=explode(',',$str);
            }
        }
        $this->assign('count',$count);
        $this->assign('ms',$subject);
        $this->assign('mt',$type);
        $this->assign('chapter',$info);
        $this->display();
    }
}