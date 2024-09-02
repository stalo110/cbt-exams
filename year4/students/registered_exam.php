<?php include "includes/header.php"?>
<?php
if(isset($_POST['addSubject'])) {
    $subject_id = $_POST['subject_id'];
    $student_id = $_SESSION['userid'];


//    if (user_exit('courses', 'course_code', $course_code ) == 0) {

$registered_query = "SELECT * FROM registered_exams
					   WHERE student_id = $student_id AND course_id = $subject_id";

// Get result
$registeredResult = $mysqli->query($registered_query) or die($mysqli->error);

if($registeredResult->num_rows < 1){

        //Add Course query
        $query = "INSERT INTO `registered_exams`(student_id, course_id) 
        VALUES('$student_id', '$subject_id')";

        //Run query

        $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);

    } else {
        $errors[] = 'Opps, The Subject You Tried Adding, Has Been Added Already .';


    }




}
?>
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

                                        <?php if($row['profile_pic'] == "" || $row['profile_pic'] == 'passport.jpg'){ ?>
                                            <img class="img-responsive" width="100%" src="images/images.jpg">
                                        <?php }else {  ?>
                                            <img class="student-img" height="100" width="100" src="<?php echo $row['profile_pic']; ?>">
                                        <?php } ?>
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
                            <h6>Class : <?php echo $student_class?></h6>
                            <?php } ?>
                        </div>
                        <hr class="row">
                        <h5 class="side-title">Registered Subjects</h5>
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
                            <h3><li class="list-item" style="margin-top: 5px; background-color:yellow; color:#000; font-weight:bold; font-size:15px; padding:25px; border-radius:25px;"> 
                                <?php echo $course_name ?>  <span class="pull-right"><a class="" style="color:#000;"  href="pre_start.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>">Continue <i class="fa fa-undo"></i></a> </span>
                            </li><h3/>
                            <?php } elseif (definite_exit('scores','student_id',$student_id,'course_id', $exam_id)){ ?>
                            <h3><li class="list-item" style="margin-top: 5px; background-color:#d9534f; color:#fff; font-weight:bold; font-size:15px; padding:25px; border-radius:25px; text-decoration: line-through">
                                <?php echo $course_name ?>  <span class="pull-right" style="color:#fff;" >Taken <i class="fa fa-check"></i></span>
                            </li><h3/>
                            <?php }else { ?>
                            <h3><li class="list-item" style="margin-top: 5px; background-color:#5cb85c; color:#fff; font-weight:bold; font-size:15px; padding:25px; border-radius:25px;">
                                <?php echo $course_name ?>  <span class="pull-right"><a class="" style="color:#fff; font-size:25px" href="pre_start.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>">Start</a> <i class="fa fa-pencil" ></i></span>
                            </li></h3>
                            <?php }}else { ?>
                            <h3><li class="list-item" style="margin-top:5px; background-color:pink; color:#000; font-weight:bold; padding:25px; font-size:15px; border-radius:25px;">
                                <?php echo $course_name ?>  <span class="pull-right"><a href="" style="color:#000;">Not Active <i class="fa fa-lock"></i></a> </h3></span>
                            </li></h3>
                            <?php }}} ?>
                        </ul>
                        <div class="text-center">
                            <?php if($select_user_query->num_rows < 4){ ?>
                            <p class="text-danger">Click The Button Below To Add Subject</p>
                            <a class="btn btn-success" href="registered_exam.php" >Update Subjects</a>
                            <?php } else { ?>
                            <a class="btn btn-xs btn-success" href="registered_exam.php">Update Subjects</a>
                            <?php } ?>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-9 col-lg-9">
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
                    <div class="row">
                        <div class="col-12">
                        <a href="index.php" class="btn btn-outline-primary btn-xs"  >Go Back</a>
                        <button class="btn btn-outline-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#addCourse" >ADD Subject</button>
                        </div>
                    </div><br>
                    
                    <?php

if(isset($_POST['submit'])){ ?>

    <div class="alert alert-success"><span class=""></span> <?php echo $course_title ?> updated successfully </div>
<?php }
?>

