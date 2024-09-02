<?php
        if(isset($_POST['updatePass'])){
          $upload_dir = "adminImage/";
          if (($_FILES["passport"]["type"] == "image/gif") ||
              ($_FILES["passport"]["type"] == "image/jpeg") ||
              ($_FILES["passport"]["type"] == "image/png") ||
              ($_FILES["passport"]["type"] == "image/pjpeg")) {
              $file_name = $_FILES["passport"]["name"];
              $extension = end((explode(".", $file_name)));
              $upload_file = $upload_dir.$file_name;
              $move = move_uploaded_file($_FILES['passport']['tmp_name'],$upload_file);
              if($move){
                  $source_image = $upload_file;
                  $image_destination = $upload_dir."admin-".$file_name;
                  $compress_images = compressImage($source_image, $image_destination);
                  unlink($source_image);
                  if (empty($errors) === true){
                      $update_query = "UPDATE `admins` SET `passport`='$image_destination' WHERE `name`='Administrator' ";
                      $update_pass = $mysqli->query($update_query) or die($mysqli->error.__LINE__);
                  }
              }else {
                  $errors[] = 'Image Upload Failed';
              }
          } else {
              $errors[] = "Upload only jpg or gif or png file type";
          }}
        ?>
<div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" data-toggle="tooltip" data-placement="right"
                      title="Hide Sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn" data-toggle="tooltip" data-placement="right"
                      title="Maximize">
                <i data-feather="maximize"></i>
              </a></li>
            <li>
              <form class="form-inline mr-auto">
                <div class="search-element">
                  <input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="200">
                  <button class="btn" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                </div>
              </form>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="<?php echo $passport?>"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello Administrator</div>
              <a href="#" data-toggle="modal" data-target="#exampleModal" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                Upload Admin Passport
              </a> 
              <div class="dropdown-divider"></div>
              <a href="logout.php?type=adminLogin.php" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
            </div>
          </li>
        </ul>
      </nav>

      <!-- Modal with form -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="formModal"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="formModal">Change Admin Image</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form class="" action="" method="post" enctype="multipart/form-data">
                  <div class="form-group">
                    <label>Upload Passport</label>
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <div class="input-group-text">
                          <i class="fas fa-user"></i>
                        </div>
                      </div>
                      <input type="file" required class="form-control" placeholder="" name="passport">
                    </div>
                  </div>
                  
                  <button type="submit" name="updatePass" class="btn btn-primary m-t-15 waves-effect">Submit</button>
                </form>
              </div>
            </div>
          </div>
        </div>

        