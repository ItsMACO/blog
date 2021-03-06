<?php
include 'sidebar_new.php';
require_once 'db.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search</title>
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<br><br>
<div class="wrap-content">
<div class='center-align'>
<form action="search.php" method="get">
<input type="text" name="searchtxt" class="text-input" size="48"><br><br>
      <button type="submit" class="button button1"><span>SEARCH</span></button>
</form>
</div>
<br><br>


    <?php
require_once 'nbbc.php';
$bbcode = new BBCode;

if (isset($_GET['searchtxt'])) {
    $searchtxt = $_GET['searchtxt'];
    $sql = "SELECT * FROM posts WHERE (title LIKE '%$searchtxt%') OR (content LIKE '%$searchtxt%') OR (tags LIKE '%$searchtxt%') ORDER BY id DESC";
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
            <div class='col s12 m8 l8'>
            <h3 class='break-long-words'><a href='view_post.php?pid=$id'>$title</a></h3><h6 class='flair'>$flair</h6>
            <p>$date by <a href='profile.php?id=$userid'>$author</a></p>
            <h6 class='break-long-words'>" . substr($output, 0, 140) . "...</h6><br>
            <a href='view_post.php?pid=$id' class='button button1'>READ MORE</a>
            <a href='?read_later=$id' class='button button2'>READ LATER</a>
            </div>
            <div class='col s12 m4 l4'><br><br><img src='$image' class='post-image'></div><br><br>
            </div><br>";
    }
    if(isset($_GET['read_later'])) {
        if(isset($_SESSION['id'])) {
            $read_postid = $_GET['read_later'];
            $read_later_exists = mysqli_query($con, "SELECT * FROM read_later WHERE (read_user='$user') AND (read_postid='$read_postid')");
            if(mysqli_num_rows($read_later_exists) > 0) {
                echo "You've already saved this post.";
            } else {
                $sql_read_later = "INSERT INTO read_later (read_user, read_postid) VALUES ('$user', '$read_postid')";
                mysqli_query($con, $sql_read_later);
            }
        } else {
            header('Location: login.php');
        }
    }
        }

        if (mysqli_num_rows($result) > 1 || mysqli_num_rows($result) == 0) {
            echo "<div class='center-align'>Found " . mysqli_num_rows($result) . " results.</div>";
        }
        if (mysqli_num_rows($result) == 1) {
            echo "<div class='center-align'>Found " . mysqli_num_rows($result) . " result.</div>";
        }

        echo $posts;

    }

?>
</div>
</div>
</body>
</html>