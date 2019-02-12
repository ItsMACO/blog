<?php
include_once 'db.php';

$pid = $_GET['pid'];
$sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
$row = mysqli_fetch_assoc($result);
$author = $row['author'];
$sql_profile = "SELECT * FROM users WHERE username='$author'";
$result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
$row = mysqli_fetch_assoc($result_profile);
$userid = $row['id'];

if(!isset($_SESSION['id'])) {
    $postid = $_GET['pid'];
    $sql_seen = "INSERT INTO seen (userid, postid) VALUES ('0', '$postid')";
    mysqli_query($con, $sql_seen);
} elseif(!isset($_GET['pid'])) {
} elseif($_SESSION['id'] == $userid) {
} else {
    $user = $_SESSION['id'];
    $postid = $_GET['pid'];
    $sql_seen = "INSERT INTO seen (userid, postid) VALUES ('$user', '$postid')";
    mysqli_query($con, $sql_seen);
}
?>