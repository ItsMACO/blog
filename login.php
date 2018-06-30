<?php
session_start();

if(isset($_POST['login'])) {
    include_once('db.php');
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);

    
    $username = stripslashes($username);
    $password = stripslashes($password);

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);

    $password = md5($password);

    $sql = "SELECT * FROM users WHERE username = '$username' LIMIT 1";
    $query = mysqli_query($con, $sql);
    $row = mysqli_fetch_array($query);
    $id = $row['id'];
    $db_password = $row['password'];
    $admin = $row['admin'];

    if($password = $db_password) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;

        if($admin == 1) {
            $_SESSION['admin'] = 1;
        }
        header('Location: index.php');
    } else {
        echo "You didn't enter correct details!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <form action="login.php" method="post" enctype="multipart/form-data">
    <div class="materialContainer">


<div class="box">

   <div class="title">LOGIN</div>

   <div class="input">
      <input type="text" name="username" placeholder="Username">
      <span class="spin"></span>
   </div>

   <div class="input">
      <input type="password" name="password" placeholder="Password">
      <span class="spin"></span>
   </div>

   <div class="button login">
      <button type="submit" name="login"><span>GO</span> <i class="fa fa-check"></i></button>
   </div>

   <a href="" class="pass-forgot">Forgot your password?</a>

</div>

    </form>

</body>
</html>