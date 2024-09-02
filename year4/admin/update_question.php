<?php include "includes/header.php"?>
<style>
            input[type='number']{
                width: 50px;
                padding: 4px;
                border-radius: 5px;
                border: 1px #000 solid;
            }
        </style>
<?php

if(!isset($_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs'])){
    redirect("index.php");
}

$number = (int) $_GET['n'];

$lecturers_id = 1;

$course_id = (int) $_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs'];

if(isset($_POST['submit'])){

    $qus_no = mysqli_real_escape_string($mysqli, $_POST['qus_no']);
    $qus_text = mysqli_real_escape_string($mysqli, $_POST['qus_text']);
    $qus_extra = mysqli_real_escape_string($mysqli, $_POST['qus_extra']);
    $correct_choice = mysqli_real_escape_string($mysqli, $_POST['correct_choice']);

    //choices array
    $choices = array();
    $choices[1] = mysqli_real_escape_string($mysqli, $_POST['choice1']);
    $choices[2] = mysqli_real_escape_string($mysqli, $_POST['choice2']);
    $choices[3] = mysqli_real_escape_string($mysqli, $_POST['choice3']);
    $choices[4] = mysqli_real_escape_string($mysqli, $_POST['choice4']);
    $choices[5] = mysqli_real_escape_string($mysqli, $_POST['choice5']);

    //Question query
//    $query = "INSERT INTO `questions`(qus_no, text, course_id) VALUES('$qus_no','$qus_text','$course_id')";

    $query = "UPDATE questions SET text='$qus_text' WHERE qus_no=$qus_no AND course_id=$course_id";

    //Run query

    $update_row = $mysqli->query($query) or die($mysqli->error.__LINE__);

//    if($update_row){
//        die('updated');
//    }

    //Validate Insert
    if($update_row){
        $query = "DELETE FROM choices WHERE qus_no=$qus_no AND course_id=$course_id";

        $delete_choices = $mysqli->query($query) or die($mysqli->error.__LINE__);
//
//        if($delete_choices){
//            die("deleted");
//        }

        foreach ($choices as $choice => $value){
            if($value != ''){
                if($correct_choice == $choice){
                    $is_correct = 1;
                } else {
                    $is_correct = 0;
                }
                //choice query
                $query = "INSERT INTO `choices` (qus_no, course_id, is_correct, text) 
                VALUES ('$qus_no', '$course_id', '$is_correct', '$value')";

                //Run query

                $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);

                //validate insert
                if($insert_row){
                    continue;
                } else {
                    die($mysqli->error.__LINE__);
                }
            }
        }
        $msg = 'Question Has Been Updated Successfully';
    }
}

//Get Total Number

$query = "SELECT * FROM `questions` WHERE course_id = $course_id AND qus_no = $number";

$results = $mysqli->query($query) or die($mysqli->error.__LINE__);

$question = $results->fetch_assoc();
//$totalQus = $results->num_rows;

$query = "SELECT * FROM choices WHERE qus_no = $number AND course_id = $course_id";
// Get result
$choices = $mysqli->query($query) or die($mysqli->error);
//Get correct Choice
$query = "SELECT * FROM `choices` WHERE qus_no = $number AND is_correct = 1 AND course_id = $course_id";
//Get Result
$result = $mysqli->query($query) or die($mysqli->error.__LINE__);
//Get Row
$row = $result->fetch_assoc();
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Course Title : <?php echo $course_title ?></h4>
                  </div>
                  <div class="card-body">
                  <?php

                    $choice_no = 1;

                    $choice_n = 1;

                    if(isset($msg)){
                        echo '<p>'.$msg.'</p>';
                    }
                    ?>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label>Question Number: </label>
                                        <input type="number" value="<?php echo $totalQus+1; ?>" name="qus_no" />
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-12">
                                        <p>Correct Option : <strong class="text-success"><?php echo $row['text'] ?></strong class="text-success"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Question Text</label>
                                <textarea name="qus_text" class="form-control" rows="4"><?php echo $question['text'] ?></textarea>
                            </div>
                            <?php while($row = $choices->fetch_assoc()): ?>
                                <div class="form-group">
                                    <label>Option <?php echo $choice_no++ ?></label>
                                    <input type="text" class="form-control" name="choice<?php echo $choice_n++ ?>" value="<?php echo $row['text']; ?>" />
                                </div><hr>
                            <?php endwhile ?>
                            <div class="form-group">
                                <label>Correct Option Number:</label>
                                <input required="" type="number" name="correct_choice" />
                            </div><hr>

                            <div class="form-group">
                                <input type="submit" class="form-control btn btn-primary" name="submit" value="submit" />
                            </div>
                        </form>
                  </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                  <div class="card-header">
                    <h4>Questions </h4>
                  </div>
                  <div class="card-body">
                  <div class="pre-scrollable" style="max-height: 95vh">


