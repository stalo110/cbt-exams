<?php

$db_host = 'localhost';
//$db_name = 'sjgss_thursday_j1';
$db_name = 'sjgss_friday2_j2';
//$db_name = 'sjgss_thursday_j3';
//$db_name = 'sjgss_thursday_s1';
//$db_name = 'sjgss_thursday_s2';
//$db_name = 'sjgss_thursday_s3';
// $db_name = 'e-exam_j2';
$db_user = 'root';
$db_pass = '';

//MYSQLI OBJECT
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);

$connection = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

//Error Handler
if($mysqli->connect_error){
    printf("connection failed: %s\n", $mysqli->connect_error);

    exit();
}
// define("ROOT_URL", "http://169.254.0.1/J2/");
// define("ADMIN_ROOT_URL", "http://169.254.0.1/J2/admin/");

//define("ROOT_URL", "http://localhost/");
//define("ADMIN_ROOT_URL", "http://localhost/admin/");

define("ROOT_URL", "http://localhost/J2New/");
define("ADMIN_ROOT_URL", "http://localhost/J2New/admin/");





?>