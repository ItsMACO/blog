<?php
$con = mysqli_connect("localhost", "root", "", "blog");

// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
if(!isset($_SESSION)) {
    session_start();
}
?>
