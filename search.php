<?php
include 'sidebar_new.php';
require_once 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css?<?php echo time(); ?>">
    <script src="materialize/js/materialize.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>"></link>
</head>
<body>
<div class="container-fluid">
    <div class="wrap">
<br><br>
<div class="center-align">
<form action="search.php" method="post">
<input type="text" name="searchtxt" class="text-input" size="48"><br><br>
      <button type="submit" class="button button1" name="searchbtn"><span>SEARCH</span></button>
</form><br><br>


    <?php
require_once 'nbbc.php';

$bbcode = new BBCode;

if (isset($_POST['searchtxt'])) {
    $searchtxt = $_POST['searchtxt'];
}

if (isset($_POST['searchbtn'])) {
    $sql = "SELECT * FROM posts WHERE (title LIKE '%$searchtxt%') OR (content LIKE '%$searchtxt%') ORDER BY id DESC";
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
            $flair = $row['flair'];

            $sql_profile = "SELECT * FROM users WHERE username='$author'";
            $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
            if (mysqli_num_rows($result_profile) > 0) {
                while ($row = mysqli_fetch_assoc($result_profile)) {
                    $userid = $row['id'];
                    $username = $row['username'];
                    $email = $row['email'];
                }
            }

            if (isset($_SESSION['id'])) {
            }
            $output = $bbcode->Parse($content);

            $posts .= "<div class='row'>
            <div class='col s1'></div>
            <div class='col s8'>
            <h2><a href='view_post.php?pid=$id'>$title</a></h2><h6 class='flair'>$flair</h6>
            <p>$date by <a href='profile.php?id=$userid'>$author</a></p>
            <h6>" . substr($output, 0, 140) . "...</h6><br>
            <a href='view_post.php?pid=$id' class='button button1'>READ MORE</a><br>
            </div>
            <div class='col s3'><br><br><img src='$image' height='200' width='200' class='right-align'></div><br>

            </div><br>";

        }

        if (mysqli_num_rows($result) > 1) {
            echo "Found " . mysqli_num_rows($result) . " results.</div>";
        }
        if (mysqli_num_rows($result) == 1) {
            echo "Found " . mysqli_num_rows($result) . " result.</div>";
        }

        echo $posts;

    } else {
        echo "<br><br>No posts found!";
    }
}

?>
</div>
</div>
</body>
</html>