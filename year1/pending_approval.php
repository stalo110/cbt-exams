<?php


// Include the database connection file
include 'database.php';

// Ensure a session is started only if none exists
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

// Your existing code...
$reg_no = $_SESSION['reg_no'];

// Check the latest request status
$query = "SELECT status FROM login_requests WHERE reg_no = ? ORDER BY request_time DESC LIMIT 1";
$stmt = $connection->prepare($query);
$stmt->bind_param("s", $reg_no);  // Use "s" for string
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if ($row) {  
  if ($row['status'] == 'Approved') {  
      header("Location: students/index.php");  
      exit();  
  } elseif ($row['status'] == 'Pending') {  
      $message = "Your request is still pending approval.";  
  } else {  
      $message = "Your login request was rejected.";  
  }  
} else {  
  // Insert a new login request  
  $insert_query = "INSERT INTO login_requests (reg_no, status) VALUES (?, 'Pending')";  
  $insert_stmt = $connection->prepare($insert_query);  
  $insert_stmt->bind_param("s", $reg_no);  // Use "s" for string  
  $insert_stmt->execute();  
  header("Location: pending_approval.php");  
  exit();  
}  
?>  


<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html lang="en">
<!-- subscribe.html  21 Nov 2019 04:05:02 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>MCONSA Dashboard</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="assets/css/custom.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/favicon.ico' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
      <a href="../index.php" class="btn btn-outline-primary"><i class="fas fa-home"></i> Home</a>
        <div class="row">
          <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
            <div class="login-brand">
                <!-- <img height="45" src='images/<?php if(isset($_SESSION['institution_name'])){ echo $_SESSION['institution_logo']; } ?>'><?php if(isset($_SESSION['institution_name'])){ echo $_SESSION['institution_name']; } ?> -->
                <h2>Computer Based Test </h2>
                <p>Please wait for Admin to approve your Login</p>

                <?php if (!empty($message)) { echo "<p style='color:red; font-size:20px; font-weight:800; padding-top:80px;'>$message</p>"; } ?>  
            </div>

          

            <div class="simple-footer" style='margin-top:300px'>
              Copyright &copy; Stalo Technology 2024
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <!-- Page Specific JS File -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <!-- Custom JS File -->
  <script src="assets/js/custom.js"></script>
</body>


<!-- subscribe.html  21 Nov 2019 04:05:02 GMT -->
</html>