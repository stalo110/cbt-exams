<?php include '../database.php' ?>

<?php
if(!logged_in()){
    redirect('../login.php');
}
$reg_no = strtoupper($_SESSION['reg_no']);
$student_id = $_SESSION['userid'];
$class_id = getValue('class_id','students',$student_id);
$student_class = getValue('name','class',$class_id);
?>
<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>MCONSA Students Dashboard</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <!-- <link rel=stylesheet href="css/bootstrap.min.css" type="text/css" /> -->
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/bundles/pretty-checkbox/pretty-checkbox.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />  
  <link rel="stylesheet" href="assets/bundles/datatables/datatables.min.css">
  <link rel="stylesheet" href="assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">
</head>

<body>