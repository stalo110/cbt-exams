<?php

$db_host = 'localhost';
$db_name = 'year4';
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
// define("ROOT_URL", "http://192.168.0.100/cbt-exams/year4/");
// define("SUB_URL", "http://192.168.0.100/cbt-exams/");
// define("ADMIN_ROOT_URL", "http://192.168.0.100/cbt-exams/year4/admin/");

define("ROOT_URL", "http://localhost/cbt-exams/year4/");
define("SUB_URL", "http://localhost/cbt-exams/year4/");
define("ADMIN_ROOT_URL", "http://localhost/cbt-exams/year4/admin/");

// define("ROOT_URL", "http://localhost/cbt-exams/year4/");
// define("ADMIN_ROOT_URL", "http://localhost/cbt-exams/year4/admin/");





?>