<?php
include 'gather.php';

//$video = new gather();
//$data = $video->getFuckUrl('http://www.cswanda.com/weixin/game1/20151111wanmingsudi.html?t=0107');
$str = '/diema/haha/diema1.html?t=0113';
$data = substr($str,0,strrpos($str,'/')+1);
var_dump($data);
?>