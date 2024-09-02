<?php include 'database.php' ?>
<?php
$query = "SELECT * FROM settings";
$select_exam_query = mysqli_query($connection, $query);

if(!$select_exam_query){
    die("QUERY FAILED". mysqli_error($connection));
}

while($row = mysqli_fetch_assoc($select_exam_query)) {

    $_SESSION['institution_name'] = $row['institution_name'];
    $_SESSION['institution_logo'] = $row['institution_logo'];
    $_SESSION['institution_slogan'] = $row['institution_slogan'];

}
?>

<!DOCTYPE html>
<html lang="en">
<!-- subscribe.html  21 Nov 2019 04:05:02 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Computer Based Test - Admin Dashboard Template</title>
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
                <p>Login To Start Exam</p>
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Please Enter Your Reg Number</h4>
              </div>
              <h4 class="text-center"><?php login_user('students'); ?></h4>
              <div class="card-body">
                <form action=""  method="POST">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-user"></i>
                        </div>
                      </div>
                      <input id="reg_no" type="text" class="form-control" name="reg_no" placeholder="Reg Number" autocomplete="off" />
                    </div>
                  </div>
                  <div class="form-group text-center">
                    <button name="login" type="submit" class="btn btn-lg btn-round btn-primary">
                      Login
                    </button>
                  </div>
                </form>
              </div>
            </div>
            <div class="simple-footer">
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