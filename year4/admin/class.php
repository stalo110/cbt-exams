<?php include "includes/header.php"?>
<?php
if(isset($_POST['editClass'])) {
    $name = sanitize($_POST['name']);
    $class_id = sanitize($_POST['id']);
    $query = "UPDATE class SET name = '$name' WHERE id=$class_id";
    //Run query
    $update_row = $mysqli->query($query) or die($mysqli->error.__LINE__);
}
function add_new_class(){
    global $connection;
    if (isset($_POST['add_class'])) {
        $name = sanitize($_POST['name']);
        $required_fields = array('name');
        foreach ($_POST as $key => $value) {
            if (empty($value) && in_array($key, $required_fields) === true) {
                $errors[] = 'Fields marked with an asterisk Are Required';
                break 1;
            }
        }
        if (empty($errors) === true) {
            if (user_exit('class', 'name', $name ) > 0) {
                $errors[] = 'Sorry, The Class \'' . $name . '\' already exit.';
            }
        }
        if (empty($errors) === true && empty($_POST) === false) {
            $query = "INSERT INTO class(name) VALUES(?)";
            $stmt = mysqli_prepare($connection, $query);
            mysqli_stmt_bind_param($stmt, 's', $name);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            if (!$stmt) {
                die("QUERY FAILED" . mysqli_error($connection));
            }else{
                echo '<div class="alert-success text-center">
                                <p>Success!!! <br>
                                    The New Class Has been Added Successfully <br>
                                </p>
                            </div>';
            }
        } else {
            echo output_errors($errors);
        }
    }
}
?>
<?php include "includes/navbar.php"?>
<?php include "includes/sidebar.php"?>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                  <h4><i class="fa fa-lg fa-home" aria-hidden="true"></i>  <span class="text-uppercase">Add New Class</span><span class="small"></span></h4>
                  </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                            <div><?php add_new_class() ?></div>
                                <form id="add" class="form-inline" method="post" role="form">
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label" for="">Class Name <span class="text-danger">*</span></label>
                                        <div class="col-sm-8">
                                            <input required type="text" name="name" placeholder="" class="form-control">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class=" ">
                                            <div class="pull-right">

                                                <button type="submit" name="add_class" class="btn btn-primary">Add Class</button>
                                            </div>
                                        </div>
                                    </div>
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
                  <h4><i class="fa fa-lg fa-home" aria-hidden="true"></i>  <span class="text-uppercase">All Class</span><span class="small"></span></h4>
                  </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <?php
                                    if(isset($_POST['editClass'])){ ?>
                                    <div class="alert alert-success"><span class=""></span> <?php echo $name ?> updated successfully </div>
                                <?php } ?>
                                <div class="table-responsive">
                                    <table id="documents" class="table table-bordred table-striped">
                                        <thead>
                                            <tr>
                                                <th>Key</th>
                                                <th>Name</th>
                                                <th>Exams</th>
                                                <th>Students</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            $st_query = "SELECT * FROM class";
                                            $select_questions_query = mysqli_query($connection, $st_query);
                                            if(!$select_questions_query){
                                            die("QUERY FAILED". mysqli_error($connection));
                                            }
                                            while($qs_row = mysqli_fetch_array($select_questions_query)) {
                                            $class_id = $qs_row['id'];
                                            $name = $qs_row['name'];
                                            ?>
                                            <tr>
                                                <td><?php echo $class_id; ?></td>
                                                <td><?php echo $name; ?></td>
                                                <?php
                                                $courses_query = "SELECT * FROM courses WHERE class_id = $class_id";

                                                $results = $mysqli->query($courses_query) or die($mysqli->error.__LINE__);

                                                $totalCus = $results->num_rows;
                                                ?>
                                                <td><?php echo $totalCus ?> Exam(s) Available</td>
                                                <?php
                                                $st_query = "SELECT * FROM students WHERE class_id = $class_id";
                                                $results = $mysqli->query($st_query) or die($mysqli->error.__LINE__);
                                                $totalSt = $results->num_rows;
                                                ?>
                                                <td><?php echo $totalSt ?> Student(s) </td>
                                                <td><p data-placement="top" data-toggle="tooltip" title="Edit"><button class="btn btn-primary btn-xs" data-title="Edit" data-toggle="modal" data-target="#edit<?php echo $class_id ?>" ><span class="fa fa-edit"></span></button></p></td>
                                                <td>
                                                    <a rel='<?php echo $class_id ?>' href='javascript:void(0)' class='delete_link'><button class="btn btn-danger btn-xs">Delete</button></a>
                                                </td>

                                                <div class="modal fade" id="edit<?php echo $class_id ?>" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="fa fa-times" aria-hidden="true"></span></button>
                                                                <h4 class="modal-title custom_align" id="Heading">Edit Class</h4>
                                                            </div>
                                                            <form action="" method="post">
                                                                <div class="modal-body">
                                                                    <div class="form-group">
                                                                        <label>Class Name</label>
                                                                        <input class="form-control " name="name" value="<?php echo $name ?>"type="text" placeholder="Class Name">
                                                                    </div>

                                                                </div>
                                                                <div class="modal-footer ">

                                                                    <input type="hidden" name="id" value="<?php echo $class_id ?>" />
                                                                    <input type="submit" class="btn btn-success" name="editClass" value="submit" />
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <!-- /.modal-content -->
                                                    </div>
                                                    <!-- /.modal-dialog -->
                                                </div>
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

<div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="false">
    <div class="modal-dialog">
        <!--        modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete Claa</h4>

            </div>
            <div class="modal-body">
                <h5>Are you Sure You Want To Delete This Class?</h5>
                <p>Note : If you delete this class all associated exams will be deleted as well</p>
            </div>
            <div class="modal-footer">
                <a href="" class="btn btn-danger modal_delete_link">Delete</a>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_GET['delete'])){
    $the_class_id = sanitize($_GET['delete']);
    $cos_query = "DELETE FROM course WHERE class_id = {$the_class_id}";
    $delete_cos_query = mysqli_query($connection, $cos_query);
    $query = "DELETE FROM class WHERE id = {$the_class_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: class.php");
}
?>
        <?php include "includes/footer.php"?>
<script>
$(document).ready(function(){
    $(".delete_link").on('click', function(){
        var id = $(this).attr("rel");
        var delete_url = "class.php?id=<?php echo $class_id ?>&delete="+ id +" ";
        $(".modal_delete_link").attr("href", delete_url)
        $("#myModal").modal('show');
    });
});
</script>

<script type="text/javascript">
        $(document).ready(function() {
            $('#documents').DataTable( {
                "lengthMenu": [ 20, 40, 60, 80, 100],
            } );
        } );


    </script>