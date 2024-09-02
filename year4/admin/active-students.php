<?php include "includes/header.php"?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <h4><i class="fa fa-lg fa-home" aria-hidden="true"></i>  <span class="text-uppercase"> List of all active students</span><span class="small"></span></h4>
                  </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive table-bordered">
                                    <table id="answers" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>S/N</th>
                                                <th>Class</th>
                                                <th>Student Name</th>
                                                <th>Reg Number</th>
                                                <th>Subject</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                $st_ans_query = "SELECT * FROM current_students";
                                                $select_students_ans_query = mysqli_query($connection, $st_ans_query);
                                                if(!$select_students_ans_query){
                                                    die("QUERY FAILED". mysqli_error($connection));
                                                }
                                                $i = 0;
                                                while($s_row = mysqli_fetch_array($select_students_ans_query)) {
                                                $st_id = $s_row['st_id'];
                                                $c_id = $s_row['exam_id'];
                                                $i++;

                                                ?>
                                                <tr>
                                                    <?php
                                                    // get Result
                                                    $qus_query = "SELECT * FROM students WHERE id = $st_id";
                                                    // Get result
                                                    $qus = $mysqli->query($qus_query) or die($mysqli->error);
                                                    if(!$qus){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($row = $qus->fetch_assoc()):
                                                        $first_name = $row['first_name'];
                                                        $last_name = $row['last_name'];
                                                        $reg_no = $row['reg_no'];
                                                        $class = $row['class'];
                                                    ?>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $class ; ?></td>
                                                        <td><?php echo $last_name." ".$first_name ; ?></td>
                                                        <td><?php echo $reg_no; ?></td>
                                                    <?php endwhile ?>
                                                    <?php
                                                    $ans_query = "SELECT * FROM courses WHERE id = $c_id";
                                                    // Get answer
                                                    $ans = $mysqli->query($ans_query) or die($mysqli->error);
                                                    if(!$ans){
                                                        die("QUERY FAILED". mysqli_error($connection));
                                                    }
                                                    while($row = $ans->fetch_assoc()):
                                                        $course_name = $row['course_name'];
                                                        ?>
                                                        <td><?php echo $course_name; ?></td>
                                                    <?php endwhile ?>
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