<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $role = $_POST['role'];

    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $email;
    $_SESSION['role'] = $role;

    echo "Login successful";
} else {
    echo "Invalid request method.";
}
?>