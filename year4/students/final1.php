<?php include '../database.php' ?>
<?php

if(isset($_GET['t_q'])){

    $student_id = $_GET['st_id'];
    $course_id = mysqli_real_escape_string($mysqli, $_GET['c_id']);
    $course_title = mysqli_real_escape_string($mysqli, $_GET['c_title']);
    $totalQus = mysqli_real_escape_string($mysqli, $_GET['t_q']);

    $_SESSION[$student_id.'score'] = 0;

//				if(!isset($_SESSION[$student_id.'score'])){
//					$_SESSION[$student_id.'score'] = 0;
//				}

    $answered_query = "SELECT * FROM students_ans
					   WHERE st_id = $student_id AND course_id = $course_id";

    // Get result
    $answeredResult = $mysqli->query($answered_query) or die($mysqli->error);

    while ($row = $answeredResult->fetch_assoc()){
        $ans = $row['ans_id'];
        $c = $row['correct_ans_id'];
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

    //  $deleteQuery = "DELETE FROM students_ans WHERE st_id = $student_id";

    //  $deleteAns = $mysqli->query($deleteQuery) or die($mysqli->error.__LINE__);


        $deleteStudent = "DELETE FROM current_students WHERE st_id = $student_id AND exam_id = $course_id";

        $deleteStudent = $mysqli->query($deleteStudent) or die($mysqli->error.__LINE__);

       // redirect('scores.php');
redirect('index.php');
    } else {

//        $deleteQuery = "DELETE FROM students_ans WHERE st_id = $student_id";
// //
//       $deleteAns = $mysqli->query($deleteQuery) or die($mysqli->error.__LINE__);

        //redirect('scores.php');
redirect('index.php');

    }






}

?>