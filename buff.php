<?php
error_reporting(E_ERROR);
set_time_limit(180);
include 'include/init.php';
include 'gather.php';
$gather = new gather();
$now = time();
$data = $gather->getIndexList();
foreach($data as $value){
    preg_match_all('/href="\.([^"|\']+)".*data-echo="([^"|\'].+)".+\n.+.+sNum">(.+)\n.+emHot">(.+)<\/em>.+sTit">(.+)<\/span>/Ui',$value,$matches);
    if(!empty($matches)){
        $category=$database->get('gether_info','part',array("remote_page_name" =>$matches[1][0]));
        if(!$category){
            $last_user_id = $database->update("gether_info", array(
                "part" => $matches[3][0],
            ),array("remote_page_name" => $matches[1][0]));
        }
        if($last_user_id){
            echo '成功更新类型'.$matches[3][0].'</br>';
        }
    }
}
if(empty($last_user_id)){
    echo '数据库为最新列表';
}