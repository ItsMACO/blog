<?php
include 'db.php';

function checkNoBan() {
    $user_name = $_SESSION['username'];
    $con = mysqli_connect("localhost", "root", "", "blog");
    $sql = "SELECT * FROM bans WHERE ban_to='$user_name'";
    $result = mysqli_query($con, $sql);
    if(mysqli_num_rows($result) > 0) {
        return false;
    } else {
        return true;
    }
}
?>