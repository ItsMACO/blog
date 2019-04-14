<?php
require_once 'db.php';

$user_to = $_SESSION['message_from_id'];
$user_from = $_SESSION['id'];
$text = $_POST['reply_text'];
$time = time();

$sql_reply = "INSERT INTO messages (user_to, user_from, text, time) VALUES ('$user_to', '$user_from', '$text', '$time')";
$result_reply = mysqli_query($con, $sql_reply);
?>