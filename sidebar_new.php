<?php
require 'online_log.php';
require_once 'db.php';
include 'navbar.php';
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css?<?php echo time();?>" />
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body style="background: white !important;">
<?php
if(isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
?>
    <div class="sidenav-fixed">
        <a href="index.php" class="sidenav-link right-align">Home <i class="material-icons">home</i></a>
        <a href="post.php" class="sidenav-link right-align">New Post <i class="material-icons">add</i></a>
        <a href="search.php" class="sidenav-link right-align">Search <i class="material-icons">search</i></a>
        <?php
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            echo "<a href='admin.php' class='sidenav-link right-align'>Admin <i class='material-icons'>adb</i></a>";
        }
        ?>
        <a href="bug_report.php" class="sidenav-link right-align">Report A Bug <i class="material-icons">bug_report</i></a>
        <a href="feature_request.php" class="sidenav-link right-align">Request A Feature <i class="material-icons">playlist_add</i></a>
        <a href="logout.php" class="sidenav-link right-align">Logout <i class="material-icons">cancel</i></a>
    </div>
    <div class="sidenav-fixed-small">
        <a href="index.php" class="sidenav-link right-align"><i class="material-icons">home</i></a>
        <a href="post.php" class="sidenav-link right-align"><i class="material-icons">add</i></a>
        <a href="search.php" class="sidenav-link right-align"><i class="material-icons">search</i></a>
        <?php
        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
            echo "<a href='admin.php' class='sidenav-link right-align'><i class='material-icons'>adb</i></a>";
        }
        ?>
        <a href="bug_report.php" class="sidenav-link right-align"><i class="material-icons">bug_report</i></a>
        <a href="feature_request.php" class="sidenav-link right-align"><i class="material-icons">playlist_add</i></a>
        <a href="logout.php" class="sidenav-link right-align"><i class="material-icons">cancel</i></a>
    </div>
<?php
} else { ?>
    <div class="sidenav-fixed">
    <a href="index.php" class="sidenav-link right-align">Home <i class="material-icons">home</i></a>
    <a href="search.php" class="sidenav-link right-align">Search <i class="material-icons">search</i></a>
    <a href="bug_report.php" class="sidenav-link right-align">Report A Bug <i class="material-icons">bug_report</i></a>
    <a href="feature_request.php" class="sidenav-link right-align">Request A Feature <i class="material-icons">playlist_add</i></a>
</div>
<div class="sidenav-fixed-small">
    <a href="index.php" class="sidenav-link right-align"><i class="material-icons">home</i></a>
    <a href="search.php" class="sidenav-link right-align"><i class="material-icons">search</i></a>
    <a href="bug_report.php" class="sidenav-link right-align"><i class="material-icons">bug_report</i></a>
    <a href="feature_request.php" class="sidenav-link right-align"><i class="material-icons">playlist_add</i></a>
</div>
<?php } ?>
</body>
</html>