<?php
require 'online_log.php';
require_once 'db.php';
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
<body>
<?php
if(isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
?>
    <div class="sidenav-fixed">
        <a href="index.php" class="sidenav-link right-align">Home <i class="material-icons">home</i></a>
        <a href="post.php" class="sidenav-link right-align">New Post <i class="material-icons">add</i></a>
        <a href="notifications.php?id=<?php echo $user; ?>" class="sidenav-link right-align">Notifications 
        
        <?php
        $user = $_SESSION['id'];
        $sql_notify = "SELECT notifytime FROM users WHERE id='$user'";
        $result_notify = mysqli_query($con, $sql_notify);
        $row = mysqli_fetch_assoc($result_notify);
        $notifytime = $row['notifytime'];

        $sql_comments = "SELECT * FROM comments WHERE (comment_to='$user') AND (time>$notifytime) AND NOT (comment_from='$user')";
        $result_comments = mysqli_query($con, $sql_comments);

        if(mysqli_num_rows($result_comments) > 0) {
        ?>
        <i class="orange-custom material-icons">notifications_active</i></a>
        <?php
        } else {
        ?>
        <i class="material-icons">notifications</i></a>
        <?php
        }
        ?>
        
        <a href="search.php" class="sidenav-link right-align">Search <i class="material-icons">search</i></a>
        <a href="profile.php?id=<?php echo $user; ?>" class="sidenav-link right-align">Profile <i class="material-icons">account_box</i></a>
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
        <a href="notifications.php?id=<?php echo $user; ?>" class="sidenav-link right-align"><i class="material-icons">notifications</i></a>
        <a href="search.php" class="sidenav-link right-align"><i class="material-icons">search</i></a>
        <a href="profile.php?id=<?php echo $user; ?>" class="sidenav-link right-align"><i class="material-icons">account_box</i></a>
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
    <a href="login.php" class="sidenav-link right-align">Login <i class="material-icons">arrow_forward</i></a>
    <a href="register.php" class="sidenav-link right-align">Register <i class="material-icons">person_add</i></a>
    <a href="index.php" class="sidenav-link right-align">Home <i class="material-icons">home</i></a>
    <a href="search.php" class="sidenav-link right-align">Search <i class="material-icons">search</i></a>
    <a href="bug_report.php" class="sidenav-link right-align">Report A Bug <i class="material-icons">bug_report</i></a>
    <a href="feature_request.php" class="sidenav-link right-align">Request A Feature <i class="material-icons">playlist_add</i></a>
</div>
<div class="sidenav-fixed-small">
    <a href="login.php" class="sidenav-link right-align"><i class="material-icons">arrow_forward</i></a>
    <a href="register.php" class="sidenav-link right-align"><i class="material-icons">person_add</i></a>
    <a href="index.php" class="sidenav-link right-align"><i class="material-icons">home</i></a>
    <a href="search.php" class="sidenav-link right-align"><i class="material-icons">search</i></a>
    <a href="bug_report.php" class="sidenav-link right-align"><i class="material-icons">bug_report</i></a>
    <a href="feature_request.php" class="sidenav-link right-align"><i class="material-icons">playlist_add</i></a>
</div>
<?php } ?>
</body>
</html>