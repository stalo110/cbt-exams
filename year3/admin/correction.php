<?php include "includes/header.php"?>
<?php
if(isset($_GET['student']) && isset($_GET['course'])){
    $student_id =  $_GET['student'];
    $course_id =  $_GET['course'];
    $score = $_GET['s'];
//    $class_id = getValue('class_id','students',$student_id);
    $sub = getValue('course_title','courses',$course_id);
    $first_name = getValue('first_name','students',$student_id);
    $last_name = getValue('last_name','students',$student_id);
    $full_name = $first_name . ' '. $last_name;
    $message = $full_name.' '.$sub." ". "Exam Sheet";
}else {
    redirect('scores.php');
}
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <h4><i class="fa fa-lg fa-home" aria-hidden="true"></i>  <span class="text-uppercase"><?php echo "$full_name $sub"; ?> Exam Slip</span><span class="small"></span></h4>
                  </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-bordered">
                                    <table id="answers" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>Qus No</th>
                                                <th>Question</th>
                                                <th>Choice</th>
                                                <th>Right Choice</th>
                                                <th>Mark</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $st_ans_query = "SELECT * FROM students_ans WHERE st_id = $student_id AND course_id = $course_id";
                                                $select_students_ans_query = mysqli_query($connection, $st_ans_query);
                                                if(!$select_students_ans_query){
                                                    die("QUERY FAILED". mysqli_error($connection));
                                                }
                                                while($s_row = mysqli_fetch_array($select_students_ans_query)) {
                                                $st_id = $s_row['st_id'];
                                                $c_id = $s_row['course_id'];
                                                $ans_id = $s_row['ans_id'];
                                                $c_ans_id = $s_row['correct_ans_id'];
                                                $qus_id = $s_row['qus_id'];
                                                $qus_no = $s_row['qus_no'];
                                                ?>
                                                <tr>
                                                    <?php
                                                    // get Result
                                                    $qus_query = "SELECT * FROM questions WHERE id = $qus_id";
                                                    // Get result
                                                    $qus = $mysqli->query($qus_query) or die($mysqli->error);
                                                    if(!$qus){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($row = $qus->fetch_assoc()):
                                                        $qus_text = $row['text'];
                                                        $qus_number = $row['qus_no'];
                                                    ?>
                                                        <td><?php echo $qus_number; ?></td>
                                                        <td class="text-capitalize"><?php echo $qus_text; ?></td>
                                                    <?php endwhile ?>
                                                    <?php
                                                    $ans_query = "SELECT text FROM choices WHERE id = $ans_id";
                                                    // Get answer
                                                    $ans = $mysqli->query($ans_query) or die($mysqli->error);
                                                    if(!$ans){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($row = $ans->fetch_assoc()):
                                                        $ans_text = $row['text'];
                                                        ?>
                                                        <td class=""><?php echo $ans_text; ?></td>
                                                    <?php endwhile ?>
                                                    <td><?php echo getValue('text','choices',$c_ans_id) ?></td>
                                                    <td>
                                                        <?php
                                                        if($ans_id == $c_ans_id){ ?>
                                                            <i class="fa fa-check" style="font-size:18px;color:green" aria-hidden="true"></i>
                                                        <?php }else { ?>
                                                            <i class="fa fa-times" style="font-size:18px;color:red"></i>
                                                    <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
        <?php include "includes/footer.php"?>
        <script type="text/javascript">
        $(document).ready(function() {
            $('#answers').DataTable( {
                "lengthMenu": [ 50, 100, 150, 200],
                dom: 'Blfrtip',
                buttons: [
                    // 'pdf', 'print'

                    {
                        extend: 'pdf',
                        title: '<?php echo $sub; ?>',
                        exportOptions: {
                            columns: [0,1,2,3] // indexes of the columns that should be printed,
                        }                      // Exclude indexes that you don't want to print.
                    },
                    {
                        extend: 'print',
                        title: 'Score : <?php echo $score; ?>',
                        message: '<?php echo $message ?>',
                        exportOptions:{
                            stripHtml: false,
                            columns: [0,1,2,3]
                        }
                    }
                ]

            } );
        } );


    </script>