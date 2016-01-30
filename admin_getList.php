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
$data = $gather->getIndexList();
foreach($data as $value){
    preg_match_all('/href="\.([^"|\']+)".*data-echo="([^"|\'].+)".+\n.+\n.+sTit">(.+)<\/span>/Ui',$value,$matches);
    if(!empty($matches)){
        if(!$database->has('gether_info',array('remote_page_name'=>$matches[1][0]))){
            $last_user_id = $database->insert("gether_info", array(
                "remote_page_name" => $matches[1][0],
                "title" => $matches[3][0],
                "cover" => $matches[2][0],
                'add_time' =>$now,
            ));
        }
        if($last_user_id){
            echo '成功添加'.$matches[3][0].'</br>';
        }
    }
}
if(empty($last_user_id)){
    echo '数据库为最新列表';
}