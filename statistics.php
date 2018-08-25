<?php
include_once 'db.php';
include 'head_links.html';

if(!isset($_SESSION)) {
    session_start();
}

$pid = $_GET['pid'];
$sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));
$row = mysqli_fetch_assoc($result);
$author = $row['author'];

if($_SESSION['username'] != $author && $_SESSION['admin'] == 0) {
    header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body style="background: white !important;">
    
</body>
</html>

<?php
$sql_seen_times = "SELECT * FROM seen WHERE postid=$pid";
$result_seen_times = mysqli_query($con, $sql_seen_times);

if(mysqli_num_rows($result_seen_times) > 0) {
    echo "<p><i class='material-icons'>remove_red_eye</i>&nbsp;Seen ".mysqli_num_rows($result_seen_times)." times.</p>";
} else {
    echo "<p><i class='material-icons'>remove_red_eye</i>&nbsp;No one has seen your post yet!</p>";
}

$sql_liked_times = "SELECT * FROM likes WHERE postid=$pid";
$result_liked_times = mysqli_query($con, $sql_liked_times);

if(mysqli_num_rows($result_liked_times) > 0) {
    echo "<p><i class='material-icons'>thumb_up</i>&nbsp;Liked ".mysqli_num_rows($result_liked_times)." times.</p>";
} else {
    echo "<p><i class='material-icons'>thumb_up</i>&nbsp;No one has liked your post yet!</p>";
}

$sql_commented_times = "SELECT * FROM comments WHERE postid=$pid";
$result_commented_times = mysqli_query($con, $sql_commented_times);

if(mysqli_num_rows($result_commented_times) > 0) {
    echo "<p><i class='material-icons'>comment</i>&nbsp;Commented ".mysqli_num_rows($result_commented_times)." times.</p>";
} else {
    echo "<p><i class='material-icons'>comment</i>&nbsp;No one has commented your post yet!</p>";
}
?>