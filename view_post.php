<?php
session_start();
include_once('db.php');

$pid = $_GET['pid'];

    $sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";

    $result = mysqli_query($con, $sql) or die(mysqli_error());

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
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
<br><br><br><br>
    <?php
    require_once('nbbc/nbbc.php');
    $bbcode = new BBCode;

    $pid = $_GET['pid'];

    $sql_profile = "SELECT * FROM users ORDER BY id DESC";
    $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error());

    if (mysqli_num_rows($result_profile) > 0) {
        while ($row = mysqli_fetch_assoc($result_profile)) {
            $userid = $row['id'];
            $username = $row['username'];
            $email = $row['email'];
        }
    }

    $sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
    $result = mysqli_query($con, $sql) or die(mysqli_error());

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $title = $row['title'];
            $date = $row['date'];
            $content = $row['content'];
            $author = $row['author'];

            if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            $admin = "<div><a href='edit_post.php?pid=$id>Edit</a><a href='del_post.php?pid=$id>Delete</a></div>";
            } else {
                $admin = "";
            }
            $output = $bbcode->Parse($content);

            echo "<div><h2>$title</h2><h6>$date by <a href='profile.php?id=$userid'>$author</a></h6><p>$output</p></div>";
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