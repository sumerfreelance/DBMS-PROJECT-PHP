<?php
session_start();
include('db.php');

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'admin') {
    header('Location: admin_login.php');
    exit;
}

if (isset($_GET['id'])) {
    $sql = "UPDATE complaints SET status = 'deleted' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $_GET['id']);
    $stmt->execute();

    header('Location: admin_dashboard.php');
    exit;
}
?>