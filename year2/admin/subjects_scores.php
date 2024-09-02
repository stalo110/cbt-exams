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
//    $select_sub_query = mysqli_query($connection, $query);
    $class = $result->fetch_assoc();
}


if(isset($_POST['submit'])) {
    // $course_code = sanitize(strtoupper($_POST['course_code']));
    $course_title = sanitize($_POST['course_title']);
    $exam_time = sanitize($_POST['exam_time']);
     $id = $_POST['id'];

     $query = "UPDATE courses SET course_title = '$course_title',
    exam_time = '$exam_time' WHERE id=$id";
    //Run query
    $update_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
}

if(isset($_POST['addCourse'])) {
    $course_title = sanitize($_POST['subject_title']);
    $course_name = sanitize($_POST['subject_title']);
    $exam_time = sanitize($_POST['exam_time']);
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
        VALUES('$course_title', '$course_name', '$class_id', '$exam_time', '$year', '$status', '$lecturers_id')";
        //Run query
        $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
    } else {
        $errors[] = 'Opps, The Subject \'' . $course_title . '\' Has Been Added For This Class Already .';
    }
}
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-3 col-lg-3"></div>
            <div class="col-12 col-md-3 col-lg-3"></div>
            <div class="col-12 col-md-3 col-lg-3"></div>
            <div class="col-12 col-md-3 col-lg-3">
                <span style="margin-left:50px">
                    <form action="" class="form-horizontal">
                        <div class="form-group ">
                            <select class="form-control" onchange="location = this.value;" name="subject_code">
                                <option>Select Class</option>
                                <option value="subjects_scores.php">All Class Exam</option>
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
                                    <option  value="subjects_scores.php?id=<?php echo $cl_id ?>"><?php echo $name ?></option>
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
                            <h3 class="text-uppercase">LIST OF <?php echo $class['name'] ?>  EXAMS SCORES</h3>
                    <?php } else{ ?>
                            <h3 class="text-uppercase">LIST OF ALL CLASS EXAMS SCORES</h3>
                    <?php } ?>
                  </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-bordred table-striped" id="documents">
                                        <thead>
                                            <tr>
                                                <th>Class</th>
                                                <th>Subject Title</th>
                                                <th>Year</th>
                                                <th>Exam Time</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(isset($_GET['id'])){
                                                $class_main_id = $_GET['id'];
                                                $query = "SELECT * FROM courses WHERE class_id = $class_main_id AND active = 1";
                                            }else {
                                                $query = "SELECT * FROM courses WHERE  active = 1";
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
                                                //    $select_sub_query = mysqli_query($connection, $query);
                                                $c = $result->fetch_assoc();
                                                $c_name = $c['name'];
                                                echo "<td> $c_name </td>"
                                                ?>
                                                <td><?php echo $row['course_title'] ?></td>
                                                <td><?php echo $row['year'] ?></td>
                                                <td><?php echo $row['exam_time'] ?> minutes</td>
                                            <td><a class="btn btn-success btn-xs" href="sub_score.php?id=<?php echo $row['id'] ?>">View Scores</a></td>
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
        </div>
    </div>
</section>
<?php
if(isset($_GET['toggleStatus'])){
$the_course_id = sanitize($_GET['toggleStatus']);
$activate = sanitize($_GET['activate']);

$query = "UPDATE courses SET active = '{$activate}' WHERE id = '{$the_course_id}'";
$reset_query = mysqli_query($connection, $query);
header("Location: subjects.php");
}
?>
<?php include "includes/footer.php"?>     
<script>
    $(document).ready(function(){
        $(".classSelect").change(function () {
            className = $(this).children(':selected').text();
            $(this).next('input').val(className);
        });
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");
            var delete_url = "students.php?delete="+ id +" ";
            $(".modal_delete_link").attr("href", delete_url);
            $("#myModal").modal('show');
        });
        $('#documents').DataTable( {
            "lengthMenu": [ 50, 100, 150, 200],
        } );
    });
</script>