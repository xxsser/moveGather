<?php
error_reporting(E_ERROR);
define('USER','admin');
define('PASS','admin');
session_start();
if($_GET['action']=='login'){
    if($_POST['user'] == USER && $_POST['pass'] == PASS){
        $_SESSION['login'] = 1;
    }
}
if($_SESSION['login'] == 1){?>

    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>后台管理</title>
        <style>
            iframe {height: 100%;}
        </style>
    </head>
    <body>
    <iframe src="toc.html" frameborder="0" style="width: 18%" ></iframe>
    <iframe src="pref.html" frameborder="0" name="view_frame" style="width: 80%" ></iframe>
    </body>
    </html>
<?php
}else{
    header('Location: login.php');
}