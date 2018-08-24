<?php
require 'db.php';
require 'sidebar_new.php';
$token = $_GET['token'];

if(isset($_SESSION['id'])) {
    header('Location: index.php');
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="center-align">
    <br><br>
<?php
    echo "<form action='login.php' method='post' enctype='multipart/form-data'>";
    echo "<input type='password' name='password' placeholder='Password' class='text-input'><br><br>";
    echo "<input type='password' name='password_confirm' placeholder='Confirm Password' class='text-input'><br><br>";
    echo "<button type='submit' name='reset_password' class='button button1'>RESET PASSWORD</button><br><br>";
    echo "</form><br><br>";


    if(isset($_POST['reset_password'])) {
        $password = strip_tags($_POST['password']);
        $password_confirm = strip_tags($_POST['password_confirm']);
    
        $password = stripslashes($password);
        $password_confirm = stripslashes($password_confirm);
    
        $password = mysqli_real_escape_string($con, $password);
        $password_confirm = mysqli_real_escape_string($con, $password_confirm);
    
        if ($password == "" || $password_confirm == "") {
            echo "Please insert a password.";
            return;
        } 
        if ($password != $password_confirm) {
            echo "The passwords do not match!";
            return;
        } else {
            $password = password_hash($password, PASSWORD_BCRYPT);
            $sql = "UPDATE users SET password='$password' WHERE forgot_token='$token'";
            mysqli_query($con, $sql);
        }
    }
?>
</div>
</div>
</div>
</body>
</html>