<?php
include 'db.php';
if(!isset($_SESSION)) {
session_start();
}
if(!isset($_SESSION['id'])) {
    header('Location: index.php');
}
if(isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
    $time = time();
    $sql = "UPDATE users SET msgtime='$time' WHERE id='$user'";
    $result = mysqli_query($con, $sql);
}
?>