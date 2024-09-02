<?php
function logged_in(){

    return (isset($_SESSION['reg_no']) && isset($_SESSION["name"]) && isset($_SESSION["userid"])) ? true : false;
}

function lecturer_logged_in(){

    return (isset($_SESSION['staff_id'])) ? true : false;
}

function output_errors($errors){
    return '<div class="alert alert-danger"><ul class="ul" style="list-style:none; padding: 5px; margin-top:7px"><li>' . implode('</li><li>', $errors) . '</li></ul></div>';
}

function total($row){
    global $connection;
    $query = mysqli_query($connection, "SELECT * FROM $row");
    return $query->num_rows;
}

class csv extends mysqli{
    public function import($file){
        $file = fopen($file, 'r');
        var_dump($file);
//        while($row = fgetcsv($file)){
//            $value = "'". implode("','", $row). "'";
//            echo $value;
////            print "<pre>";
////            print_r($row);
////            print "<pre>";
//
//        }
    }

}

function is_admin(){

    return ($_SESSION['user_type'] === 'admin') ? true : false;
}


function nonRepeat($min,$max,$count) {

    //prevent function from hanging
    //due to a request of more values than are possible
    if($max - $min < $count-1) {
        return false;
    }

    $nonrepeatarray = array();
    for($i = 0; $i < $count; $i++) {
        $rand = rand($min,$max);

        //ensure value isn't already in the array
        //if it is, recalculate the rand until we
        //find one that's not in the array
        while(in_array($rand,$nonrepeatarray)) {
            $rand = rand($min,$max);
        }

        //add it to the array
        $nonrepeatarray[$i] = $rand;
    }
    return $nonrepeatarray;
}

function array_push_assoc($array, $key, $value){
    $array[$key] = $value;
    return $array;
}


function redirect($location){
    header("Location: $location");

}



function confirmQuery($result){
    global $connection;
    if(!$result){
        die("QUERY FAILED ." . mysqli_error($connection));
    }
}

function sanitize($data){
    global $connection;
    return mysqli_real_escape_string($connection, strip_tags(trim($data)));;
}

function getValue($field, $table, $id){
    global $connection;
    return $connection->query("SELECT $field FROM $table WHERE id = $id")->fetch_object()->$field;
}
//
//function getNumRow(){
//    global $connection;
//    $current_query = "SELECT * FROM current_students
//					   WHERE st_id = $student_id";
//
//// Get result
//    $check_current = $connection->query("SELECT * FROM current_students WHERE st_id = $student_id") or die($mysqli->error);
//}


function user_exit($table, $field, $input){

    global $connection;

    $stmt = mysqli_prepare($connection, "SELECT id FROM $table WHERE $field = ? ");
    mysqli_stmt_bind_param($stmt, 's', $input);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    confirmQuery($stmt);
    return mysqli_stmt_num_rows($stmt);
}

function definite_exit($table, $field1, $input1, $field2, $input2){

    global $connection;

    $stmt = mysqli_prepare($connection, "SELECT id FROM $table WHERE $field1 = ? AND $field2 = ?");
    mysqli_stmt_bind_param($stmt, 'ss', $input1, $input2);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    confirmQuery($stmt);
    return mysqli_stmt_num_rows($stmt);
}

function compressImage($source_image, $compress_image) {
    $image_info = getimagesize($source_image);
    if ($image_info['mime'] == 'image/jpeg') {
        $source_image = imagecreatefromjpeg($source_image);
        imagejpeg($source_image, $compress_image, 55);
    } elseif ($image_info['mime'] == 'image/gif') {
        $source_image = imagecreatefromgif($source_image);
        imagegif($source_image, $compress_image, 55);
    } elseif ($image_info['mime'] == 'image/png') {
        $source_image = imagecreatefrompng($source_image);
        imagepng($source_image, $compress_image, 6);
    }
    return $compress_image;
}


