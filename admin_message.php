<?php
if(!isset($_SESSION)) {
session_start();
}
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');
}
require_once 'db.php';
include_once 'sidebar_new.php';
$user = $_SESSION['id'];

if(isset($_POST['send'])) {
    $username = strip_tags($_POST['username']);
    $username = mysqli_real_escape_string($con, $username);
    $text = strip_tags($_POST['text']);
    $text = mysqli_real_escape_string($con, $text);
    $time = time();

    $userid = mysqli_query($con, "SELECT id FROM users WHERE username='$username'");
    if(mysqli_num_rows($userid) > 0) {
        $row = mysqli_fetch_assoc($userid);
        $user_to = $row['id'];
        
        $sql_message = "INSERT INTO admin_msg (user_to, admin_from, text, time) VALUES ('$user_to', '$user', '$text', '$time')";
        mysqli_query($con, $sql_message);
        header('Location: index.php');
    } else {
        echo "<script>M.toast({html: 'User not found!'})</script>";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Admin Message</title>
</head>
<body>
    <div class='container-fluid'>
    <div class='wrap'>
    <div class='wrap-content'>
    <br><br>
        <form action='admin_message.php' method='post' enctype='multipart/form-data'>
        <input type='text' name='username' placeholder='Send to...' class='text-input'><br><br>
        <textarea name='text' placeholder='Text' class='text-input'></textarea><br><br>
        <button type='submit' name='send' class='button button1'>SEND</button>
        </form>
    </div>
    </div>
    </div>
</body>
</html>