<?php
if(isset($_POST['addSubject'])){ ?>
    <?php if(isset($errors)){
        echo output_errors($errors);
    } else if (empty($errors) === true){ ?>
        <div class="alert alert-success"><span class=""></span> Subject Added successfully </div>
    <?php } }
?>
                <div class="card card-primary">
                <div class="card-header">
                    <h4>Exam Instruction</h4>
                </div>
                <div class="card-body">
                <div class="table-responsive">
                      <table class="table table-striped" id="documents">
                        <thead>
                        <tr>
                                    <th>S/N</th>
                                    <th>Subject</th>
                                    <th>Action</th>
                                </tr>
                        </thead>
                        <tbody>
                        <?php


                                $query = "SELECT * FROM registered_exams WHERE student_id = '{$student_id}'";
                                $select_user_query = mysqli_query($connection, $query);

                                if(!$select_user_query){
                                    die("QUERY FAILED". mysqli_error($connection));
                                }

                                
$count = 0;
                                while($row = mysqli_fetch_array($select_user_query)){

                                $course_id = $row['course_id'];
                                $r_id = $row['id'];

                                $query = "SELECT * FROM courses WHERE id = '{$course_id}'";
                                $select_course_query = mysqli_query($connection, $query);

                                if(!$select_course_query){
                                    die("QUERY FAILED". mysqli_error($connection));
                                }

                                while($row = mysqli_fetch_array($select_course_query)) {
                                $subject_id = $row['subject_id'];
                                $course_title = $row['course_title'];
                                $course_name = $row['course_name'];

                                $exam_id = $row['id'];

                                
                                


                                $date = date('Y-m-d', time());

                              

$count++;

                                ?>

<tr>
    
    <td><?= $count?> </td>
    <td><?php echo $course_name ?></td>
    <td>
        <a rel='<?php echo $r_id ?>' href='javascript:void(0)' class='delete_link pull-right'><button class="btn btn-xs btn-danger">Remove Subject</button> </a>
    </td>

</tr>
                                <?php } }?>

<?php 
    if($select_user_query->num_rows < 3){

                                    echo "<p class='text-center'>Click The Add Subject To Add Subjects</p>";
 
                                }

?>
                        </tbody>
                      </table>
                    </div>
                   
                </div>
                </div>
            </div>
            
        </div>
    </div>
</section>

<div id="mModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <!--        modal content-->
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title">Remove Subject</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h5>Are you Sure You Want To Remove This Subject From Your Registered Subject ?</h5>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-danger modal_delete_link">Remove</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addCourse" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h4 class="modal-title custom_align" id="Heading">Add Subject</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times" aria-hidden="true"></span></button>
                
            </div>
            <div class="modal-body">

                <form action="" method="post">
                    <div class="modal-body">


                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div class="form-group">
                                    <label for="username">Subject</label>
                                    <select required class="form-control" name="subject_id" id="">

<?php


$query = "SELECT * FROM courses WHERE active = '1' AND class_id = $class_id";
$select_course_query = mysqli_query($connection, $query);

if(!$select_course_query){
    die("QUERY FAILED". mysqli_error($connection));
}

while($row = mysqli_fetch_array($select_course_query)) {

    $subject_id = $row['subject_id'];
    $course_title = $row['course_name'];


?>

                                        <option value="<?php echo $row['id'] ?>"> <?php echo $course_title ?> </option>


<?php } ?>


                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer ">

                        <input type="hidden" name="id" value="" />
                        <input type="submit" class="btn btn-success" name="addSubject" value="Add Subject" />
                    </div>
                </form>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
</div>

<?php

if(isset($_GET['delete'])){
    $the_exam_id = sanitize($_GET['delete']);

    $query = "DELETE FROM registered_exams WHERE id = {$the_exam_id} ";
    $delete_query = mysqli_query($connection, $query);
    header("Location: registered_exam.php");
}

?>
                   
        <?php include "includes/footer.php"?>
        <script>


    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");

            var delete_url = "registered_exam.php?delete="+ id +" ";

            $(".modal_delete_link").attr("href", delete_url);

            $("#mModal").modal('show');


        });
    });


</script>