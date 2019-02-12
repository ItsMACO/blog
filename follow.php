<?php
require_once 'db.php';
include_once 'head_links.html';
if(!isset($_SESSION)) {
    session_start();
}
$user = $_SESSION['id'];
$id = $_GET['id'];
mysqli_query($con, "INSERT INTO follows (follow_from, follow_to) VALUES ('$user', '$id')");
?>