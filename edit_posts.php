<?php
require_once 'db.php';
if(!isset($_SESSION)) {
	session_start();
}
if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header('Location: login.php');
}
    $sql = "SELECT * FROM posts ORDER BY id DESC";
    $result = mysqli_query($con, $sql) or die(mysqli_error($con));

    $posts = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $title = $row['title'];
            $date = $row['date'];
            $author = $row['author'];
            $flair = $row['flair'];

            $sql_profile = "SELECT * FROM users WHERE username='$author'";
            $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
            if (mysqli_num_rows($result_profile) > 0) {
                $row = mysqli_fetch_assoc($result_profile);
                $userid = $row['id'];
            }

            $posts .= "<div style='display: inline-block;'>
            <h4><a href='view_post.php?pid=$id' target='_blank' class='break-long-words'>$title</a></h4>
            <span class='flair'>$flair</span> by 
            <a href='profile.php?id=$userid'>$author</a><br><br>
            <div><a href='edit_post.php?pid=$id' class='button-small button2'>EDIT</a>&nbsp;
            <a href='del_post.php?pid=$id' class='button-small button3'>DELETE</a></div>
            </div><br><br><div class='divider'></div>";
        }

        echo $posts;

    } else {
        echo "There are no posts to display!";
    }
?>