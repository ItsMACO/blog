<?php
session_start();
include_once('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>View Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
<div class="row">
<div class="col s1">
<br><br><a href="index.php" class="waves-effect waves-light btn blue darken-2"><i class="material-icons left">arrow_back</i>Back</a>
</div>
<div class="col s9">
    <?php
    if(isset($_SESSION['username'])) {
        require_once('nbbc/nbbc.php');
        $bbcode = new BBCode;

        $user = $_SESSION['id'];
        $sql = "SELECT * FROM users WHERE id=$user LIMIT 1";

        $result = mysqli_query($con, $sql) or die(mysqli_error($con));

        if(mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $username = $row['username'];
            $isadmin = $row['admin'];
            }
            echo "<div><h2>$username</h2><h6>$isadmin</h6></div>";
        }
    } else {
        header('Location: login.php');
    }
    ?>
<div class="col s2"></div>
</div>
</div>
</div>
</body>
</html>