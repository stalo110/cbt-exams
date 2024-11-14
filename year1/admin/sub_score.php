<?php include "includes/header.php";
$sub = "Student Scores";
if(isset($_GET['id'])){
    $score_id =  $_GET['id'];
}else {
    redirect('subjects_scores.php');
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
                        <h4><i class="fa fa-lg fa-home" aria-hidden="true"></i> <span class="text-uppercase">List Of All
                                Students Scores</span><span class="small"></span></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-bordered">
                                    <table id="documents" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Class</th>
                                                <th>Student Name</th>
                                                <th>Subject</th>
                                                <th>Score</th>
                                                <th>Total Questions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $st_query = "SELECT * FROM scores WHERE course_id = $score_id";
                                            $select_students_query = mysqli_query($connection, $st_query);
                                            if(!$select_students_query){
                                                die("QUERY FAILED". mysqli_error($connection));
                                            }
                                            $i = 0;
                                            while($s_row = mysqli_fetch_array($select_students_query)) {
                                                $st_id = $s_row['student_id'];
                                                $s_id = $s_row['id'];
                                                $s_course_id = $s_row['course_id'];
                                                $s_course_title = $s_row['course_title'];
                                                $score = $s_row['score'];
                                                $overAll = $s_row['overAll'];
                                                $i++;
                                                ?>
                                            <tr>
                                                <td><?php echo $i; ?></td>
                                                <?php
                                                    // get Result
                                                    $c_query = "SELECT * FROM students WHERE id = $st_id";
                                                    // Get result
                                                    $st_name = $mysqli->query($c_query) or die($mysqli->error);
                                                    if(!$st_name){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($row = $st_name->fetch_assoc()):
                                                        $st_class_id = $row['class_id'];
                                                        $st_class_name = $row['class'];
                                                    $st_id = $row['id'];
                                                        $st_full_name = $row['first_name'] .' '.  $row['last_name'];
                                                        $c_class = "SELECT * FROM class WHERE id = $st_class_id";
                                                        // Get result
                                                        $st_class = $mysqli->query($c_class) or die($mysqli->error);
                                                        if(!$st_class){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                        }
                                                        while($row = $st_class->fetch_assoc()){ ?>
                                                <td class=""><?php echo $st_class_name ?></td>
                                                <?php } ?>
                                                <td class="text-capitalize"><?php echo $st_full_name; ?></td>
                                                <?php endwhile ?>
                                                <td><?php echo $s_course_title; ?></td>
                                                <td><?php echo $score; ?>/<?php echo $overAll; ?></td>
                                                <td><?php echo $overAll; ?></td>
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
<?php

            if(isset($_GET['delete'])){
                $the_score_id = sanitize($_GET['delete']);
                $the_st_id = sanitize($_GET['st_id']);

                $query = "DELETE FROM scores WHERE id = {$the_score_id} ";
                $delete_query = mysqli_query($connection, $query);
                header("Location: scores.php");
            }

            ?>

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="false">
    <div class="modal-dialog">
        <!--        modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Delete Score</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h5>Are you Sure You Want To Delete This Student Score?</h5>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-danger modal_delete_link">Delete</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>
<?php include "includes/footer.php"?>
<script>
$(document).ready(function() {
    $(".delete_link").on('click', function() {
        var id = $(this).attr("rel");
        var st_id = $(this).attr("name");
        var delete_url = "scores.php?delete=" + id + "&st_id=" + st_id + " ";
        $(".modal_delete_link").attr("href", delete_url);
        $("#myModal").modal('show');
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $("#showUpload").click(function() {
        $("#upload").toggle("slow");
    });

    $('#documents').DataTable({
        "lengthMenu": [50, 100, 150, 200, 250, 300],
        dom: 'Blfrtip',
        buttons: [
            // 'copy', 'csv', 'excel', 'pdf', 'print'

            {
                extend: 'excel',
                title: '<?php echo "MILLENNIUM COLLEGE OF NURSING SCIENCES, AWKA.". " ". $sub." on ". $s_course_title?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                title: '<?php echo "MILLENNIUM COLLEGE OF NURSING SCIENCES, AWKA.". " ". $sub." on ". $s_course_title?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5] // indexes of the columns that should be printed,
                } // Exclude indexes that you don't want to print.
            },
            {
                extend: 'csv',
                title: '<?php echo "MILLENNIUM COLLEGE OF NURSING SCIENCES, AWKA.". " ". $sub." on ". $s_course_title?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }

            },
            {
                extend: 'print',
                title: '<?php echo "MILLENNIUM COLLEGE OF NURSING SCIENCES, AWKA.". " ". $sub." on ". $s_course_title?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            }
        ]
    });
});
</script>