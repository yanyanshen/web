<?php
namespace Mobile\Controller;
use Think\Controller;
class SimulateController extends Controller{
    /*沈艳艳
        模拟考试首页
    */

    public function test_system(){
        if(!session('mid')){
            $this->redirect('Mobile/Login/login');
        }
        M('simulate_error')->where(array('userid'=>session('mid')))->delete();
        M('user')->where(array('userid'=>session('mid')))->save(array('score'=>0));
        $subject = I('ms');
        $type = I('mt');
        $nickname = M('user')->where(array('id'=>session('mid')))->getField('truename');
        $this->assign('nickname',$nickname);
        $this->assign('ms',$subject);
        $this->assign('mt',$type);
        $this->display();
    }

/*沈艳艳
    模拟考试试题展示
*/
    function simulate(){
        M('user')->where(array('userid'=>session('mid')))->save(array('score'=>0));
        $subject=I('ms');
        $type=I('mt');
        $cityname = session('city');
        $cityid = M('citys')->where(array('cityname'=>array('like',"%$cityname%")))->getField('id');
        $city_exam = M('exam')->where("chapter = 5 and cityid = {$cityid['province']} and subject = $subject and type = 0 ")->select();//城市题库
        $info13 = M('exam')->where("(chapter = 1 or chapter = 3) and subject = $subject and type = 1 ")->select();//通用
        $info6 = M('exam')->where("chapter = 6 and subject = $subject  and type = 2")->select();//客车题库
        $info7 = M('exam')->where("chapter = 7 and subject = $subject and type = 3")->select();//货车题库
        $info2 = M('exam')->where("chapter = 2 and subject = $subject and type = 1")->select();//第二章
        $info4 = M('exam')->where("chapter = 4 and subject = $subject and type = 1")->select();//第四章
        if($subject==1){//科目1
            if(!empty($city_exam)){//首先判断城市题库存不存在
                shuffle($city_exam);
                $city_exam = array_slice($city_exam,0,5);
                switch ($type){
                    case '1'://统用题库
                        shuffle($info13);
                        $info13 = array_slice($info13,0,40);
                        shuffle($info2);
                        $info2 = array_slice($info2,0,35);
                        shuffle($info4);
                        $info4 = array_slice($info4,0,20);
                        $info = array_merge($info13,$info2,$info4);
                        break;
                    case '2'://客车题库+通用题库
                        if(!empty($info6)){
                            shuffle($info6);
                            $info6 = array_slice($info6,0,5);

                            shuffle($info13);
                            $info13 = array_slice($info13,0,38);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,32);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,20);
                            $info = array_merge($city_exam,$info13,$info6,$info4,$info2);
                        }else{
                            shuffle($info13);
                            $info13 = array_slice($info13,0,40);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,35);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,20);
                            $info = array_merge($city_exam,$info13,$info2,$info4);
                        }
                        break;
                    case '3':
                        if(!empty($info7)){
                            shuffle($info7);
                            $info7 = array_slice($info7,0,5);

                            shuffle($info13);
                            $info13 = array_slice($info13,0,38);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,32);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,20);
                            $info = array_merge($city_exam,$info13,$info7,$info4,$info2);
                        }else{
                            shuffle($info13);
                            $info13 = array_slice($info13,0,40);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,35);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,20);
                            $info = array_merge($city_exam,$info13,$info2,$info4);
                        }
                        break;
                    case '4':
                        $info13 = M('exam')->where("subject = $subject and (chapter = 1 or chapter = 3)")->select();
                        shuffle($info13);
                        $info13 = array_slice($info13,0,40);
                        $info2 = M('exam')->where("subject = $subject and chapter =2")->select();
                        shuffle($info2);
                        $info2 = array_slice($info2,0,35);
                        $info4 = M('exam')->where("subject = $subject and chapter = 4")->select();
                        shuffle($info4);
                        $info4 = array_slice($info4,0,20);
                        $info = array_merge($city_exam,$info13,$info2,$info4);
                        break;
                }
            }else{
                switch ($type){
                    case '1'://统用题库
                        shuffle($info13);
                        $info13 = array_slice($info13,0,40);
                        shuffle($info2);
                        $info2 = array_slice($info2,0,35);
                        shuffle($info4);
                        $info4 = array_slice($info4,0,25);
                        $info = array_merge($info13,$info2,$info4);
                        break;
                    case '2'://客车题库+通用题库
                        if(!empty($info6)){
                            shuffle($info6);
                            $info6 = array_slice($info6,0,5);
                            shuffle($info13);
                            $info13 = array_slice($info13,0,38);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,32);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,25);
                            $info = array_merge($info13,$info6,$info4,$info2);
                        }else{
                            shuffle($info13);
                            $info13 = array_slice($info13,0,40);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,35);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,25);
                            $info = array_merge($info13,$info2,$info4);
                        }
                        break;
                    case '3':
                        if(!empty($info7)){
                            shuffle($info7);
                            $info7 = array_slice($info7,0,5);

                            shuffle($info13);
                            $info13 = array_slice($info13,0,38);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,32);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,25);
                            $info = array_merge($info13,$info7,$info4,$info2);
                        }else{
                            shuffle($info13);
                            $info13 = array_slice($info13,0,40);
                            shuffle($info2);
                            $info2 = array_slice($info2,0,35);
                            shuffle($info4);
                            $info4 = array_slice($info4,0,25);
                            $info = array_merge($info13,$info2,$info4);
                        }
                        break;
                    case '4':
                        $info13 = M('exam')->where("subject = $subject and (chapter = 1 or chapter = 3)")->select();
                        shuffle($info13);
                        $info13 = array_slice($info13,0,40);
                        $info2 = M('exam')->where("subject = $subject and chapter =2")->select();
                        shuffle($info2);
                        $info2 = array_slice($info2,0,35);
                        $info4 = M('exam')->where("subject = $subject and chapter = 4")->select();
                        shuffle($info4);
                        $info4 = array_slice($info4,0,25);
                        $info = array_merge($info13,$info2,$info4);
                        break;
                }
            }
        }else{//科目4
            $info1 = M('exam')->where("subject = $subject and ifmul != 1")->select();
            shuffle($info1);
            $info1 = array_slice($info1,0,45);
            $info2=M('exam')->where("subject = $subject and ifmul = 1")->select();
            shuffle($info2);
            $info2 = array_slice($info2,0,5);
            $info = array_merge($info1,$info2);
        }

        $this->assign('chapter',$info);
        $this->assign('mt',$type);
        $this->assign('ms',$subject);
        $this->assign('empty',"<h1 style='font-size: 20px;text-align: center;height: 30px;padding-top: 12px'>没有查到数据</h1>");
        $this->assign('http',C('HTTP'));
        $this->display();
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
            if($info['answer'] == $str2){
                M('user')->where(array('userid'=>session('mid')))->setInc('score',2);
                $res=M('simulate_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->find();
                if($res){
                    M('simulate_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->delete();
                }
                $this->success(1);
            }else{
                $data['questionid']=$id;
                $data['userid']=session('mid');
                $data['user_answer']=$str1;
                $res=M('simulate_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->find();
                if($res){
                    M('simulate_error')->where(array('id'=>$res['id']))->save($data);
                }else{
                    M('simulate_error')->add($data);
                }
                $this->error(0);
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
        $answer=M('exam')->where(array('id'=>$id))->find();
        $info=M('simulate_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->find();

        if($info){
            if($answer['answer']==I('user_answer')){
                if($answer['subject'] == 1){
                    M('user')->where(array('userid'=>session('mid')))->setInc('score',1);
                }else{
                    M('user')->where(array('userid'=>session('mid')))->setInc('score',2);
                }
                M('simulate_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->delete();
            }else{
                M('simulate_error')->where(array('questionid'=>$id,'userid'=>session('mid')))->save($data);
            }
        }else{
            if($answer['answer']!=I('user_answer')){
                M('simulate_error')->add($data);
            }else{
                if($answer['subject'] == 1){
                    M('user')->where(array('userid'=>session('mid')))->setInc('score',1);
                }else{
                    M('user')->where(array('userid'=>session('mid')))->setInc('score',2);
                }
            }
        }
        $this->success($id);
    }


    /*沈艳艳
    @提交试卷
    */
    public function result(){
        $time = I('time');
        $ms = I('ms');
        $mt = I('mt');
        $userid = session('mid');
        $count=$count=M('simulate_error')
            ->table('xueches_simulate_error er,xueches_exam em')
            ->where("er.questionid=em.id and er.userid=$userid")
            ->count();
        $this->assign('count',$count);
        $user_info = M('user')->where(array('userid'=>session('mid')))->find();
        $this->assign('nickname',$user_info['truename']);
        $this->assign('score',$user_info['score']);
        $this->assign('time',$time);
        $this->assign('ms',$ms);
        $this->assign('mt',$mt);
        if($ms == 1){
            $time = 2700 - $time;
        }else{
            $time = 1800 - $time;
        }
        $minute = intval(($time/60)%60);
        $second = intval($time%60);
        $this->assign('minute',$minute);
        $this->assign('second',$second);
        $this->display();
    }


    /*沈艳艳
    @模拟考试错题页面里的错题查看
*/
    public function check_error(){
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
            $info=M('simulate_error')
                ->field('er.user_answer,em.*')
                ->table('xueches_simulate_error er,xueches_exam em')
                ->where("er.questionid=em.id and er.userid=$userid")
                ->select();
            $count=M('simulate_error')
                ->table('xueches_simulate_error er,xueches_exam em')
                ->where("er.questionid=em.id and er.userid=$userid")
                ->count();

            foreach($info as $k=>$v){
                if($v['ifmul']==1){
                    $info[$k]['arr']=explode(',',$v['user_answer']);
                }
            }
            session('info',$info);
        }
        $this->assign('chapter',$info);
        $this->assign('count',$count);
        $this->assign('mt',I('mt'));
        $this->assign('ms',I('ms'));
        $this->display();
    }
}