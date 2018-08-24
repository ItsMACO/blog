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
        <br><br>
            <?php
            $time = time() - 4*60;
            $sql_online = "SELECT * FROM users WHERE NOT id=$user";
            $result_online = mysqli_query($con, $sql_online);
            if(mysqli_num_rows($result_online) > 0) {
                while($row = mysqli_fetch_assoc($result_online)) {
                    $online_id = $row['id'];
                    $online_username = $row['username'];
                    $last_online = $row['lastonline'];

                    if($last_online > $time) {
                    $online = "<div class='online-users'>
                    <h6 class='center-align'>$online_username&nbsp;<i class='tiny material-icons green-text'>lens</i></h6>
                    </div>";
                    echo $online;
                    } else {
                    $online = "<div class='online-users'>
                    <h6 class='center-align'>$online_username&nbsp;<i class='tiny material-icons red-text'>lens</i></h6>
                    </div>";
                    echo $online;
                    }

                }
            }
            ?>
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