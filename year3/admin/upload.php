<?php include "includes/header.php"?>
<?php
$csv = new csv();
if(isset($_GET['class']) && isset($_GET['sub']) && isset($_GET['id'])  ){
    $sub_class =  $_GET['class'];
    $class_id =  $_GET['c_id'];
    $sub = $_GET['sub'];
    $course_id = $_GET['id'];
    $query = "SELECT * FROM questions WHERE course_id = $course_id AND class_id = $class_id";
    $results = $mysqli->query($query) or die($mysqli->error);
    $class = $results->fetch_assoc();
    $totalQus = $results->num_rows;
    function upload_csv()
    {
        $sub = $_GET['sub'];
        $class_id =  $_GET['c_id'];
        $course_id = $_GET['id'];
        global $connection;
        if (isset($_POST['sub'])) {
            //die($csv->import($_FILES['file']['tmp_name']));
            if ($_FILES['file']['name']) {
                $filename = explode('.', $_FILES['file']['name']);
                if ($filename[1] == 'csv') {
                    $handle = fopen($_FILES['file']['tmp_name'], "r");
                    $row = 1;
                    while ($data = fgetcsv($handle)) {
                        if(!isset($data[6])) {
                            $errors[] = "OPPs, I cannot find Answer column";
                        }
                            $qus_no = mysqli_real_escape_string($connection, $data[0]);
                            $qus_text = mysqli_real_escape_string($connection, $data[1]);
                        $choices = array();
                        $choices[1] = mysqli_real_escape_string($connection, $data[2]);
                        $choices[2] = mysqli_real_escape_string($connection, $data[3]);
                        $choices[3] = mysqli_real_escape_string($connection, $data[4]);
                        $choices[4] = mysqli_real_escape_string($connection, $data[5]);
                        $correct_choice = mysqli_real_escape_string($connection, $data[6]);
                        if ($row == 1) {
                            if ($qus_no != "Qus_No") {
                            //print_r($item1);
                                $errors[] = "The first row of your question number column failed our validation, 
                            pls ensure that the csv file follows the specified format";
                            }
                        } else {
                            // check if question number is integer
                            if (is_numeric($qus_no) == false) {
                                $errors[] = "OPPs!!! I Found $qus_no as a Question Number and $qus_no is not a valid integer, Pls Check The CSV file";
                            }
                            // check for repeated question number
                            $qus_query = "SELECT * FROM questions WHERE course_id = $course_id AND class_id = $class_id AND qus_no = $qus_no";
                            $results = $connection->query($qus_query) or die($connection->error . __LINE__);
                            if ($results->num_rows > 0) {
                                $errors[] = "Question Number $qus_no already exit, view the exiting questions and make sure Your CSV file doesnt have repeated/missing question number";
                            }
                            if (empty($errors) === true && empty($_POST) === false) {
                                $query = "INSERT INTO questions(qus_no, text, course_id, class_id) VALUES(?,?,?,?)";
                                $stmt = mysqli_prepare($connection, $query);
                                mysqli_stmt_bind_param($stmt, 'isii', $qus_no, $qus_text, $course_id, $class_id);
                                mysqli_stmt_execute($stmt);
                                mysqli_stmt_close($stmt);
                                if (!$stmt) {
                                    die("QUERY FAILED" . mysqli_error($connection));
                                }else {
                                    foreach ($choices as $choice => $value){
                                        if($value != ''){
                                            if(strtolower($correct_choice) == strtolower($value)){
                                                $is_correct = 1;
                                            } else {
                                                $is_correct = 0;
                                            }
                                            //choice query
                                            $query = "INSERT INTO `choices` (qus_no, course_id, is_correct, text) VALUES ('$qus_no', '$course_id', '$is_correct', '$value')";
                                            //$query = "INSERT INTO `test_choice` (qus_no, course_id, text) VALUES ('$qus_no', '$course_id', '$value')";
                                            //Run query
                                            $insert_row = $connection->query($query) or die($connection->error.__LINE__);
                                            //validate insert
                                            if($insert_row){
                                                continue;
                                            } else {
                                                die($connection->error.__LINE__);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                        ++$row;
                    }
                    fclose($handle);
                } else {
                    $errors[] = "The File You Selected is Not A CSV file";
                }
                if (empty($errors)) {
                                echo "<div class='alert-success text-center'>
                                <p>Success!!! <br>
                                    You Have Successfully Uploaded ".$sub." questions <br>
                                </p>
                            </div>";
                } else{
                    echo output_errors($errors);
                }
            }
        }
    }
}else {
    redirect('subjects.php');
}
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="section-body">
    <a href="subjects.php" class="btn btn-outline-primary">Go Back</a><br><br>
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <h4><i class="fa fa-lg fa-book" aria-hidden="true"></i>  <span class="text-uppercase"><?php echo $sub ?> Questions</span><span class="small"></span>
                  </div>
                  <div class="card-body">
                        <div class="row">
                            <div>
                                <?php upload_csv() ?>
                            </div>
                            <div class="col-md-12">
                                <form class="row form-inline" method="post" enctype="multipart/form-data" role="form">
                                    <div class="form-group col-xs-8">
                                        <input type="file" class="form-control" placeholder="choose file" name="file">
                                    </div>
                                    <input type="submit" style="margin-left:20px"class="col-xs-4 btn btn-primary" name="sub" value="Import CSV">
                                </form>
                            </div>
                        </div>
                  </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Subject Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table id="documen" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Class</th>
                                                <th>Questions</th>
                                                <th>View Question</th>
                                                <th>Export Question</th>
                                                <th>Note</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $sub ?></td>
                                                <td><?php echo $sub_class ?></td>
                                                <td><?php echo $totalQus ?></td>
                                                <td><a class="btn btn-primary btn-xs" href="set_questions.php?xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs=<?php echo $course_id ?>">Edit Question</a></td>
                                                <td><a class="btn btn-success btn-xs" href="exam_qus.php?id=<?php echo $course_id ?>">View / Export</a></td>
                                                <th>Make Sure You Upload CSV of This Particular Subject, <br>Any Error in Your CSV will Make Subject not Examinable</th>
                                            </tr>
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
