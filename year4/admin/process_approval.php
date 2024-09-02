<?php
include '../database.php';

if (isset($_POST['approve'])) {
    $request_id = $_POST['request_id'];
    $update_query = "UPDATE login_requests SET status = 'Approved' WHERE id = ?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("i", $request_id);
    $update_stmt->execute();
    header("Location: login_requests.php");
}

if (isset($_POST['reject'])) {
    $request_id = $_POST['request_id'];
    $update_query = "UPDATE login_requests SET status = 'Rejected' WHERE id = ?";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->bind_param("i", $request_id);
    $update_stmt->execute();
    header("Location: login_requests.php");
}

if (isset($_POST['approve_all'])) {
    $update_query = "UPDATE login_requests SET status = 'Approved' WHERE status = 'Pending'";
    $update_stmt = $connection->prepare($update_query);
    $update_stmt->execute();

    // Set success message
    $_SESSION['message'] = "All login requests have been successfully approved.";
    header("Location: login_requests.php");
    exit();
}
?>
