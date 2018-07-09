<?php
require 'online_log.php';
require_once 'db.php';
if (!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['id'])) {
$user = $_SESSION['id'];
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="materialize/css/materialize.css">
    <link rel="stylesheet" href="styles.css">
    <script src="materialize/js/materialize.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<?php
$sql_profile = "SELECT * FROM users ORDER BY id DESC";
$result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error());

if (mysqli_num_rows($result_profile) > 0) {
    while ($row = mysqli_fetch_assoc($result_profile)) {
        $userid = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
    }
}
$d = time() - 4 * 60;
$sql_online = "SELECT username FROM users WHERE lastonline>$d";
$result_online = mysqli_query($con, $sql_online) or die(mysqli_error($con));
?>
<ul id="slide-out" class="sidenav sidenav-fixed">
    <li><div class="user-view">
<?php
if(isset($_SESSION['id'])) {
$sql_profile_pic = "SELECT profile_pic FROM users WHERE id='$user'";
$result_profile_pic = mysqli_query($con, $sql_profile_pic);
while ($row = mysqli_fetch_assoc($result_profile_pic)) {
    $profile_bg = $row['profile_pic'];
    echo "<div class='background'>";
    echo "<img src='".$profile_bg."' width='100%' height='200%'>";
    echo "</div>";
}
}
?>
      <span class="white-text name">
<?php
if (isset($_SESSION['id'])) {
    echo "Welcome " . $_SESSION['username'] . "!";
}
?>
      </span>
      <span class="white-text email"></span>
    </div></li>
    <?php
if (isset($_SESSION['id'])) {
    $uid = $_SESSION['id'];
    //echo "<li><a href='notifications.php?id=$uid'><i class='small material-icons'>notifications</i>Notifications</a></li>";
    //echo "<div class='divider'></div>";
    echo "<li><a href='index.php'><i class='small material-icons'>home</i>Home</a></li>";
    echo "<li class='blue darken-2'><a href='post.php' class='white-text'><i class='small material-icons'>add</i>New Post</a></li>";
    echo "<li><a href='search.php'><i class='small material-icons'>search</i>Search</a></li>";
    echo "<li><a href='profile?id=$user'><i class='small material-icons'>account_box</i>Profile</a></li>";
    echo "<li><a href='admin.php'><i class='small material-icons'>adb</i>Admin</a></li>";
    echo "<li><a href='bug_report.php'><i class='small material-icons'>bug_report</i>Report A Bug</a></li>";
    echo "<li><a href='feature_request.php'><i class='small material-icons'>playlist_add</i>Request A Feature</a></li>";
    echo "<li class='red darken-2'><a href='logout.php' class='white-text'><i class='small material-icons'>cancel</i>Logout</a></li>";
    echo "<p class='center-align grey-text'>Blog created by Matej Palo</p><br>";
    echo "<div class='center-align'><b>Online users:</b></div>";
    if (mysqli_num_rows($result_online) > 0) {
        while ($row = mysqli_fetch_assoc($result_online)) {
            $username = $row['username'];

            $sql_profile = "SELECT * FROM users WHERE username='$username'";
            $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
            if (mysqli_num_rows($result_profile) > 0) {
                while ($row = mysqli_fetch_assoc($result_profile)) {
                    $userid = $row['id'];
                    echo "<div class='center-align'><a href='profile.php?id=$userid'>".$username."</a></div>";
                }
            }
        }
    }
    ?>

        <?php
} else {
    echo "<li><a href='index.php'><i class='small material-icons'>home</i>Home</a></li>";
    echo "<li><a href='search.php'><i class='small material-icons'>search</i>Search</a></li>";
    echo "<li><a href='login.php'><i class='small material-icons'>arrow_forward</i>Login</a></li>";
    echo "<li><a href='register.php'><i class='small material-icons'>add_circle_outline</i>Register</a></li>";
    echo "<li><a href='bug_report.php'><i class='small material-icons'>bug_report</i>Report A Bug</a></li>";
    echo "<li><a href='feature_request.php'><i class='small material-icons'>playlist_add</i>Request A Feature</a></li>";
}
?>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
</body>
</html>