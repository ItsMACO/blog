<?php
require 'sidebar_new.php';
if(isset($_SESSION['id'])) {
    header('Location: index.php');
}

//RANDOM STRING GENERATOR

function random_str($length, $keyspace = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $pieces = [];
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $pieces []= $keyspace[random_int(0, $max)];
    }
    return implode('', $pieces);
}

$random_token = random_str(128);
?>
<!DOCTYPE html>
<html>
    <title>Forgot password</title>
<body>
<div class='container-fluid'>
<div class='wrap'>
<div class='center-align'>
<br><br>
    <form action="forgot_password.php" method="post">
    <input type="text" name="forgot-email" placeholder="Your e-mail address" class="text-input"><br><br>
    <button type="submit" name="forgot-submit" class="button button1">SEND</button>
    </form><br><br>

<?php


if(isset($_POST['forgot-submit'])) {
    $forgot_email = $_POST['forgot-email'];
    $sql = "UPDATE users SET forgot_token='$random_token' WHERE email='$forgot_email'"; 
    mysqli_query($con, $sql);
}
?>

    </div>
    </div>
    </div>
</body>
</html>