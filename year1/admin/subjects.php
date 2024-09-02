<?php include "includes/header.php"?>
<?php

$year = date('Y', time());

$class_query = "SELECT * FROM class";
$select_class_query = mysqli_query($connection, $class_query);

if(!$select_class_query){
    die("QUERY FAILED". mysqli_error($connection));
}

$sub_query = "SELECT * FROM subjects";
$select_sub_query = mysqli_query($connection, $sub_query);

if(!$select_sub_query){
    die("QUERY FAILED". mysqli_error($connection));
}


if(isset($_GET['id'])){
    $class_id = (int) $_GET['id'];
    $query = "SELECT * FROM class WHERE id = $class_id";
    $result = $mysqli->query($query) or die($mysqli->error);
    $class = $result->fetch_assoc();
}


if(isset($_POST['submit'])) {
    // $course_code = sanitize(strtoupper($_POST['course_code']));
    $course_title = sanitize($_POST['course_title']);
    $exam_time = sanitize($_POST['exam_time']);
     $id = $_POST['id'];
     $query = "UPDATE courses SET course_title = '$course_title',
    exam_time = '$exam_time' WHERE id=$id";
    $update_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
}

if(isset($_POST['addCourse'])) {
    $course_title = sanitize($_POST['subject_title']);
    $course_name = sanitize($_POST['subject_title']);
    $exam_time = sanitize($_POST['exam_time']);
    $C_ident = sanitize($_POST['class_identity']);
    $status = sanitize($_POST['status']);
    $class_id = sanitize($_POST['class_id']);
    $class_name = sanitize($_POST['class_name']);
    $course_title = strtoupper($class_name.'_'.$course_title);
    $lecturers_id = 0;
    $course_query = "SELECT * FROM courses WHERE course_title = '$course_title' AND class_id = $class_id";
    $results = $connection->query($course_query) or die($connection->error . __LINE__);
    if ($results->num_rows == 0) {
        //Add Course query
        $query = "INSERT INTO `courses`(course_title, course_name, class_id, exam_time, year, active, lecturers_id) 
        VALUES('$course_title', '$course_name', '$class_id', '$exam_time','$year', '$status', '$lecturers_id')";
        $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
    } else {
        $errors[] = 'Opps, The Subject \'' . $course_title . '\' Has Been Added For This Class Already .';
    }
}
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Add Exam</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Subject</label>
                            <select required class="form-control" name="subject_title">
                                           <?php

                                           while($row = mysqli_fetch_array($select_sub_query)) {

                                           $name = $row['name'];
                                           ?>
                                           <option value="<?php echo $name ?>"><?php echo $name ?></option>
                                           <?php } ?>
                                       </select>
                        </div>
                        <div class="form-group ">
                                       <label>Class</label>
                                       <select required class="form-control classSelect" name="class_id">

                                           <?php

                                           if(isset($_GET['id'])) { ?>

                                           <option value="<?php echo $class['id'] ?>"><?php echo $class['name'] ?></option>

                                           <?php }else { ?>
                                               <option selected value="">Select Class</option>
                                           <?php
                                           while($row = mysqli_fetch_array($select_class_query)) {

                                               $name = $row['name'];
                                               $id = $row['id'];

                                               ?>

                                               <option value="<?php echo $id ?>"><?php echo $name ?></option>



                                           <?php } }?>

                                       </select>

                                       <input type="hidden" name="class_name" value="<?php if(isset($_GET['id'])) { echo $class['name']; } ?>">

                                   </div>
                                   <div class="form-group">
                                       <label>Exam Time (in minutes)</label>
                                       <input class="form-control " name="exam_time" value=""  type="number" placeholder="Exam">
                                   </div>

                                   <div class="form-group ">
                                       <label>Status</label>
                                       <select required class="form-control" name="status">
                                           <option value="1">Active</option>
                                           <option value="0">Not Active</option>
                                       </select>
                                   </div>
                        <div class="modal-footer">
                        <input type="hidden" name="id" value="" />
                                   <input type="submit" class="btn btn-success" name="addCourse" value="Add Subject" />
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
              </div>
            </div>
          </div>
        </div>
