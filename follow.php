<?php
require_once 'db.php';
include_once 'head_links.php';
if(!isset($_SESSION)) {
    session_start();
}
$user = $_SESSION['id'];
$id = $_GET['id'];
$sql_follow = "INSERT INTO follows (follow_from, follow_to) VALUES ('$user', '$id')";
if(mysqli_query($con, $sql_follow)){
    echo "<script>M.toast({html: 'Followed!'})</script>";
}
?>