<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Delete Post</title>
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
