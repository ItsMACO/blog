<?php
include 'sidebar_new.php';
include_once 'db.php';
if (isset($_SESSION['id'])) {
    $uid = $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css?<?php echo time(); ?>">
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>">
    <script src="materialize/js/materialize.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="wrap">
        <div class="center-align">
    <?php

$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$rid = substr($current_link, -5);

require_once 'nbbc/nbbc.php';
$bbcode = new BBCode;

$sql_profile = "SELECT * FROM users WHERE id=$rid";
$result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));

if (mysqli_num_rows($result_profile) > 0) {
    while ($row = mysqli_fetch_assoc($result_profile)) {
        $userid = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
        $isAdmin = $row['admin'];
        $karma = $row['karma'];
    }
    echo "<div><h2>Profile of $username</h2></div><div class='divider'></div>";
    echo "<p>Current Karma - $karma</p>";
    if (isset($uid)) {
        if ($uid == $rid) {
            echo "<a href='edit_userdata.php?uid=$uid' name='edit_userdata' class='button button1'>EDIT USER DATA</a>";
        }
    }
}

$sql = "SELECT * FROM posts WHERE author='$username' ORDER BY id DESC";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$posts = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $date = $row['date'];
        $author = $row['author'];

        $posts .= "<div><h5><a href='view_post.php?pid=$id'>$title</a></h5></div>";
    }
    $result_number = mysqli_num_rows($result);
    if ($result_number == 0 || $result_number > 1) {
        echo "<div><h4>Author of $result_number posts<br>$posts</h4></div><br>";
    } else {
        echo "<div><h4>Author of $result_number post<br>$posts</h4></div><br>";
    }
}
?>
</div>
</div>
</div>
</body>
</html>