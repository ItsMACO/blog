<?php
require 'sidebar.php';
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
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Forgot password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css">
    <script src="materialize/js/materialize.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css" />
    <script src="main.js"></script>
<body>
<div class='container-fluid'>
<div class='row'>
<div class='col s3'></div>
<div class='col s8'>
<br><br>
    <form action="forgot_password.php" method="post">
    <input type="text" name="forgot-email" placeholder="Your e-mail address" class="text-input"><br><br>
    <button type="submit" name="forgot-submit" class="button button1">SEND</button>
    </form>

<?php


if(isset($_POST['forgot-submit'])) {
    $forgot_email = $_POST['forgot-email'];
    $sql = "UPDATE users SET forgot_token='$random_token' WHERE email='$forgot_email'"; 
    mysqli_query($con, $sql);

    $to = $forgot_email;
    $subject = "Reset password | Blog";

    $message = "
    <html>
    <head>
    <title>HTML email</title>
    </head>
    <body>
    <h4>http://localhost/blog/reset_password.php?token=$random_token</h4>
    </body>
    </html>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= 'From: <macoplays8@gmail.com>' . "\r\n";
    mail($to, $subject, $message, $headers);

    echo "<h6>We've sent an e-mail to $forgot_email. <br>Check your inbox to reset your password. <br>You can leave this page now.</h6>";
}
?>

    </div>
    <div class='col s1'></div>
    </div>
    </div>
</body>
</html>