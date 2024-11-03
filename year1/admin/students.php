<?php include "includes/header.php"?>
<?php

$sub = "Student List";
$sql= "SELECT * FROM class";
$resultsQuery = mysqli_query($connection, $sql);
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">

                <?php
                // Check if there's a success parameter in the URL
                if (isset($_GET['upload'])) {
                    if ($_GET['upload'] == 'success') {
                        echo "<div class='alert alert-success text-center'>
                                <p>Photo uploaded successfully!</p>
                              </div>";
                    } elseif ($_GET['upload'] == 'failed') {
                        echo "<div class='alert alert-danger text-center'>
                                <p>Failed to upload photo. Please try again.</p>
                              </div>";
                    } elseif ($_GET['upload'] == 'error') {
                        echo "<div class='alert alert-warning text-center'>
                                <p>Something went wrong. Please try again.</p>
                              </div>";
                    }
                }
                ?>
                <p>

                <form action="" method="post">
                    <button class="btn btn-outline-success" type="button" data-toggle="collapse"
                        data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Import Student (CSV)
                    </button>
                    <button class="btn btn-outline-primary" type="button" data-toggle="modal"
                        data-target=".bd-example-modal-lg">
                        Add Student
                    </button>
                    <input type="hidden" name="selStu_Value" id="selStu_Value">
                    <button type="submit" class="btn btn-outline-info" name="assignClass">
                        Assign Course
                    </button>
                    <button class="alldelete_link btn btn-outline-danger" type="button" data-toggle="modal"
                        data-target="#basicModal">
                        Delete All Students
                    </button>
                    <a href="template/AddStudentTemplate.csv" class="btn btn-outline-secondary" download>Download CSV
                        Template</a>
                </form>
                </p>
            </div>
            <?php
                        function upload_csv()
                    {
                        global $connection;
                        if (isset($_POST['import'])) {
                            $classId = $_POST['ClassId'];
                            $class = $_POST['class'];
                            $profile = "passport.jpg";

                            

                            if ($_FILES['file']['name']) {
                                $filename = explode('.', $_FILES['file']['name']);
                                if ($filename[1] == 'csv') {

                                    $handle = fopen($_FILES['file']['tmp_name'], "r");
                                    $row = 1;
                    //                $all = fgetcsv($handle);


                                    while ($data = fgetcsv($handle)) {

                                        $first_name = mysqli_real_escape_string($connection, $data[0]);
                                        $last_name = mysqli_real_escape_string($connection, $data[1]);
                                        $reg_no = mysqli_real_escape_string($connection, $data[2]);


                                        if ($row == 1) {
                                            if ($first_name != "First Name") {
                    //                            print_r($item1);
                                                $errors[] = "The first Column Of Your CSV File is not <strong>First Name</strong>";
                                            }
                                            if($reg_no != "Reg Number"){
                                                $errors[] = "The Third Column Of Your CSV File is not <strong>Reg No</strong>";
                                            }

                                        } else {


                                            if (empty($errors) === true && empty($_POST) === false) {

                                                    if (user_exit('students', 'reg_no', $reg_no) > 0) {

                                                    echo "<div class='row alert alert-warning'>
                                                <p>A duplicate Reg No : <strong>$reg_no</strong> detected and removed from the list</p>
                                            </div>";

                                                } else{
                                                    $query = "INSERT INTO students(first_name, last_name, reg_no, class, class_id, profile_photo) VALUES(?,?,?,?,?,?)";

                                                    $stmt = mysqli_prepare($connection, $query);

                                                    mysqli_stmt_bind_param($stmt, 'ssssis', $first_name, $last_name, $reg_no, $class, $classId, $profile);

                                                    mysqli_stmt_execute($stmt);

                                                    

                                                    if (!$stmt) {
                                                        die("QUERY FAILED" . mysqli_error($connection));
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
                                    echo "<div class='row alert-success text-center'>
                                                    <p>Success!!! <br>

                                                        You Have Successfully Uploaded The Students Lists <br>



                                                    </p>

                                                </div><br>";
                                } else{

                                    echo output_errors($errors);
                                }
                            }
                        }

                    }
                    ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Students List</h4>
                    </div>
                    <div class="card-body">
                        <div class="collapse" id="collapseExample">
                            <p>
                            <div>
                                <?php upload_csv() ?>
                            </div>
                            <h4>Upload Students</h4>
                            <form class="form-inline row" method="post" enctype="multipart/form-data" role="form">
                                <div class="form-group col-xs-4">
                                    <input type="file" class="form-control" placeholder="choose file" name="file">
                                </div>
                                <div class="form-group col-xs-4">
                                    <select name="class" id="class" class="form-control" style="margin:10px">
                                        <option value="disabled">Class</option>
                                        <option value="year1">YEAR1</option>
                                    </select>
                                    <select name="ClassId" id="" class="form-control" style="margin:10px">
                                        <option value="disabled">Select</option>
                                        <?php 
                                $sub = "Student List";
                                $sql= "SELECT * FROM class";
                                $resultsQuery2 = mysqli_query($connection, $sql);
                                while ($rowClas= mysqli_fetch_assoc($resultsQuery2)){?>
                                        <option value="<?php echo $rowClas["id"];?>">
                                            <?php echo $rowClas["id"]."_".$rowClas["name"];?></option>
                                        <?php };?>
                                    </select>
                                </div>
                                <div class="form-group col-xs-4">
                                    <input type="submit" class="col-xs-4 btn btn-primary" name="import"
                                        value="Import students">
                                </div>
                            </form>
                            </p>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped" id="documents">
                                <thead>
                                    <tr>

                                        <th class="text-center pt-3">
                                            <?php 
                if (isset($_POST['assignClass']) && !empty($_POST['selStu_Value']) && isset($_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs'])){
                    $studentID=$_POST['selStu_Value'];
                    $class_ID=$_GET['xsssdsdxxssdhfdghsjhfjdhdhsjdhdhfjfhsbsdhddjshs'];
                    $studentID=explode("-",$studentID);
                    $total_Stu=count($studentID)-1;
                    $countInsert=0;
                    while ($countInsert<=$total_Stu){
                        $c_StuID=$studentID[$countInsert];
                        if (!empty($c_StuID)){
                            $query = "INSERT INTO `registered_exams`(student_id, course_id) 
                            VALUES('$c_StuID', '$class_ID')";
                    
                            //Run query
                    
                            $insert_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
                            
                        }
                        $countInsert++;
                        
                
                    } 
                
                }
                ?>
                                            <div class="custom-checkbox custom-checkbox-table custom-control">
                                                <input type="checkbox" value="" name="checkbox"
                                                    data-checkboxes="mygroup" data-checkbox-role="dad"
                                                    class="custom-control-input"
                                                    onClick="check_uncheck_checkbox(this.checked);" id="checkbox-all">
                                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </th>
                                        <th>Seat No</th>
                                        <th>Full Name</th>
                                        <th>Reg No</th>
                                        <th>Class</th>
                                        <th>Action1</th>
                                        <th>Action2</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

$st_query = "SELECT * FROM students";
$select_students_query = mysqli_query($connection, $st_query);
$total_Students=mysqli_num_rows($select_students_query);

if(!$select_students_query){
    die("QUERY FAILED". mysqli_error($connection));
}

while($st_row = mysqli_fetch_array($select_students_query)) {

    $st_id = $st_row['id'];
    $st_class_id = $st_row['class_id'];
    $st_first_name = $st_row['first_name'];
    $st_last_name = $st_row['last_name'];
    $full_name = "$st_first_name $st_last_name";
    $st_reg_no = $st_row['reg_no'];
    $st_class = $st_row['class'];
    $st_name = "$st_first_name $st_last_name";



    ?>
                                    <tr>

                                        <td class="text-center pt-2">
                                            <div class="custom-checkbox custom-control">
                                                <input type="checkbox" data-checkboxes="mygroup"
                                                    class="custom-control-input sel_Stu" data-value="<?=$st_id ?>"
                                                    id="selected_stu<?=$st_id?>" name="selected_stu<?=$st_id?>">
                                                <label for="selected_stu<?=$st_id?>"
                                                    class="custom-control-label">&nbsp;</label>
                                            </div>
                                        </td>
                                        <td><?php echo $st_id; ?></td>
                                        <?php
        $courses_query = "SELECT * FROM class WHERE id = $st_class_id";

        $results = $mysqli->query($courses_query) or die($mysqli->error.__LINE__);

        while($cl_row = mysqli_fetch_array($results)) {
            $cl_name = $cl_row['name'];
        ?>


                                        <?php } ?>
                                        <td><?php echo $full_name; ?></td>
                                        <td><?php echo $st_reg_no; ?></td>
                                        <td><?php echo $st_class; ?></td>
                                        <td>
                                            <form action="uploadPhoto.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="student_id"
                                                    value="<?php echo $st_row['id']; ?>">
                                                <input type="file" name="profile_photo" required>
                                                <button type="submit" class="btn btn-primary btn-xs">Upload
                                                    Photo</button>
                                            </form>
                                        </td>
                                        <td><a rel='<?php echo $st_row['id']; ?>' data-toggle="modal"
                                                data-target=".bd-example-modal-sm" href='javascript:void(0)'
                                                class='delete_link btn btn-danger btn-xs'>Delete User</a></td>



                                        <!-- <td><a rel='<?php echo $st_row['id']; ?>' data-toggle="modal" data-target=".bd-example-modal-sm" href='javascript:void(0)' class='delete_link btn btn-danger btn-xs'>Delete User</a>

        <a rel='<?php echo $st_row['id']; ?>' href='uploadPhoto.php?' class='update-link btn btn-primary btn-xs'>Upload Photo</a>
         </td> -->
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

    <?php

    if(isset($_GET['delete'])){
        $the_st_id = sanitize($_GET['delete']);

        $query = "DELETE FROM students WHERE id = {$the_st_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: students.php");
    }

    if (isset($_GET['deleteAll'])) {
        $query = "DELETE FROM students";
        $delete_query = mysqli_query($connection, $query);
        header("Location: students.php");
        exit(); // Stops further execution after redirect
    }

if(isset($_POST['updateSubmit'])){
$prefix = $_POST['regHd'];
$id = $_POST['id'];
$session = $_POST['session'];
$regNo = $_POST['regNo'];
$classId = $_POST['ClassId'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$class = $_POST['class'];
$profile = "passport.jpg";

$myFname = strtoupper($fname);
$myLname = strtoupper($lname);
$myPrefix = strtoupper($prefix);

$myReg=$myPrefix."/".$session."/".$regNo;

        $query = "UPDATE students SET first_name='$myFname',last_name='$myLname',reg_no='$myReg',class='$class',profile_photo='$profile',class_id='$classId' WHERE id= {$the_st_id}";
        $update_query = mysqli_query($connection, $query);
    
    }
    
    ?>
</section>
<!-- Small Modal -->
<div class="modal fade bd-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mySmallModalLabel">Delete Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you Sure You Want To Delete This Student?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <a href="" class="btn btn-danger modal_delete_link" class="btn btn-danger">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
                <h5 class="modal-title" id="exampleModalLabel">Delete All Students</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete all students?</p>
            </div>
            <div class="modal-footer bg-whitesmoke br">
                <a href="" class="btn btn-danger modal_alldelete_link" class="btn btn-danger">Delete</a>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Large modal -->
<div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel">Register Student</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="reg">Reg Number</label><br>
                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" placeholder="Add Prefix-eg: MCONSA/NUR" class="form-control" required
                                    name="regHd" title="Add your school prefix eg: MCONSA/NUR" id="reg">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" name="session" id="session">
                                    <option value="disabled">Session</option>
                                    <option value="2022">2022</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2025">2025</option>
                                    <option value="2026">2026</option>
                                    <option value="2027">2027</option>
                                    <option value="2028">2028</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="text" class="form-control" placeholder="Reg no." required name="regNo"
                                    id="reg">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="classId">Class Id</label>
                        <select name="ClassId" id="" class="form-control">
                            <option value="disabled">Select</option>
                            <?php 
                                $sub = "Student List";
                                $sql= "SELECT * FROM class";
                                $resultsQuery2 = mysqli_query($connection, $sql);
                                while ($rowClas= mysqli_fetch_assoc($resultsQuery2)){?>
                            <option value="<?php echo $rowClas["id"];?>">
                                <?php echo $rowClas["id"]."_".$rowClas["name"];?></option>
                            <?php };?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" placeholder="First Name" required name="fname" id="">
                    </div>
                    <div class="form-group">
                        <label for="lname">Last Name</label>
                        <input type="text" class="form-control" placeholder="Last Name" required name="lname" id="">
                    </div>
                    <div class="form-group">
                        <label for="class">Class</label>
                        <select name="class" id="class" class="form-control">
                            <option value="disabled">Class</option>
                            <option value="year1">YEAR1</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <input type="submit" value="Add" class="btn btn-primary" name="addSubmit" style="float:right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php 
if(isset($_POST['addSubmit'])){
$prefix = $_POST['regHd'];
$session = $_POST['session'];
$regNo = $_POST['regNo'];
$classId = $_POST['ClassId'];
$fname = $_POST['fname'];
$lname = $_POST['lname'];
$class = $_POST['class'];
$profile = "passport.jpg";

$myFname = strtoupper($fname);
$myLname = strtoupper($lname);
$myPrefix = strtoupper($prefix);

$myReg=$myPrefix."/".$session."/".$regNo;

$sql = "INSERT INTO `students`( `first_name`, `last_name`, `reg_no`, `class`, `profile_photo`, `class_id`) VALUES ('$myFname','$myLname','$myReg','$class','$profile','$classId')";
$resultsQueryAdd = mysqli_query($connection, $sql);
if($resultsQueryAdd){
 header("Location: students.php?status=success");
 exit;
}else {
    header("Location: students.php?status=failed");
    exit;
}


}
?>
<?php include "includes/footer.php"?>
<script>
$(document).ready(function() {
    $(".delete_link").on('click', function() {
        var id = $(this).attr("rel");

        var delete_url = "students.php?delete=" + id + " ";

        $(".modal_delete_link").attr("href", delete_url);

        $("#myModal").modal('show');


    });


});
</script>
<script>
$(document).ready(function() {
    $(".alldelete_link").on('click', function() {
        var id = $(this).attr("rel");

        var delete_url = "students.php?deleteAll=all ";

        $(".modal_alldelete_link").attr("href", delete_url);

        $("#basicModal").modal('show');


    });


});
</script>
<script>
function check_uncheck_checkbox(isChecked) {
    if (isChecked) {
        $('input[class="sel_Stu"]').each(function() {
            this.checked = true;
            $('.sel_Stu').change();
        });
    } else {
        $('input[class="sel_Stu"]').each(function() {
            this.checked = false;
            $('#selStu_Value').val("");
        });
    }
}

$(document).ready(function() {

    $('.sel_Stu').change(function() {
        var total = "";
        $('.sel_Stu:checked').each(function() {
            var currenStud = "#selStu_Value" + $(this).data('value');
            //alert(currenStud);
            total += "-" + $(this).data('value');

        });
        $('#selStu_Value').val(total);
    });

    $('#documents').DataTable({
        "lengthMenu": [50, 100, 150, 200, 250, 300, 500, 1000],
        dom: 'Blfrtip',
        buttons: [
            // 'copy', 'csv', 'excel', 'pdf', 'print'

            {
                extend: 'excel',
                title: '<?php echo $sub ?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            },
            {
                extend: 'pdf',
                title: '<?php echo $sub ?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5] // indexes of the columns that should be printed,
                } // Exclude indexes that you don't want to print.
            },
            {
                extend: 'csv',
                title: '<?php echo $sub ?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }

            },
            {
                extend: 'print',
                title: '<?php echo $sub ?>',
                exportOptions: {
                    columns: [1, 2, 3, 4, 5]
                }
            }
        ]

    });
})
</script>