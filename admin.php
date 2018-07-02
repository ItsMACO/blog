<?php
session_start();
include_once('db.php');

if(!isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('Location: login.php');

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
    <link rel="stylesheet" href="main.css">

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

    $sql = "SELECT * FROM posts ORDER BY id DESC";
    $result = mysqli_query($con, $sql) or die(mysqli_error());

    $posts = "";

    if(mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $title = $row['title'];
            $date = $row['date'];
            $author = $row['author'];
            
            if(isset($_SESSION['id'])) {
            $admin = "<div><a href='edit_post.php?pid=$id' class='btn waves-effect waves-light yellow darken-2'>Edit</a>&nbsp;<a href='del_post.php?pid=$id' class='btn waves-effect waves-light red darken-2'>Delete</a></div>";
            }

            $posts .="<div><h2><a href='view_post.php?pid=$id' target='_blank'>$title</a></h2><p>$date by $author</p><br>$admin</div><br><div class='divider'></div>";
        }

        echo $posts;
        
    } else {
        echo "There are no posts to display!";
    }

    ?>
</div>
<div class="col s1">
</div>
<!--DIV ROW -->
</div>
<!--DIV CONTAINER FLUID -->
</div>
</body>
</html>