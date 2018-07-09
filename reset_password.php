<?php
require 'db.php';
require 'sidebar.php';
$current_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$token = substr($current_link, -128);

if(isset($_SESSION['id'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Reset Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css">
    <script src="materialize/js/materialize.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css" />
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
<div class="row">
<div class="col s3"></div>
<div class="col s8">
    <br><br>
<?php
    echo "<form action='reset_password.php?token=$token' method='post' enctype='multipart/form-data'>";
    echo "<input type='password' name='password' placeholder='Password' class='text-input'><br><br>";
    echo "<input type='password' name='password_confirm' placeholder='Confirm Password' class='text-input'><br><br>";
    echo "<button type='submit' name='reset_password' class='button button1'>RESET PASSWORD</button><br><br>";
    echo "</form>";


    if(isset($_POST['reset_password'])) {
        $password = strip_tags($_POST['password']);
        $password_confirm = strip_tags($_POST['password_confirm']);
    
        $password = stripslashes($password);
        $password_confirm = stripslashes($password_confirm);
    
        $password = mysqli_real_escape_string($con, $password);
        $password_confirm = mysqli_real_escape_string($con, $password_confirm);
    
        $password = md5($password);
        $password_confirm = md5($password_confirm);
    
        if ($password == "" || $password_confirm == "") {
            echo "Please insert a password.";
            return;
        } elseif ($password != $password_confirm) {
            echo "The passwords do not match!";
            return;
        } else {
            $sql = "UPDATE users SET password='$password' WHERE forgot_token='$token'";
            mysqli_query($con, $sql);
            echo "Password set!";
        }
    }
?>
</div>
<div class="col s1"></div>
</div>
</div>
</body>
</html>