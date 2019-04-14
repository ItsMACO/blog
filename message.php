<?php
if(!isset($_SESSION)) {
session_start();
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
        
        $sql_message = "INSERT INTO messages (user_to, user_from, text, time) VALUES ('$user_to', '$user', '$text', '$time')";

        if (mysqli_query($con, $sql_message)) {
            $link = mysqli_insert_id($con);
        } else {
            echo "Error: " . $sql_message . "<br>" . mysqli_error($con);
        }

        $sql_message_notification = "INSERT INTO notifications (user_to, type, link, time) VALUES ('$user_to', 'messages', '$link', '$time')";
        header('Location: index.php');
    } else {
        echo "<script>M.toast({html: 'User not found!'})</script>";
    }

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Message</title>
</head>
<body>
    <div class='container-fluid'>
    <div class='wrap'>
    <div class='wrap-content'>
    <br><br>
        <form action='message.php' method='post' enctype='multipart/form-data'>
        <input type='text' name='username' placeholder='Send to...' class='text-input' required><br><br>
        <textarea name='text' placeholder='Text' class='text-input' required></textarea><br><br>
        <button type='submit' name='send' class='button button1'>SEND</button>
        </form>
    </div>
    </div>
    </div>
</body>
</html>