<?php
header('Content-type:text/html;charset=utf-8');
//经纬度
function curlGetWeb($area,$address){
    $Url="http://api.map.baidu.com/geocoder?address=".trim($area).trim($address)."&output=json&key=ASESdpTH1lcn6HbficDjIxGbpHyVAs3P";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $Url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); //如果把这行注释掉的话，就会直接输出
    $result=curl_exec($ch);
    curl_close($ch);
    $infolist=json_decode($result);
    $array=array();
    if(isset($infolist->result->location) && !empty($infolist->result->location)){
        $array=array(
            'lng'=>$infolist->result->location->lng,
            'lat'=>$infolist->result->location->lat,
        );
        return $array;
    }
    else
    {
        return false;
    }
}


/*沈艳艳
    @查询每个章节的数目 封装的类
    @ $sub 科目
    @param string $chapter1 章节1
    @param string $chapter2 章节2
    @param string $chapter3 章节3
    @param string $chapter4 章节4
    @param string $chapter5 章节5
    @param string $chapter6 章节6
    @param string $chapter7 章节7
    @param string $c        用来区分是我的题库还是章节练习
    @return string $count 每个章节的题目数量
  */
function subject ($sub,$chapter1,$chapter2,$chapter3,$chapter4,$chapter5,$chapter6,$chapter7,$type,$c){
    if($type==2||$type==3){
        $type=1;
    }
    foreach($sub as $k=>$v){
        if($v['chapter']==1){
            $sub[$k]['num']=$chapter1;
            $sub[$k]['type']=$type;
            $sub[$k]['mc']=$c;
        }
        if($v['chapter']==2){
            $sub[$k]['num']=$chapter2;
            $sub[$k]['type']=$type;
            $sub[$k]['mc']=$c;
        }
        if($v['chapter']==3){
            $sub[$k]['num']=$chapter3;
            $sub[$k]['type']=$type;
            $sub[$k]['mc']=$c;
        }
        if($v['chapter']==4){
            $sub[$k]['num']=$chapter4;
            $sub[$k]['type']=$type;
            $sub[$k]['mc']=$c;
        }
        if($v['chapter']==5){
            $sub[$k]['num']=$chapter5;
            $sub[$k]['type']=0;
            $sub[$k]['mc']=$c;
        }
        if($v['subject']==1){
            if($v['chapter']==6){
                $sub[$k]['num']=$chapter6;
                $sub[$k]['type']=2;
                $sub[$k]['mc']=$c;
            }
        }else{
            if($v['chapter']==6){
                $sub[$k]['num']=$chapter6;
                $sub[$k]['type']=0;
                $sub[$k]['mc']=$c;
            }
        }

        if($v['subject']==2){
            if($v['chapter']==7){
                $sub[$k]['num']=$chapter7;
                $sub[$k]['type']=0;
                $sub[$k]['mc']=$c;
            }
        }else{
            if($v['chapter']==7){
                $sub[$k]['num']=$chapter7;
                $sub[$k]['type']=3;
                $sub[$k]['mc']=$c;
            }
        }

    }
    return $sub;
}

/*沈艳艳
@param string   $string 字符串
@param string   $str    子字符串
@param return   $new_str      将字符串移除后返回的新的字符串
*/
function remove_string($string,$str){
    $string = ','.$string.',';
    $new_str = preg_replace("/,$str,/i",',',$string);
    $data['questionid'] = trim($new_str,',');
    M('exam_collect')->where(array('userid'=>session('mid')))->save($data);
    return '移除成功';
}



//php获取从百度搜索进入网站的关键词






