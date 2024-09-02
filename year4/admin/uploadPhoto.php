<?php
include "includes/header.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_photo'])) {
    $student_id = $_POST['student_id'];
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["profile_photo"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_photo"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["profile_photo"]["size"] > 500000) { // 500KB limit
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["profile_photo"]["tmp_name"], $target_file)) {
            // Save the file path in the database
            $query = "UPDATE students SET profile_photo = '$target_file' WHERE id = '$student_id'";
            if (mysqli_query($connection, $query)) {
                echo "The file ". htmlspecialchars( basename( $_FILES["profile_photo"]["name"])). " has been uploaded.";
                  // Redirect to students.php with a success parameter
                header("Location: students.php?upload=success");
                exit();
            } else {
                echo "Sorry, there was an error updating your profile photo.";
                header("Location: students.php?upload=failed");
                exit();
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
            header("Location: students.php?upload=error");
            exit();
        }
    }
}
?>
