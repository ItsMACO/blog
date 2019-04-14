<?php
include_once 'db.php';
if(isset($_GET['location'])) {
    $location = htmlspecialchars($_GET['location']);
}
if(isset($_COOKIE['username']) && isset($_COOKIE['id']) && isset($_COOKIE['admin'])) {
    $username = strip_tags($_COOKIE['username']);
    $username = stripslashes($username);
    $username = mysqli_real_escape_string($con, $username);

    $_SESSION['username'] = $username;
    setcookie("username", $username, time()+86400, "/","", 0);
    $_SESSION['id'] = $_COOKIE['id'];
    setcookie("id", $_COOKIE['id'], time()+86400, "/","", 0);
    if ($_COOKIE['admin'] == 1) {
        $_SESSION['admin'] = 1;
        setcookie("admin", 1, time()+86400, "/", "",  0);
    }
    header('Location:'.$location);
} else {
    $username = strip_tags($_POST['username']);
    $username = stripslashes($username);
    $username = mysqli_real_escape_string($con, $username);
    if(isset($_POST['password'])) {
        $password = strip_tags($_POST['password']);
        $password = stripslashes($password);
        $password = mysqli_real_escape_string($con, $password);
    }

    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    $id = $row['id'];
    $db_password = $row['password'];
    $admin = $row['admin'];

    if (isset($_POST['login'])) {
        if (password_verify($password, $db_password)) {
            $_SESSION['username'] = $username;
            setcookie("username", $username, time()+86400, "/","", 0);
            $_SESSION['id'] = $id;
            setcookie("id", $id, time()+86400, "/","", 0);
            if ($admin == 1) {
                $_SESSION['admin'] = 1;
                setcookie("admin", 1, time()+86400, "/", "",  0);
            }
            /*
            
            $sql_ban = "SELECT * FROM user_bans WHERE userid='$id' LIMIT 1";
            $result_ban = mysqli_query($con, $sql_ban);
            $row = mysqli_fetch_assoc($result_ban);
            $banned = $row['banned_until'];
            $time = time();
            
            if($banned > $time) {
                $_SESSION['banned'] = 1;
            }
            */

            header('Location:'.$location);
        } else {
            echo "<h6>Incorrect details!</h6>";
        }
    }
}
include 'sidebar_new.php';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="wrap-content">
<br><br>
<div class="center-align">
<div id="wrong_login" class="red-alert"></div><br>
<form action="" method="post" enctype="multipart/form-data">
      <input type="text" name="username" placeholder="Username" class="text-input"><br><br>
      <input type="password" name="password" placeholder="Password" class="text-input"><br><br>
      <button type="submit" name="login" class="button button1" id="login" onclick="loggingIn()">LOGIN</button>
    </form><br>
    <a href="forgot_password.php" class="button button2">FORGOT PASSWORD</a><br><br>
</div>
</div>
</div>
</div>
</body>
</html>
