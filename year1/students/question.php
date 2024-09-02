<?php include "includes/header.php"?>
<?php

if(!logged_in()){
    redirect('../login.php');
}


$matric_no = $_SESSION['reg_no'];

$student_id = $_SESSION['userid'];

$name = $_SESSION['name'];


//Set question number


$number = (int) $_GET['n'];

$exam_id = (int) $_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs'];

$qus = (int) $_GET['q'];

if(isset($_GET['submit_id'])){
    $the_id = $_GET['submit_id'];
    redirect("final.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=$the_id");

}

if(!isset($_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs']) || (!isset($_GET['q']))){
    redirect('../login.php');
}


$start_time = $_SESSION["timeStarted_$student_id"];







// get question

$question_query = "SELECT * FROM questions 
					WHERE qus_no = $qus AND course_id = $exam_id";

// Get result
$result = $mysqli->query($question_query) or die($mysqli->error);


if(isset($_GET['submit_id'])){
    $the_id = $_GET['submit_id'];
    redirect("final.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=$the_id");
}elseif($result->num_rows == 0){
    redirect("contact.php");
}



$question = $result->fetch_assoc();



$question_id = $question['id'];

//get student answers

$ans_query = "SELECT * FROM students_ans 
					WHERE st_id = $student_id AND course_id = $exam_id AND qus_id = $question_id";

// Get result
$ansResult = $mysqli->query($ans_query) or die($mysqli->error);


$ans = $ansResult->fetch_assoc();


$all_ans_query = "SELECT id FROM students_ans 
					WHERE st_id = $student_id AND course_id = $exam_id";

// Get result
$all_ans_result = $mysqli->query($all_ans_query) or die($mysqli->error);


$total_attempt_query = "SELECT id FROM students_ans 
					WHERE st_id = $student_id AND course_id = $exam_id";

// Get result
$total_attempt_result = $mysqli->query($total_attempt_query) or die($mysqli->error);

////get answered numbers
//$answered_query = "SELECT * FROM students_ans
//					WHERE st_id = $student_id AND course_id = $exam_id";
//
//// Get result
//$answeredResult = $mysqli->query($answered_query) or die($mysqli->error);

//$answered = $answeredResult->fetch_assoc();


//get number
$q_query = "SELECT * FROM questions 
					WHERE course_id = $exam_id";

$question_query = $mysqli->query($q_query) or die($mysqli->error);



// get Result

$c_query = "SELECT * FROM choices 
					WHERE qus_no = $qus AND course_id = $exam_id ORDER BY RAND()";

// Get result
$choices = $mysqli->query($c_query) or die($mysqli->error);

//Get Total Number

$qus_query = "SELECT * FROM questions 
					WHERE course_id = $exam_id";

$results = $mysqli->query($qus_query) or die($mysqli->error.__LINE__);


$totalQus = $results->num_rows;

$_SESSION['totalQus'] = $totalQus;


$examNum = $_SESSION["total_$exam_id"];



?>

<style>
        .choix{
            font-size:20px; width:50%; color:#000; box-shadow:2px 2px 2px 2px #ccc; padding:10px; border-top:2px solid #fff; border-radius:0.5em; background-image:linear-gradient(180deg,#00FFFF,#fff);
        }
        .choix:hover{
            font-size:20px; width:50%; color:#000; box-shadow:2px 2px 2px 2px #ccc; padding:10px; border-top:2px solid #fff; border-radius:2em; transition:border-radius 0.2s; background-image:linear-gradient(180deg,#7FFFD4,#fff);
        }
        .inst{
            background:green;
            color:#fff;
        }
</style>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>

<?php


    $query = "SELECT exam_time,course_title FROM courses WHERE id = $exam_id";
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
<?php if($remaining < 1){

redirect("final.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=".$exam_id);
} ?>



<section class="section">

    <div class="container">
        <div class="row">
            <ul class="nav navbar-nav navbar-right" style="color:green !Important; margin-left:920px" >
                <li style="font-weight: 800; font-size: 1.5em; border:2px solid transparent; background:linear-gradient(180deg,white,yellow); border-bottom-left-radius:20px; border-bottom-right-radius:20px; color:green !Important;"><a style="color:green !Important;"><i class="fa fa-clock-o" style="font-size:1.5em; color:#bf5902"></i> <span id="countdown" class="timer" style="color:green;"></span></a></li>
            </ul>
            
            <div class="col-12 col-md-12 col-lg-12">
            <div class="row">
                <div class="col-md-12">
                <?php if($remaining > 600 && $remaining < 900){ ?>

<div class="pull-right" style="margin-top:20px">
    <div id="hexagon" >
        <h4 class="alert alert-danger tab blink" style="float:left;color:#fff; background:red; border-bottom-left-radius:1em; border-bottom-right-radius:1em;">You have Less than 15 minutes remaining</h4>
    </div>

</div>

<?php }else if($remaining > 300 && $remaining < 600) {?>
<div class="pull-right" style="margin-top:20px">
<div id="hexagon" >
        <h4 class="alert alert-danger tab blink" style="float:left;color:#fff; background:red; border-bottom-left-radius:1em; border-bottom-right-radius:1em;">You have Less than 10 minutes remaining</h4>
    </div> 

</div>

<?php }else if($remaining < 300) {?>
<div class="pull-right" style="margin-top:20px">
<div id="hexagon" >
        <h4 class="alert alert-danger tab blink" style="float:left;color:#fff; background:red; border-bottom-left-radius:1em; border-bottom-right-radius:1em;">You have Less than 5 minutes remaining</h4>
    </div> 

</div>


<?php } ?>
                </div>
            </div>
                <div class="card card-success">
                    <div class="card-header">
                    <h4><?php echo $sub_title ?></h4>
                        <h4 style="margin-left:40px">Question <?php echo $number+1 ?> of <?php echo $totalQus; ?></h4>
                        <span class="text-success" style="font-size: 1.5em;margin-left:440px">Attempted <?php echo $total_attempt_result->num_rows; ?> of <?php echo $question_query->num_rows;?> Questions</span>
                    </div>
                    <div class="card-body">
                        <h2 class="question" style="font-weight: 600;  padding:5px; width:100%; color: #000;">[<?php echo $number+1 ?>] <?php echo $question['text']; ?> <?php if(strlen($question['extra']) > 3):?> <button type="button" class="pull-right btn btn-info" data-toggle="modal" data-target="#instruction">View Passage</button> <?php endif; ?></h2>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <?php if($question['img'] != ''){ ?>
                                    <br>
                                    <img style="width:auto;height:200px" src="<?php echo ADMIN_ROOT_URL ?>qusImage/<?php echo $question['img']; ?>" >
                                <?php } ?>
                            </div>
                        </div><br>
                        <form method="post" action="process.php">
                            <ol class="choices" type="A" style="font-weight:bold;">

                                <?php $i = 1; ?>

                                <?php while($row = $choices->fetch_assoc()): ?>

                                    <?php if(isset($ans['id'])){ ?>


                                        
                                        <li class="choix">
                                            <div class="pretty p-icon p-curve p-jelly">
                                                <input id="<?php echo $i++; ?>" style="border-radius:100%" name="choice" type="radio" <?php if($row['id'] == $ans['ans_id']){ echo 'checked'; } ?> value="<?php echo $row['id']; ?>">
                                                <div class="state p-warning">
                                                    <i class="icon material-icons">done</i>
                                                    <label> <?php echo $row['text']; ?></label>
                                                </div>
                                            </div>
                                        </li><br>

                                    <?php }else {  ?>

                                        <li class="choix">
                                            <div class="pretty p-icon p-curve p-jelly">
                                                <input id="<?php echo $i++; ?>" style="border-radius:100%" name="choice" type="radio" value="<?php echo $row['id']; ?>">
                                                <div class="state p-warning">
                                                    <i class="icon material-icons">done</i>
                                                    <label> <?php echo $row['text']; ?></label>
                                                </div>
                                            </div>
                                        </li><br>
                                    <?php } ?>

                                <?php endwhile ?>
                                

                            </ol>
                            <?php
                            if($number == 0){
                                $pre = 0;
                            }else {
                                $pre = $number-1;

                            }

                            ?>

                            <?php if($number == 0){ ?>
                                <a disabled="" class="btn btn-success" href=""><i class="fa fa-arrow-circle-left fa-fw"></i>Previous</a>
                            <?php } else { ?>

                                <a class="btn btn-success" style="font-weight:bold;" href="question.php?n=<?php echo $pre ?>&q=<?php echo $examNum[$pre]; ?>&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>"> <i class="fa fa-arrow-circle-left fa-fw"></i>Previous</a>

                                <script>
                                    var url = "question.php?n=<?php echo $pre ?>&q=<?php echo $examNum[$pre]; ?>&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>"
                                </script>

                            <?php } ?>
                    

                            <!---->

                            <input id="go" style="font-weight:bold" class="btn btn-success btn-md" type="submit" value="Next & Continue &rarr;" />
                            <button type='button' rel='<?php echo $exam_id ?>' id="submit" class="submit_link btn btn-success btn-md pull-right"><i class="fa fa-paper-plane fa-fw"></i> Submit </button>
                            <input type="hidden" name="number" value="<?php echo $number; ?>" />
                            <input type="hidden" name="qus" value="<?php echo $qus; ?>" />
                            <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>" />
                            <input type="hidden" name="qus_id" value="<?php echo $question['id']; ?>" />


                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center">

            <?php foreach($_SESSION["total_$exam_id"] as $key => $value) { ?>

                <a style="margin-bottom: 4px; border-radius:2em; box-shadow:2px 2px 2px 2px #ccc; " href="question.php?n=<?php echo $key ?>&q=<?php echo $value ?>&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>" class="btn btn-default <?php if($key == $number){ echo "btn-warning"; } ?>

<?php
                //get answered numbers


                $qus_no = $key;
                $answered_query = "SELECT * FROM students_ans
					   WHERE st_id = $student_id AND course_id = $exam_id AND qus_no = $qus_no AND qus_id > 0";

                // Get result
                $answeredResult = $mysqli->query($answered_query) or die($mysqli->error);

                if($answeredResult->num_rows > 0){
                    echo " btn-success ";
                } else {
                    echo " btn-danger ";
                }

                ?>
btn-md"><?php echo $key+1 ?></a>


            <?php } ?>

        </div>
            
            
            
        </div>
    </div>
</section>
<div id="instruction" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="false">
                            <div class="modal-dialog modal-lg">
                                <!--        modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Read the Passage Carefully</h4>
                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    </div>
                                    <div class="modal-body text-justify">
                                        <p><?php echo $question['extra'] ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-outline-warning" data-dismiss="modal">Close Passage</button>
                                    </div>
                                </div>
                            </div>
                        </div>
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="false">
        <div class="modal-dialog">
            <!--        modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Submit This Exam</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body text-center">
                    <h5>Are you Sure You Are Done With This Exam and Ready To Submit?</h5>
                    <p>By clicking Submit You Will Be Redirected To Evaluation Page</p>
                </div>
                <div class="modal-footer">
                    <a href="" class="btn btn-danger modal_submit_link">Submit</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
<?php include "includes/footer.php"?>
<script>

$(document).ready(function(){
    $(".submit_link").on('click', function(){
        var id = $(this).attr("rel");

        var submit_url = "question.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs&q&submit_id="+ id +" ";

        $(".modal_submit_link").attr("href", submit_url);

        $("#myModal").modal('show');


    });
});


function blinker() {
    $('.blinking').fadeOut(500);
    $('.blinking').fadeIn(500);
}
setInterval(blinker, 1000);


var initialTime =  <?php echo $remaining; ?>;

window.onload=function(){
        document.body.onkeyup=function(e){
            var keyCode = (window.event) ? event.keyCode : e.which;
            if(keyCode==13 || keyCode == 78 || keyCode == 39)
            {
                $("#go").click();
            }
            if(keyCode == 37 || keyCode == 80){
                window.location = url;
            }


            if (keyCode == 65) {
                $("#1").prop("checked", true);
            }

            if (keyCode == 66) {
                $("#2").prop("checked", true);
            }
            if (keyCode == 67) {
                $("#3").prop("checked", true);
            }
            if (keyCode == 68) {
                $("#4").prop("checked", true);
            }
            if (keyCode == 69) {
                $("#5").prop("checked", true);
            }

            if (event.ctrlKey && event.altKey && keyCode == 69) {
                $('.parent').slideToggle('slow');return false
            }

            if (keyCode == 75) {
                $('.parent').slideToggle('slow');return false
            }


        };


    }

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