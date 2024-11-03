<?php include "includes/header.php"?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-3 col-lg-3">
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Student Info</h4>
                    </div>
                    <div class="card-body">
                        <div class=" col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <div class="row col-sm-8 col-sm-offset-2">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <?php
                                            $query = "SELECT * FROM students WHERE reg_no = '{$reg_no}' LIMIT 1";
                                            $select_user_query = mysqli_query($connection, $query);

                                            if(!$select_user_query){
                                                die("QUERY FAILED". mysqli_error($connection));
                                            }

                                            while($row = mysqli_fetch_array($select_user_query)){
                                                $first_name = $row['first_name'];
                                                $last_name = $row['last_name'];
                                                $name = $first_name . ' '. $last_name;
                                                $matric_no = $row['reg_no'];
                                                $class = $row['class'];
                                        ?>

                                            <?php 
                                            $profile_photo = $row['profile_photo']; 
                                            $default_photo = "../admin/uploads/default_photo.jpg";
                                            if (empty($profile_photo) || $profile_photo == '../admin/uploads/default_photo.jpg') { 
                                                echo '<img class="img-responsive" width="100%" src="'.$default_photo.'">';
                                            } else {  
                                                $full_photo_path = '../admin/' . $profile_photo;
                                                echo '<img class="student-img" height="100" width="100" style="border-radius: 50%" src="'. $full_photo_path .'">';
                                            } 
                                        ?>



                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h5>Name : <?php echo $name ?></h5>
                            <h6>Reg Number : <?php if(preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $matric_no)){
                                echo "$matric_no";
                            }else {
                                echo "<br><span class='text-danger'>Reg_No Not Valid</span>";
                            }

                             ?></h6>
                            <h6>Class : <?php echo $class?></h6>
                            <?php } ?>
                        </div>
                        <hr class="row">
                        <h5 class="side-title">Registered Subjects<a href="" class="pull-right"><i class="fa fa-refresh"
                                    aria-hidden="true"></i></a></h5>
                        <ul class="list-unstyled exam-list">
                            <?php
                                $query = "SELECT * FROM registered_exams WHERE student_id = '{$student_id}'";
                                $select_user_query = mysqli_query($connection, $query);
                                if(!$select_user_query){
                                    die("QUERY FAILED". mysqli_error($connection));
                                }
                                if($select_user_query->num_rows < 1){
                                    echo '
                                    <p class="text-center"><br><span class="text-danger">You Dont Have Any Registered Subject</span> <br><br>
                                    <a class="btn btn-success" href="registered_exam.php">Add Subjects</a></p>';
                                } else { 
                                while($row = mysqli_fetch_array($select_user_query)){
                                $course_id = $row['course_id'];
                                $query = "SELECT * FROM courses WHERE id = '{$course_id}'";
                                $select_course_query = mysqli_query($connection, $query);
                                if(!$select_course_query){
                                    die("QUERY FAILED". mysqli_error($connection));
                                } 
                                while($row = mysqli_fetch_array($select_course_query)) {
                                $course_title = $row['course_title'];
                                $course_name = $row['course_name'];
                                $status = $row['active'];
                                $exam_time = $row['exam_time'];
                                $exam_id = $row['id'];
                                $subject_id = $row['subject_id'];
                                if($status == 1){
                            ?>
                            <?php if(definite_exit('current_students','st_id',$student_id,'exam_id', $exam_id)){ ?>
                            <h3>
                                <li class="list-item"
                                    style="margin-top: 5px; background-color:yellow; color:#000; font-weight:bold; font-size:15px; padding:25px; border-radius:25px;">
                                    <?php echo $course_name ?> <span class="pull-right"><a class="" style="color:#000;"
                                            href="pre_start.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>">Continue
                                            <i class="fa fa-undo"></i></a> </span>
                                </li>
                                <h3 />
                                <?php } elseif (definite_exit('scores','student_id',$student_id,'course_id', $exam_id)){ ?>
                                <h3>
                                    <li class="list-item"
                                        style="margin-top: 5px; background-color:#d9534f; color:#fff; font-weight:bold; font-size:15px; padding:25px; border-radius:25px; text-decoration: line-through">
                                        <?php echo $course_name ?> <span class="pull-right" style="color:#fff;">Taken <i
                                                class="fa fa-check"></i></span>
                                    </li>
                                    <h3 />
                                    <?php }else { ?>
                                    <h3>
                                        <li class="list-item"
                                            style="margin-top: 5px; background-color:#5cb85c; color:#fff; font-weight:bold; font-size:15px; padding:25px; border-radius:25px;">
                                            <?php echo $course_name ?> <span class="pull-right"><a class=""
                                                    style="color:#fff; font-size:25px"
                                                    href="pre_start.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>">Start</a>
                                                <i class="fa fa-pencil"></i></span>
                                        </li>
                                    </h3>
                                    <?php }}else { ?>
                                    <h3>
                                        <li class="list-item"
                                            style="margin-top:5px; background-color:pink; color:#000; font-weight:bold; padding:25px; font-size:15px; border-radius:25px;">
                                            <?php echo $course_name ?> <span class="pull-right"><a href=""
                                                    style="color:#000;">Not Active <i class="fa fa-lock"></i></a>
                                    </h3></span>
                                    </li>
                                </h3>
                                <?php }}} ?>
                        </ul>
                        <div class="text-center">
                            <?php if($select_user_query->num_rows < 4){ ?>
                            <p class="text-danger">Click The Button Below To Add Subject</p>
                            <a class="btn btn-success" href="registered_exam.php">Update Subjects</a>
                            <?php } else { ?>
                            <a class="btn btn-xs btn-success" href="registered_exam.php">Update Subjects</a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-lg-6">
                <?php
                        if(isset($_POST['submit'])) {
                                $s_reg_no = sanitize(strtoupper($_POST['reg_no']));
                                $s_class = sanitize($_POST['class']);
                                $first_name = sanitize($_POST['first_name']);
                                $last_name = sanitize($_POST['last_name']);
                                $s_institution = sanitize($_POST['institution']);
                                if($reg_no != $s_reg_no){
                                    if (user_exit('students', 'reg_no', $s_reg_no ) > 0) {

                                        $errors[] = "Sorry, The Reg No  $s_reg_no  is Already Registered.";
                                    }
                        }
                                    
                        
                        if (empty($errors) === true && empty($_POST) === false) {
                            $query = "UPDATE students SET first_name = '$first_name', reg_no = '$s_reg_no', last_name = '$last_name', class = '$s_class' WHERE id = $student_id";
                            //Run query
                            $update_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
                            if($reg_no != $s_reg_no){
                                redirect("logout.php?type=login.php");
                            }
                        }
                        }
                            if(isset($_POST['updatePass'])){
                            $upload_dir = "images/";
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
                                    $image_destination = $upload_dir."min-".$file_name;
                                    $compress_images = compressImage($source_image, $image_destination);
                                    unlink($source_image);
                                    if (empty($errors) === true){
                                        $update_query = "UPDATE students SET profile_pic = '$image_destination' WHERE reg_no = '$reg_no' ";
                                        $update_pass = $mysqli->query($update_query) or die($mysqli->error.__LINE__);
                                    }
                                }else {
                                    $errors[] = 'Image Upload Failed';
                                }
                            } else {
                                $errors[] = "Upload only jpg or gif or png file type";
                            }}
                    ?>
                <div class="card card-primary">
                    <div class="card-header">
                        <h4>Exam Instruction</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if(isset($_POST['submit'])){ ?>
                        <?php if(isset($errors)){
                            echo output_errors($errors);
                        } else if (empty($errors) === true){ ?>
                        <div class="alert alert-success"><span class=""></span> Your Information Has Been Updated
                            Successfully </div>
                        <?php } }
                    ?>
                        <div class="row">
                            <div class="col-6">
                                <button type="button" class="btn  btn-outline-primary btn-sm" data-title="Edit"
                                    data-toggle="modal" data-target="#editInfo">Edit Registration Details <span
                                        class="fa fa-edit"></span></button>
                            </div>
                        </div><br>
                        <div class="row" style="background-color:#5cb85c; padding:8px; color:#fff; border-radius:10px;">
                            <marquee behaviour="scroll" scrollamount="4">
                                <h4>Kindly Click on Start button at the left hand side of the screen to write the
                                    subjects you have for the day</h4>
                            </marquee>
                        </div>
                        <div style="margin-top: 400px"></div>
                        <hr class="row">
                        <?php 

                                if($class == ""){ ?>
                        <div class="alert alert-danger"><span class=""></span>
                            You Can not Print Your Registration Slip, Pls Update Your Missing Informations or Subjects
                            To Enable Slip Print Out
                        </div>
                        <?php } else {  ?>
                        <div class="text-center">
                            <a class="btn btn-success" href="slip.php?reg_no=<?php echo $reg_no ?>">Print Registration
                                Slip</a>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-3">
                <div class="card card-info">
                    <div class="card-header">
                        <h4>Keyboard Usage</h4>
                    </div>
                    <div class="card-body">
                        <ul class="list-styled">
                            <li class="list-item"><button class="btn btn-primary">A</button> Select Option A</li><br>
                            <li class="list-item"><button class="btn btn-primary">B</button> Select Option B</li><br>
                            <li class="list-item"><button class="btn btn-primary">C</button> Select Option C</li><br>
                            <li class="list-item"><button class="btn btn-primary">D</button> Select Option D</li><br>
                            <li class="list-item"><button class="btn btn-primary">K</button> Use App Calculator</li><br>
                            <li class="list-item"><button class="btn btn-primary">N</button> Next Question</li><br>
                            <li class="list-item"><button class="btn btn-primary">P</button> Previous Question</li><br>
                            <li class="list-item"><button class="btn btn-warning"><span
                                        class="fa fa-arrow-right"></span></button> Next Question</li><br>
                            <li class="list-item"><button class="btn btn-warning"><span
                                        class="fa fa-arrow-left"></span></button> Previous Question</li><br>
                            <li class="list-item"><button class="btn btn-danger">S</button> Submit Exam</li><br>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="modal fade" id="editInfo" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title custom_align" id="Heading">Edit Users Information</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times"
                        aria-hidden="true"></span></button>
            </div>
            <form action="" method="post">
                <div class="modal-body">

                    <div class="form-group">
                        <label>Reg No</label>
                        <input class="form-control " name="reg_no" value="<?php echo $reg_no ?>" type="text"
                            placeholder="Pls Enter Your First Name">
                    </div>

                    <div class="form-group">
                        <label>First Name</label>
                        <input class="form-control " name="first_name" value="<?php echo $first_name ?>" type="text"
                            placeholder="Pls Enter Your First Name">
                    </div>

                    <div class="form-group">
                        <label>Last Name</label>
                        <input class="form-control " name="last_name" value="<?php echo $last_name ?>" type="text"
                            placeholder="Pls Enter Your Last Name">
                    </div>

                    <div class="form-group">
                        <label>Class</label>
                        <input class="form-control " name="class" value="<?php echo $class ?>" type="class"
                            placeholder="Pls Enter Your class">
                    </div>
                </div>
                <div class="modal-footer ">
                    <input type="submit" class="btn btn-success" name="submit" value="submit" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>



<div class="modal fade" id="editPass" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title custom_align" id="Heading">Upload Passport</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times"
                        aria-hidden="true"></span></button>
            </div>
            <form action="" method="post" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row">
                        <div class=" col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label class="row col-sm-7 control-label" for="textinput">Passport : <span
                                        class="text-danger">*</span></label>
                                <div class="row col-sm-6">
                                    <div class="panel panel-default">
                                        <div class="panel-body">
                                            <img class="img-responsive" src="images/images.jpg">
                                            <input type="file" name="passport" id="passport"
                                                value="<?php if(isset($_POST['register'])){ echo $_POST['passport'];}  ?>"
                                                class="form-control" placeholder="Passport" tabindex="1" required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><br>
                    </div><br>
                </div>
                <div class="modal-footer ">
                    <input type="submit" class="btn btn-success" name="updatePass" value="Update Passport" />
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php include "includes/footer.php"?>