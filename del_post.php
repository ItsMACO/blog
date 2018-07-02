<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Page Title</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <script src="materialize/js/materialize.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body style="background: white !important">
<div class="container-fluid">
<div class="row">
<div class="col s3">
</div>
<div class="col s6">
    <?php
    include_once('db.php');

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
        return;
    }

    if(!isset($_GET['pid'])) {
        header('Location: admin.php');
    } else {?>
    <br><br><br><br>
        <form action="" method="post">
        <h3>Do you really want to delete this post?</h3>
        <div class="button login">
        <button type="submit" name="delete"><span>DELETE</span></button>
        </div>
        </form>
        <?php
        if (isset($_POST['delete'])) {
            $pid = $_GET['pid'];
            $sql = "DELETE FROM posts WHERE id=$pid";
            mysqli_query($con, $sql);
            header('Location: admin.php');
    
        }
    }


    ?>
</div>
<div class="col s3"></div>
</div>
</body>
</html>
