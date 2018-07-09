<?php
if (isset($_SESSION['id'])) {
    header('Location: index.php');
}

if (isset($_POST['register'])) {
    include_once 'db.php';

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

    $password = md5($password);
    $password_confirm = md5($password_confirm);

    $sql_store = "INSERT into users (username, password, email) VALUES('$username', '$password', '$email')";
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

    mysqli_query($con, $sql_store);
    header('Location: index.php');

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css">
    <script src="materialize/js/materialize.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css">

</head>
<body style="background: white !important;">
<div class="container-fluid">
<div class="row">
<div class="col s3">
<?php
require 'sidebar.php';
?>
</div>
<div class="col s8">
<br><br><br><br>
    <form action="register.php" method="post" enctype="multipart/form-data">
    <input placeholder="Username" name="username" type="text" class="text-input" autofocus><br><br>
    <input placeholder="Password" name="password" type="password" class="text-input"><br><br>
    <input placeholder="Confirm Password" name="password_confirm" type="password" class="text-input"><br><br>
    <input placeholder="Email address" name="email" type="text" class="text-input"><br><br>
      <button type="submit" name="register" class='button button1'>REGISTER</button>
    </form>
    </div>
    <div class="col s1"></div>
    </div>
    </div>
</body>
</html>