function register_user()
{


    global $connection;
    if (isset($_POST['register'])) {
//                    $errors = array();


//        if (empty($_POST) === false) {


        $reg_no = sanitize($_POST['reg_no']);
        $password = sanitize($_POST['password']);
        $hash = md5(md5($password));
        $class = sanitize($_POST['class']);
        $confirm_password = sanitize($_POST['confirm_password']);
        $first_name = sanitize($_POST['first_name']);
        $last_name = sanitize($_POST['last_name']);
        $institution = sanitize($_POST['institution']);
        $subject_1 = sanitize($_POST['subject_1']);
        $subject_2 = sanitize($_POST['subject_2']);
        $subject_3 = sanitize($_POST['subject_3']);
        $subject_4 = sanitize($_POST['subject_4']);
        $gender = sanitize($_POST['gender']);






//            $hash = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));



        $required_fields = array('reg_no', 'password', 'confirm_password');

        foreach ($_POST as $key => $value) {
            if (empty($value) && in_array($key, $required_fields) === true) {
                $errors[] = 'Fields marked with an asterisk Are Required';
                break 1;
            }
        }

        if (empty($errors) === true) {


            if (user_exit('students', 'reg_no', $reg_no ) > 0) {

                $errors[] = 'Sorry, The Reg No \'' . $reg_no . '\' is already Registered.';

            }

            if (strlen($password) < 3) {
                $errors[] = 'Sorry Your Password must be at least 6 characters';
            }

            if ($confirm_password !== $password) {
                $errors[] = 'Your password do not match';
            }

           


           


        }


        if (empty($errors) === true && empty($_POST) === false) {

            $query = "INSERT INTO students(first_name, last_name, password, class, gender, reg_no, institution, subject_1, subject_2, subject_3, subject_4) VALUES(?,?,?,?,?,?,?,?,?,?)";

            $stmt = mysqli_prepare($connection, $query);

            mysqli_stmt_bind_param($stmt, 'ssssssssss', $first_name, $last_name, $hash, $class, $gender, $reg_no, $institution, $subject_1, $subject_2, $subject_3, $subject_4);

            mysqli_stmt_execute($stmt);

            mysqli_stmt_close($stmt);

            if(!$stmt){
                die("QUERY FAILED" . mysqli_error($connection));
            }


            die("<div class='alert alert-success'><p class='text-center'>Congrate!! You Have Successfully Registered For Jamb 2018 CBT TEST  <br>
                You will be redirected To Login Page In few seconds</p></div><meta http-equiv='refresh' content='15;url=http://localhost/e-exam/login.php' />");


        } else {
            echo output_errors($errors);
        }


    }
}



function login_user($location) {
    global $connection;

    if (isset($_POST['login'])) {
        $matric_no = sanitize($_POST['reg_no']);
        $required_fields = array('reg_no');
        $errors = [];

        foreach ($_POST as $key => $value) {
            if (empty($value) && in_array($key, $required_fields) === true) {
                $errors[] = 'The Reg No. Field is Required';
                break;
            }
        }

        if (empty($errors)) {
            if (user_exit('students', 'reg_no', $matric_no) === 0) {
                $errors[] = 'Sorry, The Reg_no \'' . $matric_no . '\' Is Not Registered For This Exam';
            } else {
                $query = "SELECT * FROM students WHERE reg_no = '{$matric_no}' LIMIT 1";
                $select_user_query = mysqli_query($connection, $query);

                if (!$select_user_query) {
                    die("QUERY FAILED: " . mysqli_error($connection));
                }

                $row = mysqli_fetch_array($select_user_query);

                if ($row) {
                    $_SESSION['userid'] = $row['id'];
                    $_SESSION['reg_no'] = $row['reg_no'];
                    $_SESSION['name'] = $row['first_name'] . ' ' . $row['last_name'];
                    $_SESSION['profile_pics'] = $row['profile_pic'];

                    // Redirect to pending approval page
                    redirect('pending_approval.php');
                } else {
                    $errors[] = 'No matching student record found';
                }
            }
        }

        if (!empty($errors)) {
            echo output_errors($errors);
        }
    }
}

function login_lecturer($location){

    global $connection;

    if(isset($_POST['login'])){

        $staff_id = $_POST['staff_id'];
        $password = $_POST['password'];




        $password = sanitize($password);
        $staff_id = sanitize($staff_id);

//        die($voters_id. ' ' .$password);

        $password = md5(md5($password));



        $required_fields = array('password','staff_id');

        foreach($_POST as $key=>$value){
            if(empty($value) && in_array($key, $required_fields) === true){
                $errors[] = 'Both fields Are Required';
                break 1;
            }
        }


        if(empty($errors) === true){

//   Checking for errors



            if((user_exit('teachers', 'staff_id', $staff_id ) === 0)){

                $errors[] = 'Sorry, The Staff ID \'' . $staff_id . '\' does not exit
                ';

            }

            $query = "SELECT * FROM teachers WHERE staff_id = '{$staff_id}' LIMIT 1";
            $select_user_query = mysqli_query($connection, $query);

            if(!$select_user_query){
                die("QUERY FAILED". mysqli_error($connection));
            }

            while($row = mysqli_fetch_array($select_user_query)){
                $db_staff_id = $row['staff_id'];
                $db_password = $row['password'];;
                $db_user_id = $row['id'];
                $db_biometric = $row['biometrics'];


                if($password  != $db_password ) {
                    $errors[] = 'password incorrect';

                }


                if($thumb  != $db_biometric ) {
                    $errors[] = 'Biometric verification fails';

                }


            }





        }

        if(empty($errors) === true && empty($_POST) === false){

            if(($password == $db_password) && ($staff_id == $db_staff_id)) {

                $_SESSION['userid']   = $db_user_id;
                $_SESSION['staff_id'] = $db_staff_id;
                $_SESSION['password'] = $db_password;



                redirect(ROOT_URL.$location);

            }






        }else {
            echo output_errors($errors);
        }



    }

}

function login_admin($location){

    global $connection;

    if(isset($_POST['login'])){

        $ac = $_POST['access_code'];

        $ac = sanitize($ac);


        $required_fields = array('access_code');

        foreach($_POST as $key=>$value){
            if(empty($value) && in_array($key, $required_fields) === true){
                $errors[] = 'The Access Code. Field is Required';
                break 1;
            }
        }


        if(empty($errors) === true){

    //   Checking for errors



            if((user_exit('admins', 'access_code', $ac ) === 0)){

                $errors[] = 'Sorry, The Access Code \'' . $matric_no . '\' Is Not Admin On This System
                ';

            }



            $query = "SELECT * FROM admins WHERE access_code = '{$ac}' LIMIT 1";
            $select_user_query = mysqli_query($connection, $query);

            if(!$select_user_query){
                die("QUERY FAILED". mysqli_error($connection));
            }

            while($row = mysqli_fetch_array($select_user_query)){

                $db_name = $row['name'];
                $db_ac = $row['access_code'];
                $db_user_id = $row['id'];
                $type = "admin";



//
//                    if(!password_verify($password,$db_password) ) {
//                        $errors[] = 'password incorrect';
//
//                    }



                //     if((user_exit('current_students', 'st_id', $db_user_id ) == 1)){

                //     $errors[] = 'Candidate is Logged in Already, Contact Administrator
                //     ';

                // }


            }





        }

        if(empty($errors) === true && empty($_POST) === false){

            $_SESSION['userid']   = $db_user_id;
            $_SESSION['access_code'] = $db_ac;
            $_SESSION['name'] = $db_name;
            $_SESSION['user_type'] = $type;

            redirect(ROOT_URL.$location);






        }else {
            echo output_errors($errors);
        }



    }

}