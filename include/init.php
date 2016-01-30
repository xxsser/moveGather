<?php
require_once 'include/medoo.php';
$database = new medoo(array(
    'database_type' => 'mysql',
    'database_name' => 'caiji_cswanda',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'toor',
    'charset' => 'utf8'
));

define('APPID','wxb765f309b6586cba');
define('SECRET','08921b2703a5be1b91a56cd70ea961a2');