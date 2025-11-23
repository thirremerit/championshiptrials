<?php
session_start();
include 'db_connect.php';

// Only government workers can update
if(!isset($_SESSION['role']) || $_SESSION['role'] !== 'worker') {
    die("Not authorized.");
}

if(isset($_POST['issue_id'], $_POST['status'])) {
    $id = intval($_POST['issue_id']);
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE issues SET status=? WHERE id=?");
    $stmt->bind_param("si", $status, $id);
    $stmt->execute();
}

// Redirect back to issues page
header("Location: issues.php");
exit;
?>