<!-- <section class="section"> -->
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6"></div>
            <div class="col-12 col-md-6 col-lg-6">
                <span style="margin-left:50px">
                    <form action="" class="form-horizontal">
                        <div class="form-group ">
                            <select class="form-control" onchange="location = this.value;" name="subject_code">
                                <option>Select Class</option>
                                <option value="subjects.php">All Class Exam</option>
                                <?php
                                $class_query = "SELECT * FROM class";
                                $select_class_query = mysqli_query($connection, $class_query);
                                if(!$select_class_query){
                                    die("QUERY FAILED". mysqli_error($connection));
                                }
                                while($row = mysqli_fetch_array($select_class_query)) {
                                    $cl_id = $row['id'];
                                    $name = $row['name'];
                                    ?>
                                    <option  value="subjects.php?id=<?php echo $cl_id ?>"><?php echo $name ?></option>
                                    <?php } ?>
                            </select>
                        </div>
                    </form>
                </span>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                    <?php
                        if(isset($_GET['id'])){ ?>
                            <h3>List Of Available  <?php echo $class['name'] ?>  Exams  <span><button style="margin-left:800px;margin-top:-70px" class="btn btn-primary btn-sm" type="button" data-target=".bd-example-modal-lg" data-toggle="modal">ADD <?php echo $class['name'] ?> Exam</button></span></h3>
                    <?php } else{ ?>
                            <h3>List Of All Class Exams <span><button style="margin-left:550px" class="btn btn-primary btn-sm" type="button" data-toggle="modal" data-target=".bd-example-modal-lg">ADD Exam</button></span> </h3>
                    <?php } ?>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="documents">
                                <thead>
                                    <tr>
                                        <th>Class</th>
                                        <th>Subject Title</th>
                                        <th>Year</th>
                                        <th>Exam Time</th>
                                        <th>Status</th>
                                        <th>Edit</th>
                                        <th>Set Exam</th>
                                        <th>Upload CSV</th>
                                        <th>View Questions</th>
                                        <th>Action</th>
                                        <th></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(isset($_GET['id'])){
                                        $class_main_id = $_GET['id'];
                                        $query = "SELECT * FROM courses WHERE class_id = $class_main_id";
                                    }else {
                                        $query = "SELECT * FROM courses";
                                    }
                                    $select_courses_query = mysqli_query($connection, $query);
                                    if(!$select_courses_query){
                                        die("QUERY FAILED". mysqli_error($connection));
                                    }
                                    while($row = mysqli_fetch_array($select_courses_query)) {
                                        $c_id = $row['class_id']
                                        ?>
                                    <tr>
                                        <?php
                                            $query = "SELECT name FROM class WHERE id = $c_id";
                                            $result = $mysqli->query($query) or die($mysqli->error);
                                            $c = $result->fetch_assoc();
                                            $c_name = $c['name'];
                                            echo "<td> $c_name </td>"
                                        ?>
                                        <td><?php echo $row['course_title'] ?></td>
                                        <td><?php echo $row['year'] ?></td>
                                        <td><?php echo $row['exam_time'] ?> minutes</td>
                                        <td><?php if($row['active'] == 1){ echo "Active"; }else{ echo "Not Active"; } ?></td>
                                        <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit<?php echo $row['id'] ?>" ><span class="fa fa-edit"></span></button></p></td>
                                        <td><a class="btn btn-success btn-xs" href="set_questions.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $row['id'] ?>&c_id=<?php echo $c_id ?>">Set Question</a></td>
                                        <td><a class="btn btn-primary btn-xs" href="upload.php?class=<?php echo $c_name ?>&sub=<?php echo $row['course_title'] ?>&id=<?php echo $row['id'] ?>&c_id=<?php echo $c_id ?>">Upload CSV</a></td>
                                        <td><a class="btn btn-info btn-xs" href="exam_qus.php?id=<?php echo $row['id'] ?>&c_id=<?php echo $c_id ?>">View Questions</a></td>
                                        <td><a class="btn btn-warning btn-xs" href="students.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $row['id'] ?>">Assign Class</a></td>

                                        <div class="modal fade" id="edit<?php echo $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="mySmallModalLabel">Edit Course</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <form action="" method="post">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Class</label>
                                                            <input class="form-control" value="<?php echo $c_name ?>" disabled type="text" placeholder="Subject Id">
                                                            <input class="form-control" name="class_id" value="<?php echo $c_id ?>" type="hidden">
                                                        </div>


                                                        <div class="form-group">
                                                            <label>Subject</label>


                                                            <select required class="form-control" name="course_title">

                                                                <option value="<?php echo $row['course_title'] ?>"><?php echo $row['course_title'] ?></option>

                                                                <?php

                                                                $sub_query = "SELECT * FROM subjects";
                                                                $select_sub_query = mysqli_query($connection, $sub_query);

                                                                if(!$select_sub_query){
                                                                    die("QUERY FAILED". mysqli_error($connection));
                                                                }
                                                                while($sub_row = mysqli_fetch_array($select_sub_query)) {

                                                                    $name = $sub_row['name'];
                                                                    ?>
                                                                    <option value="<?php echo $name ?>"><?php echo $name ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>

                                                        <div class="form-group">
                                                            <label>Exam Time (in minutes)</label>
                                                            <input class="form-control " name="exam_time" value="<?php echo $row['exam_time'] ?>"  type="number" placeholder="End Time">
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer ">

                                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>" />
                                                        <input type="submit" class="btn btn-success" name="submit" value="submit" />
                                                    </div>
                                                    </form>
                                                </div>
                                                <!-- /.modal-content -->
                                            </div>
                                            <!-- /.modal-dialog -->
                                        </div>

                                            <td>
                                                                <form action="" method="post">
                                                                    <?php if($row['active'] == 0){ ?>
                                                                        <a class="btn btn-secondary" href="subjects.php?toggleStatus=<?php echo $row['id'] ?>&activate=1">Activate Exam</a>
                                                                    <?php }else { ?>

                                                                        <a class="btn btn-danger" href="subjects.php?toggleStatus=<?php echo $row['id'] ?>&activate=0">Deactivate Exam</a>
                                                                    <?php } ?>
                                                                </form>


                                                            </td>
                                        <td><a class="btn btn-danger" href="subjects.php?deleteExam=<?php echo $row['id'] ?>">Delete Exam</a></td>

                                    </tr>




                                    <?php } ?>
                                </tbody>
                            </table>
                            <?php if($select_courses_query->num_rows == 0){ ?>
                                <div class="alert alert-info">
                                    <p>No Class Exam Has Been Added Yet</p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- </section> -->
<?php
if(isset($_GET['toggleStatus'])){
$the_course_id = sanitize($_GET['toggleStatus']);
$activate = sanitize($_GET['activate']);

$query = "UPDATE courses SET active = '{$activate}' WHERE id = '{$the_course_id}'";
$reset_query = mysqli_query($connection, $query);
header("Location: subjects.php");
}

if(isset($_GET['deleteExam'])){
    $the_course_id = sanitize($_GET['deleteExam']);
    
    $query = "DELETE FROM `courses` WHERE id = '{$the_course_id}'";
    $reset_query = mysqli_query($connection, $query);
    header("Location: subjects.php");
    }
?>


           
        
        <?php include "includes/footer.php"?>
        <script>
            $(document).ready(function(){
                $(".classSelect").change(function () {
                    className = $(this).children(':selected').text();
                    console.log(className);
                    /*
                    $(".one option:selected").each(function () {
                        Price = newPrice*$(".unit").val();
                    });*/

                    $(this).next('input').val(className);
                });


                $('#documents').DataTable( {
                    "lengthMenu": [ 50, 100, 150, 200],

                } );
            })
        </script>