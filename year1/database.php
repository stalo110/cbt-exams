<?php

//connection credentials

ob_start();
session_start();

ini_set('display_errors', 'Off');


require_once("includes/connection.php");
require_once("includes/functions.php");

date_default_timezone_set('Africa/Lagos');


$c_time = date('H:i:s', time());



if(date('m') > 12){
    redirect("contact.php");
}



$current_time = toSeconds($c_time);



function toSeconds($time){
    $time = preg_replace("/^([\d]{1,2})\:([\d]{2})$/", "00:$1:$2", $time);

    sscanf($time, "%d:%d:%d", $hours, $minutes, $seconds);

    return $time_seconds = $hours * 3600 + $minutes * 60 + $seconds;
}