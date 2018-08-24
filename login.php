<?php
include 'sidebar_new.php';
include_once 'db.php';
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
<?php

if (isset($_POST['login'])) {
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    $username = stripslashes($username);
    $password = stripslashes($password);

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    $id = $row['id'];
    $db_password = $row['password'];
    $admin = $row['admin'];
    $email = $row['email'];

    if (password_verify($password, $db_password)) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;

        if ($admin == 1) {
            $_SESSION['admin'] = 1;
        }
        header('Location: index.php');
    } else {
        echo "<h6>Incorrect details!</h6>";
    }
}
?>
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