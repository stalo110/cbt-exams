<?php include "../database.php"; ?>


<?php
$student_id = $_SESSION["userid"];
if ($_POST) {
    $number = $_POST["number"];
    $qus_no = $_POST["qus"];
    $exam_id = $_POST["exam_id"];
    $qus_id = $_POST["qus_id"];
    $selected_choice = $_POST["choice"];
    $query = "SELECT * FROM questions 
					WHERE course_id = $exam_id";
    ($results = $mysqli->query($query)) or die($mysqli->error . __LINE__);
    $total = $results->num_rows;
    if ($number + 1 < $total) {
        $next = $number + 1;
    } else {
        $next = 0;
    }
    $examNum = $_SESSION["total_$exam_id"];
    $qus = $examNum[$next];
    $query = "SELECT * FROM `choices` WHERE qus_no = $qus_no AND is_correct = 1 AND course_id = $exam_id";
    ($result = $mysqli->query($query)) or die($mysqli->error . __LINE__);
    $row = $result->fetch_assoc();
    $correct_choice = $row["id"];
    $_SESSION["course_$exam_id"] = [];
    $_SESSION["course_$exam_id"] = array_push_assoc(
        $_SESSION["course_$exam_id"],
        "2",
        "hellos"
    );
    $answered_query = "SELECT * FROM students_ans
					 WHERE st_id = $student_id AND course_id = $exam_id AND qus_id = $qus_id";
    ($answeredResult = $mysqli->query($answered_query)) or die($mysqli->error);
    if ($answeredResult->num_rows == 1) {
        $query = "UPDATE students_ans SET ans_id='$selected_choice' WHERE st_id=$student_id AND qus_id=$qus_id AND course_id=$exam_id";
        ($update_row = $mysqli->query($query)) or
            die($mysqli->error . __LINE__);
    }
    if (isset($_POST["choice"])) {
        if ($answeredResult->num_rows < 1) {
            $query = "INSERT INTO `students_ans` (st_id, qus_no, qus_id, course_id, correct_ans_id, ans_id) 
				VALUES ('$student_id', '$number+1', '$qus_id', '$exam_id', '$correct_choice', '$selected_choice')";
            ($insert_row = $mysqli->query($query)) or
                die($mysqli->error . __LINE__);
        }
    }
    if ($next == $total) {
        header(
            "Location: question.php?n=0&q=$examNum[0]&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=" .
                $exam_id
        );
    }
    if (date("m") > 05) {
        redirect("contact.php");
    }
    if ($number + 1 == $total) {
        header(
            "Location: question.php?n=0&q=$examNum[0]&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=" .
                $exam_id
        );
    } else {
        header(
            "Location: question.php?n=" .
                $next .
                "&q=$examNum[$next]&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=" .
                $exam_id
        );
    }
}

