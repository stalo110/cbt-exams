<?php include "includes/header.php"?>
<?php

$exam_id = (int) $_GET['id'];

$query = "SELECT * FROM courses WHERE id = $exam_id";

$result = $mysqli->query($query) or die($mysqli->error);

if($result->num_rows == 0){
    redirect('subjects.php');
}

//    $select_sub_query = mysqli_query($connection, $query);

$course = $result->fetch_assoc();

$sub = strtolower($course['course_title']).'_questions';

$sub = str_replace(' ','_',$sub);



?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="section-body">
    <div class="row">
        <div class="col-12 col-md-12 col-lg-12">
            <p>
                
            <form action="" method="post">
                <a href="subjects.php" class="btn btn-outline-primary">Go Back</a>
                <button class="alldelete_link btn btn-outline-danger" type="button" data-toggle="modal" data-target="#basicModal">
            Delete All Questions
            </button>
            </form>
</p>
              </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4><i class="fa fa-lg fa-book" aria-hidden="true"></i>  <span class="text-uppercase"><?php echo $sub ?></span><span class="small"></span>
                    <a style="margin-left:450px" class="btn btn-success btn-sm" href="set_questions.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $exam_id ?>">Add / Edit Question</a>
                  </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="documents" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>Qus_No</th>
                                                <th>Question</th>
                                                <th>A</th>
                                                <th>B</th>
                                                <th>C</th>
                                                <th>D</th>
                                                <th>ANS</th>
                                                <th>DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                    $st_query = "SELECT * FROM questions WHERE course_id = $exam_id ORDER BY qus_no ASC ";
                                                    $select_questions_query = mysqli_query($connection, $st_query);
                                                    if(!$select_questions_query){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($qs_row = mysqli_fetch_array($select_questions_query)) {
                                                $qus_id = $qs_row['id'];
                                                $qus_text = $qs_row['text'];
                                                $qus_no = $qs_row['qus_no'];
                                                $course_id = $qs_row['course_id'];
                                                ?>
                                                <tr>
                                                    <td><?php echo $qus_no; ?></td>
                                                    <td><?php echo $qus_text; ?></td>
                                                    <?php
                                                    // get Result
                                                    $c_query = "SELECT * FROM choices WHERE qus_no = $qus_no AND course_id = $exam_id ORDER BY RAND()";
                                                    // Get result
                                                    $choices = $mysqli->query($c_query) or die($mysqli->error);
                                                    if(!$choices){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($row = $choices->fetch_assoc()): ?>
                                                    <td><?php echo $row['text']; ?></td>
                                                    <?php endwhile ?>
                                                    <?php
                                                    $c_query = "SELECT * FROM choices WHERE qus_no = $qus_no AND course_id = $exam_id AND is_correct = 1 ORDER BY RAND()";
                                                    // Get result
                                                    $choices = $mysqli->query($c_query) or die($mysqli->error);
                                                    if(!$choices){
                                                    die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($row = $choices->fetch_assoc()): ?>
                                                    <td><?php echo $row['text']; ?></td>
                                                    <?php endwhile ?>
                                                    <td>
                                                        <a rel='<?php echo $qus_no ?>' href='javascript:void(0)' class='delete_link'><button class="btn btn-danger btn-xs">Delete</button></a>
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
<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="false">
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
                <h5>Are you Sure You Want To Delete This Question?</h5>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-danger modal_delete_link">Delete</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<!-- basic modal -->
<div class="modal fade" id="basicModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
          aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Delete All Questions</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to delete all questions?</p>
              </div>
              <div class="modal-footer bg-whitesmoke br">
                <a href="exam_qus.php?id=<?php echo $exam_id?>&deleteAll=all" class="btn btn-danger modal_alldelete_link" class="btn btn-danger">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>

<?php
if(isset($_GET['delete'])){
    $the_qus_no = sanitize($_GET['delete']);


    $ans_query = "DELETE FROM choices WHERE qus_no = {$the_qus_no} AND course_id = {$exam_id}";
    $delete_ans_query = mysqli_query($connection, $ans_query);

    $query = "DELETE FROM questions WHERE qus_no = {$the_qus_no} AND course_id = {$exam_id}";
    $delete_query = mysqli_query($connection, $query);


    header("Location: exam_qus.php?id=$exam_id");
}

if(isset($_GET['deleteAll'])){
    $the_qus_no = sanitize($_GET['deleteAll']);


    $ans_query = "DELETE FROM choices WHERE course_id = {$exam_id}";
    $delete_ans_query = mysqli_query($connection, $ans_query);

    $query = "DELETE FROM questions WHERE course_id = {$exam_id}";
    $delete_query = mysqli_query($connection, $query);


    header("Location: exam_qus.php?id=$exam_id");
}

?>


        <?php include "includes/footer.php"?>
        <script>

    $(document).ready(function(){
        $(".delete_link").on('click', function(){
            var id = $(this).attr("rel");

            var delete_url = "exam_qus.php?id=<?php echo $exam_id ?>&delete="+ id +" ";

            $(".modal_delete_link").attr("href", delete_url);

            $("#myModal").modal('show');


        });
    });

</script>
<script type="text/javascript">
        $(document).ready(function() {
            $('#documents').DataTable( {
                "lengthMenu": [ 20, 40, 60, 80, 100],
                dom: 'Blfrtip',
                buttons: [
                    // 'copy', 'csv', 'excel', 'pdf', 'print'

                    {
                        extend: 'excel',
                        title: '<?php echo $sub ?>',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6]
                        }
                    },
                    {
                        extend: 'pdf',
                        title: '<?php echo $sub ?>',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6] // indexes of the columns that should be printed,
                        }                      // Exclude indexes that you don't want to print.
                    },
                    {
                        extend: 'csv',
                        title: '<?php echo $sub ?>',
                        exportOptions: {
                            columns: [0,1,2,3,4,5,6]
                        }

                    },
                    {
                        extend: 'print',
                        title: '<?php echo $sub ?>',
                        exportOptions:{
                            columns: [0,1,2,3,4,5,6]
                        }
                    }
                ]

            } );
        } );


    </script>