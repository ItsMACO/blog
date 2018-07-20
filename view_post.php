<?php
session_start();
require_once 'db.php';
require 'sidebar_new.php';

if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
} 

$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pid = substr($current_link, -6);

$sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";

$result = mysqli_query($con, $sql) or die(mysqli_error($con));

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pagetitle = $row['title'];
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?php echo $pagetitle; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css?<?php echo time(); ?>">
    <script src="materialize/js/materialize.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>">
</head>
<body>
<div class="container-fluid">
    <div class="wrap">
        <div class="wrap-content">
<br><br>
<?php
require_once 'nbbc/nbbc.php';
$bbcode = new BBCode;

$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pid = substr($current_link, -6);

$sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$post = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $date = $row['date'];
        $content = $row['content'];
        $author = $row['author'];
        $image = $row['image'];

        $sql_profile = "SELECT * FROM users WHERE username='$author'";
        $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
        if (mysqli_num_rows($result_profile) > 0) {
            while ($row = mysqli_fetch_assoc($result_profile)) {
                $userid = $row['id'];
                $username = $row['username'];
                $email = $row['email'];
            }
        }
        $output = $bbcode->Parse($content);

        $post .= "<div class='row'>
            <div class='col s8'>
            <h2>$title</h2>
            <p>$date by <a href='profile.php?id=$userid'>$author</a></p>
            <h6>$output...</h6><br>
            </div>
            <div class='col s4'><br><br><img src='$image' height='200' width='200' class='right-align'></div><br>
            </div><br>";

        echo $post;
        echo "<div><form action='view_post.php?id=$pid' method='post'><button type='submit' name='like' class='button button1'>LIKE</button></form></div><br><br>";
        
        if (isset($_POST['like'])) {
            if (isset($_SESSION['id'])) {
                $user = $_SESSION['id'];
                $sql_like = "INSERT INTO likes (user, postid) VALUES ('$user', '$id')";
                $result_like = mysqli_query($con, "SELECT * FROM likes WHERE (user='$user') AND (postid='$pid')");
                if (mysqli_num_rows($result_like) > 0) {
                    echo "<div class='left-align'>You've already liked this post.</div>"; 
                } else {
                    mysqli_query($con, $sql_like);
                    echo "<div class='left-align'><h5>Liked!</h5></div>";
                }
            } else {
                echo "You have to log in to like posts.<br>";
            }
        }

        if (isset($_POST['comment-submit'])) {
            if(isset($_SESSION['id'])) {
                $user = $_SESSION['id'];
                $user_name = $_SESSION['username'];
                $time = time();
                $comment_content = $_POST['comment-content'];
                $sql_comment = "INSERT INTO comments (user_username, postid, time, comment_content) VALUES ('$user_name', '$id', '$time', '$comment_content')";
                mysqli_query($con, $sql_comment);
                echo "<div class='left-align'><h5>Comment submitted!</h5></div>";
            } else {
                echo "You have to log in to comment on posts.";
            }
        }
        echo "<form action='view_post?pid=$pid' method='post' enctype='multipart/form-data'>";
        echo "<textarea name='comment-content' class='text-input' placeholder='Comment'></textarea><br><br>";
        echo "<button type='submit' name='comment-submit' class='button button1'>SEND</button><br><br>";
        echo "</form>";
    }
} else {
    echo "<p>There are no posts to display!</p>";
}



$sql_comments = "SELECT * FROM comments WHERE postid='$pid' ORDER BY time DESC";
$result_comments = mysqli_query($con, $sql_comments) or die(mysqli_error($con));

$comments = "";

if (mysqli_num_rows($result_comments) > 0) {

    $result_comments_number = mysqli_num_rows($result_comments);
    echo "<h5>".$result_comments_number." comments</h5><div class='divider'></div><br>";

    while ($row = mysqli_fetch_assoc($result_comments)) {
        $comment_id = $row['comment_id'];
        $comment_user_username = $row['user_username'];
        $comment_postid = $row['postid'];
        $comment_time = $row['time'];
        $comment_content = $row['comment_content'];

        $sql_comment_profile = "SELECT * FROM users WHERE username='$comment_user_username'";
        $result_comment_profile = mysqli_query($con, $sql_comment_profile) or die(mysqli_error($con));
        if (mysqli_num_rows($result_comment_profile) > 0) {
            while ($row = mysqli_fetch_assoc($result_comment_profile)) {
                $userid = $row['id'];
                $username = $row['username'];
                $email = $row['email'];
            }
        }
                //converts unix time to normal datetime
                $unix_converted = date('d-m-Y H:i:s', $comment_time);
                //breaks the comment after 90 characters
                $comments = "<div class='box box1'>
                <h6 style='margin: 25px;' class='break-long-words'>
                <a href='profile.php?id=$userid'>$comment_user_username</a>
                <br>$unix_converted UTC<br>$comment_content</h6></div><br><br>";
                echo $comments;
    }
} else {
    echo "<div class='left-align'>There are no comments to display!</div><br>";
}
?>
</div>
</div>
</div>
</body>
</html>