<?php

$query = "SELECT * FROM questions WHERE course_id = '{$course_id}' ORDER BY qus_no ASC";
$select_user_query = mysqli_query($connection, $query);

if(!$select_user_query){
    die("QUERY FAILED". mysqli_error($connection));
}

while($row = mysqli_fetch_array($select_user_query)) {

    $qus_no = $row['qus_no'];

    ?>
    <p class="question"><?php echo $qus_no ?> : <?php echo $row['text']; ?>
        <?php if($row['img'] != ""){ ?>
        <br><img src="qusImage/<?php echo $row['img'] ?>"><br>
        <?php } ?>
        <span class="pull-right"><a href="update_question.php?n=<?php echo $qus_no ?>&xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $course_id ?>" class="btn btn-xs btn-warning">Edit</a> 


        </span> 

    </p>

    <ul class="choices">

        <?php
        $choices_query = "SELECT * FROM choices 
        WHERE qus_no = $qus_no AND course_id = $course_id";

        // Get result
        $choices = $mysqli->query($choices_query) or die($mysqli->error);

        ?>

        <?php while($row = $choices->fetch_assoc()): ?>

            <l1><input name="choice" type="radio" value="<?php echo $row['id']; ?>" /><?php echo $row['text']; ?>
                <?php if($row['ans_image'] != ''){ ?>
                    <span class="pull-right"><img height="30" width="30" src="ansImage/<?php echo $row['ans_image'] ?>" /></span><br>
                <?php } ?>
            </l1><br>


        <?php endwhile; ?>
        <?php
        $query = "SELECT * FROM `choices` WHERE qus_no = $qus_no AND is_correct = 1 AND course_id = $course_id LIMIT 1";

        //Get Result
        $result = $mysqli->query($query) or die($mysqli->error.__LINE__);

        //Get Row

        $row = $result->fetch_assoc(); ?>

        <p class="text-info">Ans :  <?php echo $row['text']; ?></p><hr>

    </ul>

<?php }?>
</div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!--        modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mySmallModalLabel">Delete Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <h3>Are you Sure You Want To Delete This Question ?</h3>
            </div>
            <div class="modal-footer">
                <a href="" style="text-decoration:none" class="btn btn-danger modal_delete_link">Delete</a>
                <button type="button" class="btn btn-dark" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php 
if(isset($_GET['delete'])){
    $the_qus_no = sanitize($_GET['delete']);


    $ans_query = "DELETE FROM choices WHERE qus_no = {$the_qus_no} AND course_id = {$course_id}";
    $delete_ans_query = mysqli_query($connection, $ans_query);

    $query = "DELETE FROM questions WHERE qus_no = {$the_qus_no} AND course_id = {$course_id}";
    $delete_query = mysqli_query($connection, $query);

    
    header("Location: set_questions.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=$course_id");
}

?>



<?php include "includes/footer.php"?>
<script>
$(document).ready(function(){
    $(".delete_link").on('click', function(){
        var id = $(this).attr("rel");

        var delete_url = "set_questions.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $course_id ?>&delete="+ id +" ";

        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal('show');


    });

    $("#showExtra").click(function(){
            $("#extra").toggle("slow");
        });

    });

</script>