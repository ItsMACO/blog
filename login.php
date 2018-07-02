<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <script src="materialize/js/materialize.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col s3">
                <?php
                include('sidebar.php');
                ?>
            </div>
            <div class="col s8">
                <br><br><br><br>
    <form action="login.php" method="post" enctype="multipart/form-data">
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
    $email = $row['email'];

    if($password == $db_password) {
        $_SESSION['username'] = $username;
        $_SESSION['id'] = $id;

        if($admin == 1) {
            $_SESSION['admin'] = 1;
        }
        header('Location: index.php');
    } else {
        echo "<br><br><br><h3>Incorrect details!</h3>";
    }
}
?>

      <input type="text" name="username" placeholder="Username">
      <input type="password" name="password" placeholder="Password">
      <button type="submit" name="login" class="button button2">LOGIN</button>
    </form>
</div>
<div class="col s1"></div>
</div>
</div>

</body>
</html>