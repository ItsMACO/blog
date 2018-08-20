<?php
include 'sidebar_new.php';
include_once 'db.php';
if(!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
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

$id = $_GET['id'];

require_once 'nbbc.php';
$bbcode = new BBCode;

$sql_profile = "SELECT * FROM users WHERE id=$id";
$result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));

if (mysqli_num_rows($result_profile) > 0) {
    while ($row = mysqli_fetch_assoc($result_profile)) {
        $userid = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
        $isAdmin = $row['admin'];
        $profile_bio = $row['profile_bio'];
        $karma = $row['karma'];
        $profile_pic = $row['profile_pic'];
    }
    if($isAdmin == 1) {
        echo "<div><h2>$username<i class='material-icons tooltipped' data-position='bottom' data-tooltip='Admin'>verified_user</i></h2></div>";
    } else {
        echo "<div><h2>$username</h2></div>";
    }
    if (isset($user)) {
        if ($user == $id) {
            echo "<br><a href='edit_userdata.php?uid=$id' name='edit_userdata' class='button button1'>EDIT USER DATA</a><br><br>";
        }
    }
    echo "<div class='divider'></div>";
    echo "<h5>Current Karma - $karma</h5>";
}
?>

<div class="row">
<div class="col s12 m6 l6">
<ul class="collapsible expandable">
<li class="active">
<div class="collapsible-header"><i class="medium material-icons">art_track</i>Profile bio</div>
<div class="collapsible-body">
<span>
    <?php
    $sql_profile = "SELECT * FROM users WHERE id=$id";
    $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
    
    $row = mysqli_fetch_assoc($result_profile);
    $profile_bio = $row['profile_bio'];
    if(!empty($profile_bio)) {
        echo "<p class='break-long-words'>\"".$profile_bio."\"</p>";
    } else {
        echo "It's quiet here...";
    }
    ?>
</span>
</div>
</li>
<?php
if($user == $id) {
?>
<li>
<div class="collapsible-header"><i class="medium material-icons">book</i>Saved posts</div>
<div class="collapsible-body">
<span>
    <?php
    $sql_read_later = "SELECT * FROM read_later WHERE read_user='$user' ORDER BY read_id DESC";
    $result_read_later = mysqli_query($con, $sql_read_later) or die(mysqli_error($con));
    
    if(mysqli_num_rows($result_read_later) > 0) {
        while($row = mysqli_fetch_assoc($result_read_later)) {
            $read_later_postid = $row['read_postid'];

            $sql_read_later_title = "SELECT * FROM posts WHERE id='$read_later_postid'";
            $result_read_later_title = mysqli_query($con, $sql_read_later_title);
            
            if(mysqli_num_rows($result_read_later_title) > 0) {
                while($row = mysqli_fetch_assoc($result_read_later_title)) {
                    $read_later_title = $row['title'];

                    $read_later_posts = "<div><h6><a href='view_post.php?pid=$read_later_postid'>$read_later_title</a></h6></div>";
                    echo $read_later_posts;
                }
            } 
        }
    } else {
        echo "No saved posts";
    }
    ?>
</span>
</div>
</li>
<?php } ?>
</ul>
</div>
<div class="col s12 m6 l6">
<?php
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

        $posts .= "<div><h6><a href='view_post.php?pid=$id'>$title</a></h6></div>";
    }
    $result_number = mysqli_num_rows($result);
    if ($result_number == 0 || $result_number > 1) {
        echo "<div><h5 class='break-long-words'>Author of $result_number posts<br>$posts</h5></div><br>";
    } else {
        echo "<div><h5class='break-long-words'>Author of $result_number post<br>$posts</h5></div><br>";
    }
}
?>
</div>
</div>
</div>
</div>
</div>
<script>
var elem = document.querySelector('.collapsible.expandable');
var instance = M.Collapsible.init(elem, {
  accordion: false
});

var elem = document.querySelector('.tooltipped');
var instance = M.Tooltip.init(elem, {
  accordion: false
});
</script>
</body>
</html>