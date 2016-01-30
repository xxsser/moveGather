<?php
session_start();
if($_SESSION['login'] != 1){
    exit();
}
error_reporting(E_ERROR);
set_time_limit(180);
include 'include/init.php';
include 'gather.php';
$gather = new gather();
$now = time();
$list = $database->select('gether_info',array('id','remote_page_name'),array('is_read'=>0));
if($list){
    foreach($list as $value){
        $url = 'http://www.cswanda.com/weixin/game1/'.$value['remote_page_name'];
        $furl = $gather->getFuckUrl($url);
        if($furl['fuckurl']){
            $last_user_id = $database->insert("video_info", array(
                "vid" => $value['id'],
                "frame_url" => $furl['fuckurl'][1][0],
                'add_time' =>$now,
            ));
            if($last_user_id){
                $database->update('gether_info',array('is_read'=>1),array('id'=>$value['id']));
                echo $value['id'].'已成功提取'.$furl['fuckurl'][1][0].'</br>';
            }
        }
        if($furl['part']){
            for($i=0;$i<count($furl['part'][0]);$i++){
                $last_insert_id = $database->insert("gether_info", array(
                    "remote_page_name" => substr($value['remote_page_name'],0,strrpos($value['remote_page_name'],'/')+1).ltrim($furl['part'][1][$i],'.'),
                    "pid" => $value['id'],
                    "title" => $furl['part'][2][$i],
                    'add_time' =>$now,
                ));
                if($last_insert_id){
                    echo $value['id'].'成功添加分集'.$furl['part'][2][$i].'请稍后再次提取</br>';
                }
            }
        }
    }
}