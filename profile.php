<?php
session_start();
include_once('db.php');
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
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <script src="materialize/js/materialize.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
<div class="row">
<div class="col s3">
<?php
include('sidebar.php');
?>
</div>
<div class="col s8">
    <?php

    $current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";    
    $rid = substr($current_link, -5);

    require_once('nbbc/nbbc.php');
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
        echo "<div><h2>Profile of $username</h2></div>";
        //echo "<p>Current Karma - $karma</p>";
    if ($uid == $rid) {
    echo "<a href='edit_userdata.php?uid=$uid' name='edit_userdata'>EDIT USER DATA</a>";
    }
    } else {
        echo "User not found";
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
        
        $posts .="<div><h5><a href='view_post.php?pid=$id' class='blue-text darken-2'>$title</a></h5><br></div>";
        }
        echo "<div><h3>Author of:<br>$posts</h3></div><br>";
    }
    ?>

<div class="col s1"></div>
</div>
</div>
</div>
</body>
</html>