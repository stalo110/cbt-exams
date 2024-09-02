<?php include 'database.php' ?>
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
              Online Examination System
            </div>
            <div class="card card-primary">
              <div class="card-header">
                <h4>Please Enter Your Admin Access Code</h4>
              </div>
              <h4 class="text-center"><?php login_admin('admin'); ?>
              <div class="card-body">
                <form action=""  method="POST">
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-envelope"></i>
                        </div>
                      </div>
                      <input id="reg_no" type="password" autocomplete="off" class="form-control" name="access_code" autofocus placeholder="Access Code">
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
              Copyright &copy; Valex Tech Hub 2022
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