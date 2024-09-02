<?php include "includes/header.php"?>
<!---->



<?php

if(!logged_in()){
	redirect('login.php');
}

$matric_no = $_SESSION['reg_no'];



$student_id = $_SESSION['userid'];


$query = "SELECT * FROM students WHERE reg_no = '{$matric_no}' LIMIT 1";
$select_user_query = mysqli_query($connection, $query);

if(!$select_user_query){
	die("QUERY FAILED". mysqli_error($connection));
}





while($row = mysqli_fetch_array($select_user_query)) {
	$first_name = $row['first_name'];
	$last_name = $row['last_name'];
	$name = $first_name . " " . $last_name;
	$matric_no = $row['reg_no'];
//	$course_of_study = $row['course_of_study'];
//	$department = $row['department'];

}

?>


<?php
//Set question number

$exam_id = (int) $_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs'];


if(!isset($_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs'])){
	redirect('login.php');
}

$time_query = "SELECT * FROM current_students WHERE st_id = '{$student_id}' AND exam_id = '{$exam_id}'  LIMIT 1";
$select_time_query = mysqli_query($connection, $time_query);

if(!$select_time_query){
    die("QUERY FAILED". mysqli_error($connection));
}

while($row = mysqli_fetch_array($select_time_query)) {

    $start_time = $row['time_started'];
}



$score_query = "SELECT * FROM scores
					   WHERE student_id = $student_id AND course_id = $exam_id";

// Get result
$check_score = $mysqli->query($score_query) or die($mysqli->error);

if($check_score->num_rows > 0){
	redirect("scores.php");
}



$answered_query = "SELECT * FROM students_ans
					   WHERE st_id = $student_id AND course_id = $exam_id";

// Get result
$answeredResult = $mysqli->query($answered_query) or die($mysqli->error);

$totalAnswered = $answeredResult->num_rows;







// get question

//out
//$query = "SELECT * FROM questions
//					WHERE qus_no = $number AND course_id = $exam_id";
//
//// Get result
//$result = $mysqli->query($query) or die($mysqli->error);
//
//
//$question = $result->fetch_assoc();
// /out

//get number

// get Result

// out
//$query = "SELECT * FROM choices
//					WHERE qus_no = $number AND course_id = $exam_id ORDER BY RAND()";
//
//// Get result
//$choices = $mysqli->query($query) or die($mysqli->error);

// /out


//Get Total Number

$query = "SELECT * FROM questions
					WHERE course_id = $exam_id";

$results = $mysqli->query($query) or die($mysqli->error.__LINE__);
$totalQus = $results->num_rows;



//
//
//				$days        = floor($remaining/24/60/60);
//				$hoursLeft   = floor(($remaining) - ($days*86400));
//				$hours       = floor($hoursLeft/3600);
//				$minutesLeft = floor(($hoursLeft) - ($hours*3600));
//				$minutes     = floor($minutesLeft/60);
//
//				echo $date;


?>
<?php


$query = "SELECT exam_time FROM courses WHERE id = $exam_id";
$select_exam_query = mysqli_query($connection, $query);

    if(!$select_exam_query){
    die("QUERY FAILED". mysqli_error($connection));
}

while($row = mysqli_fetch_assoc($select_exam_query)) {

    $exam_time = $row['exam_time'];


    $exam_time = $exam_time * 60;

}

$class_id = getValue('class_id','students',$student_id);
$student_class = getValue('name','class',$class_id);

$query = "SELECT course_title, course_name FROM courses WHERE id = '{$exam_id}' LIMIT 1";
$select_course_query = mysqli_query($connection, $query);

if(!$select_exam_query){
    die("QUERY FAILED". mysqli_error($connection));
}

while($row = mysqli_fetch_assoc($select_course_query)) {

    $sub_title = $row['course_name'];


}

if(!isset($_SESSION['course_title'])){
    $_SESSION['course_title'] = $sub_title;
}

$date = date('h:i:s', time());




$start_exam_time = toSeconds($start_time);

$s_time = $start_exam_time + $exam_time;

$remaining = $s_time - $current_time;


?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>


    
<section class="section" style="margin-bottom:100px">
    <div class="container">
        <div class="row">
            <ul class="nav navbar-nav navbar-right" style="color:green !Important; margin-left:920px" >
                <li style="font-weight: 800; font-size: 1.5em; border:2px solid transparent; background:linear-gradient(180deg,white,yellow); border-bottom-left-radius:20px; border-bottom-right-radius:20px; color:green !Important;"><a style="color:green !Important;"><i class="fa fa-clock-o" style="font-size:1.5em; color:#bf5902"></i> <span id="countdown" class="timer" style="color:green;"></span></a></li>
            </ul>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card card-success">
                    <div class="card-header">
                        <h4>Question </h4>
                    </div>
                    <div class="card-body">
                        <div class="container">
                            <div class="text-center">
                                <h4 style="color: #000">Total Question Answered : <?php echo $totalAnswered ?>/<?php echo $totalQus ?> </h4>
                                <?php if($totalAnswered < $totalQus*70/100){ ?>
                                    <p>You Answered only <?php echo $totalAnswered ?> Question(s) Which is Less Than 70% Of The Total Question(s)</p>
                                <?php } ?>

                                <?php if($totalAnswered > $totalQus*80/100 && $totalAnswered < $totalQus){ ?>
                                    <p>You Answered more Than 80% Of The Total Questions </p>
                                <?php } ?>

                                <?php if($totalAnswered == $_SESSION['totalQus']){ ?>
                                        <p>Congrats!!! You answered All The <?php echo $totalAnswered ?> Question(s)</p>
                                <?php } ?>
                                <a href="question.php?n=0&q=<?php echo $totalQus ?>&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>" class="btn btn-lg btn-outline-warning">Continue Exam</a><br><br>
                                <form method="post" id="submitQus" action="">

                                    <input class="btn btn-success btn-md" type="submit" name="submitExam" value="Click here for Final Submission" style="padding:25px;font-size:35px; border-radius:20px;"  />
                                    <input type="hidden" name="student_id" value="<?php echo $student_id; ?>" />
                                    <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" />

                                    <input type="hidden" name="score" value="<?php echo $totalAnswered; ?>" />
                                    <input type="hidden" name="totalQus" value="<?php echo $totalQus; ?>" />


                                    <?php if($remaining < 1){


                                        redirect("final1.php?st_id=$student_id&c_id=$exam_id&c_title=$sub_title&t_q=$totalQus");
                                    } ?>

                                </form>
                                <?php
                                    if(isset($_POST['submitExam'])){

                                        redirect("final1.php?st_id=$student_id&c_id=$exam_id&c_title=$sub_title&t_q=$totalQus");
                                    }

                                    if(isset($_GET['t_q'])){

                                        $student_id = $_GET['st_id'];
                                        $course_id = mysqli_real_escape_string($mysqli, $_GET['c_id']);
                                        $course_title = mysqli_real_escape_string($mysqli, $_GET['c_title']);
                                        $totalQus = mysqli_real_escape_string($mysqli, $_GET['t_q']);

                                        echo $course_title;

                                        die($course_title);

                                        $_SESSION[$student_id.'score'] = 0;

                        //				if(!isset($_SESSION[$student_id.'score'])){
                        //					$_SESSION[$student_id.'score'] = 0;
                        //				}

                                        $answered_query = "SELECT * FROM students_ans
                                            WHERE st_id = $student_id AND course_id = $course_id";

                                        // Get result
                                        $answeredResult = $mysqli->query($answered_query) or die($mysqli->error);

                                        while ($row = $answeredResult->fetch_assoc()){
                                            if($row['ans_id'] == $row['correct_ans_id']){
                                                $_SESSION[$student_id.'score']++;
                                            }else {
                                                $_SESSION[$student_id.'score'];
                                            }
                                        }
                                        $mark = $_SESSION[$student_id.'score'];

                        //				$score = $mark * 100 / $totalQus;

                                    $check_score_query = "SELECT * FROM scores
                                            WHERE student_id = $student_id AND course_id = $course_id";

                                    // Get result
                                    $scoreResult = $mysqli->query($check_score_query) or die($mysqli->error);

                                    if($scoreResult->num_rows == 0){

                        //remove mark field
                        //				$query = "INSERT INTO `scores` (student_id, course_id, course_title, score, mark, overAll)
                        //				VALUES ('$student_id', '$course_id', '$course_title', '$score', $mark, '100')";

                                        $query = "INSERT INTO `scores` (student_id, course_id, course_title, score, overAll)
                                        VALUES ('$student_id', '$course_id', '$course_title', '$mark', '$totalQus')";

                                        //Run query

                                        $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);

                                        $deleteQuery = "DELETE FROM students_ans WHERE st_id = $student_id";

                                        $deleteAns = $mysqli->query($deleteQuery) or die($mysqli->error.__LINE__);


                                        $deleteStudent = "DELETE FROM current_students WHERE st_id = $student_id AND exam_id = $course_id";

                                        $deleteStudent = $mysqli->query($deleteStudent) or die($mysqli->error.__LINE__);

                                        //redirect('scores.php');
                                //redirect('start.php');
                                        echo "inserted";
                                    } else {

                                        $deleteQuery = "DELETE FROM students_ans WHERE st_id = $student_id";

                                        $deleteAns = $mysqli->query($deleteQuery) or die($mysqli->error.__LINE__);

                                        redirect('scores.php');

                                    }






                                    }

                                    ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include "includes/footer.php"?>

<script>


function blinker() {
    $('.blinking').fadeOut(500);
    $('.blinking').fadeIn(500);
}
setInterval(blinker, 1000);


var initialTime =  <?php echo $remaining; ?>;


var seconds = initialTime;
function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;
    }
    document.getElementById('countdown').innerHTML = hours + "hr : " + minutes + "mins : " + remainingSeconds+ "secs";
    if (seconds == 0) {
        clearInterval(countdownTimer);
        document.getElementById('countdown').innerHTML = "Completed";
        window.location.reload();
    } else {
        seconds--;
    }
}
var countdownTimer = setInterval('timer()', 1000);
</script>
