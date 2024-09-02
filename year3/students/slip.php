<?php include "includes/header.php"?>
<?php

if(!logged_in()){
    redirect('login.php');
}

$reg_no = $_SESSION['reg_no'];

$student_id = $_SESSION['userid'];

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
            <div class="col-12 col-md-3 col-lg-3"></div>
            <div class="col-12 col-md-7 col-lg-7">
                <div class="card card-success">
                    <div class="card-header">
                        <h4><?php if(isset($_SESSION['institution_name'])){ echo $_SESSION['institution_name']; } ?> Exam Registration Slip</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3"></div>
                            <div class="col-6">
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
                                        //                            $course_of_study = $row['institution'];
                                            $seat_no = $row['id'];
                                        //                            $department = $row['department'];

                                    ?>
                                    <div style="">
                                        <?php if($row['profile_pic'] == "" || $row['profile_pic'] == 'passport.jpg'){ ?>
                                            <img class="img-responsive" height="250" width="200" src="images/images.jpg">
                                        <?php }else {  ?>
                                            <img class="student-img" height="250" width="200" src="images/<?php echo $row['profile_pic']; ?>">
                                        <?php } ?>
                                    </div>
                                    <div class="">
                                        <h4>Name : <?php echo $name ?></h4>
                                        <h4>Reg No: <?php echo $matric_no ?></h4>
                                        <h4>Seat No : <?php echo $seat_no; ?></h4>
                                    </div>
                                    <?php } ?><hr class="row">
                                    <h3>Registered Subjects </h3><br>


                                                        <div class="table-responsive">
                                                            <table class="table table-condensed table-bordered table-hover table-striped">
                                                                <thead>
                                                                <tr class="text-primary text-capitalize h5">
                                                                    <th>Subjects</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>


                                                                <!--                            <ul class="list-unstyled">-->
                                                                <?php


                                                                $query = "SELECT * FROM registered_exams WHERE student_id = '{$student_id}'";
                                                                $select_user_query = mysqli_query($connection, $query);

                                                                if(!$select_user_query){
                                                                    die("QUERY FAILED". mysqli_error($connection));
                                                                }



                                                                while($row = mysqli_fetch_array($select_user_query)){

                                                                    $course_id = $row['course_id'];
                                                                    $r_id = $row['id'];

                                                                    $query = "SELECT * FROM courses WHERE id = '{$course_id}'";
                                                                    $select_course_query = mysqli_query($connection, $query);

                                                                    if(!$select_course_query){
                                                                        die("QUERY FAILED". mysqli_error($connection));
                                                                    }

                                                                    while($row = mysqli_fetch_array($select_course_query)) {

//                                $course_code = $row['course_code'];
                                                                        $subject_id = $row['subject_id'];
                                                                        $course_title = $row['course_title'];

                                                                        $exam_id = $row['id'];





                                                                        $date = date('Y-m-d', time());





                                                                        ?>

                                                                        <tr>

                                                                            <td><?php echo $course_title ?></td>


                                                                        </tr>
                                                                    <?php } }?>

                                                                </tbody>
                                                            </table>

                                                        </div>
                            </div>
                            <div class="col-3"></div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3 col-lg-3"></div>
            
            
            
        </div>
    </div>
</section>

<?php include "includes/footer.php"?>