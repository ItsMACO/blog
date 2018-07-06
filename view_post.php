<?php
session_start();
include_once 'db.php';

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
include 'sidebar.php';
?>
</div>
<div class="col s8">
<br><br><br><br>
    <?php
require_once 'nbbc/nbbc.php';
$bbcode = new BBCode;

$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$pid = substr($current_link, -6);

$sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $date = $row['date'];
        $content = $row['content'];
        $author = $row['author'];

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

        echo "<div><h2>$title</h2><h6>$date by <a href='profile.php?id=$userid'>$author</a></h6><p>$output</p></div>";
        echo "<div><form action='view_post.php?id=$pid' method='post'><button type='submit' name='like' class='button button1'>LIKE</button></form></div><br>";
        if (isset($_POST['like'])) {
            if (isset($_SESSION['id'])) {
                $user = $_SESSION['id'];
                $sql_like = "INSERT INTO likes (user, postid) VALUES ('$user', '$id')";

                $sql_likes = "SELECT * FROM likes";
                $result_likes = mysqli_query($con, $sql_likes) or die(mysqli_error($con));
                if (mysqli_num_rows($result_likes) > 0) {
                    while ($row = mysqli_fetch_assoc($result_likes)) {
                        $user_like = $row['user'];
                        $postid = $row['postid'];
                    }
                }

                mysqli_query($con, $sql_like);
                echo "<div class='left-align'><h5>Liked!</h5></div>";
            } else {
                echo "You have to log in to like posts.";
            }
        }
    }
} else {
    echo "<p>There are no posts to display!</p>";
}
?>
<div class="col s1"></div>
</div>
</div>
</div>
</body>
</html>