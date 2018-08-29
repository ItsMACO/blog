<?php
if (isset($_SESSION['id'])) {
    header('Location: index.php');
}
include 'sidebar_new.php';
include_once 'db.php';

if (isset($_POST['register'])) {

    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $password_confirm = strip_tags($_POST['password_confirm']);
    $email = strip_tags($_POST['email']);

    $username = stripslashes($username);
    $password = stripslashes($password);
    $password_confirm = stripslashes($password_confirm);
    $email = stripslashes($email);

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);
    $password_confirm = mysqli_real_escape_string($con, $password_confirm);
    $email = mysqli_real_escape_string($con, $email);
    $sql_fetch_username = "SELECT username FROM users WHERE username = '$username'";
    $sql_fetch_email = "SELECT email FROM users WHERE email = '$email'";

    $query_username = mysqli_query($con, $sql_fetch_username);
    $query_email = mysqli_query($con, $sql_fetch_email);

    if (mysqli_num_rows($query_username)) {
        echo "There is already a user with that name.";
        return;
    }
    if ($username == "") {
        echo "Please insert a username.";
        return;
    }
    if ($password == "" || $password_confirm == "") {
        echo "Please insert a password.";
        return;
    }
    if ($password != $password_confirm) {
        echo "The passwords do not match!";
        return;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || $email == "") {
        echo "This email is not valid.";
        return;
    }
    if (mysqli_num_rows($query_email)) {
        echo "This email is already in use.";
        return;
    }

    $password = password_hash($password, PASSWORD_BCRYPT);
    $sql_store = "INSERT into users (username, password, email) VALUES('$username', '$password', '$email')";
    mysqli_query($con, $sql_store);
    header('Location: login.php');

}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
<div class="container-fluid">
    <div class="wrap">
        <div class="center-align">
    <br><br>
    <form action="register.php" method="post" enctype="multipart/form-data">
    <input placeholder="Username" name="username" type="text" class="text-input" autofocus><br><br>
    <input placeholder="Password" name="password" type="password" class="text-input"><br><br>
    <input placeholder="Confirm Password" name="password_confirm" type="password" class="text-input"><br><br>
    <input placeholder="Email address" name="email" type="text" class="text-input"><br><br>
      <button type="submit" name="register" class='button button1'>REGISTER</button>
    </form><br><br>
    </div>
    </div>
    </div>
</body>
</html>