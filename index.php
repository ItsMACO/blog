<?php
require_once 'db.php';
include 'online_log.php';
include 'sidebar.php';
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <script src="materialize/js/materialize.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col s3">
        <?php
?>
        </div>
        <div class="col s8">
            <br><br>
    <?php
require_once 'nbbc/nbbc.php';

$bbcode = new BBCode;

$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = mysqli_query($con, $sql) or die(mysqli_error());

$posts = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $date = $row['date'];
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

        $posts .= "<div class='row'>
            <div class='col s8'>
            <h2><a href='view_post.php?pid=$id'>$title</a></h2>
            <p>$date by <a href='profile.php?id=$userid'>$author</a></p>
            <h6>" . substr($output, 0, 360) . "...</h6><br>
            <a href='view_post.php?pid=$id' class='button button1'>READ MORE</a><br>
            </div>
            <div class='4'><br><br><img src='$image' height='200' width='200' class='right-align'></div><br>

            </div>
            <div class='divider'></div><br>";

    }

    echo $posts;

} else {
    echo "There are no posts to display!";
}

?>

</div>
<div class="col s1"></div>
<!--DIV ROW -->
</div>
<!--DIV CONTAINER FLUID -->
</div>
</body>
</html>