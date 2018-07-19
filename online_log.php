<?php
if (!isset($_SESSION)) {
    session_start();
}
include 'db.php';
if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
    $time = time();
    $update = "UPDATE users SET lastonline=$time WHERE id='$user'";
    mysqli_query($con, $update);
}
