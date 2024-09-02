<?php

$db_host = 'localhost';
$db_name = 'year1';
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
// define("ROOT_URL", "http://192.168.0.100/cbt2/year1/");
// define("SUB_URL", "http://192.168.0.100/cbt2/");
// define("ADMIN_ROOT_URL", "http://192.168.0.100/cbt2/year1/admin/");

define("ROOT_URL", "http://localhost/cbt2/year1/");
define("SUB_URL", "http://localhost/cbt2/year1/");
define("ADMIN_ROOT_URL", "http://localhost/cbt2/year1/admin/");

// define("ROOT_URL", "http://localhost/cbt2/year1/");
// define("ADMIN_ROOT_URL", "http://localhost/cbt2/year1/admin/");





?>