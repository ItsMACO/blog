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
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css" />
    <script src="main.js"></script>
</head>
<body style="background: white !important">
<div class="container-fluid">
<div class="row">
<div class="col s3">
</div>
<div class="col s8">
    <?php
include_once 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    return;
}

if (!isset($_GET['pid'])) {
    header('Location: admin.php');
} else {?>
    <br><br><br><br>
        <form action="" method="post">
        <h3>Do you really want to delete this post?</h3><br>
        <button type="submit" name="delete" class="button button3" style="position: absolute; top: 30%; left: 49%;">DELETE</button>
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
<div class="col s1"></div>
</div>
</body>
</html>
