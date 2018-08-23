<?php
include 'sidebar_new.php';
require_once 'db.php';

if (isset($_POST['feature_submit'])) {
    $feature_title = strip_tags($_POST['feature_title']);
    $feature_more_info = strip_tags($_POST['feature_more_info']);

    $feature_title = stripslashes($feature_title);
    $feature_more_info = stripslashes($feature_more_info);

    $feature_title = mysqli_real_escape_string($con, $feature_title);
    $feature_more_info = mysqli_real_escape_string($con, $feature_more_info);

    if (isset($_SESSION['id'])) {
        $feature_userid = $_SESSION['id'];
    } else {
        $feature_userid = 99999;
    }
    $feature_store = "INSERT INTO feature_requests (feature_title, feature_more_info, userid) VALUES ('$feature_title', '$feature_more_info', '$feature_userid')";

    mysqli_query($con, $feature_store);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Feature Request</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css?<?php echo time(); ?>">
    <script src="materialize/js/materialize.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>">
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="wrap-content">
<br><br>
<form action="feature_request.php" method="post">
<input type="text" name="feature_title" size="48" placeholder="Your feature request title" class="text-input"><br><br>
<textarea name="feature_more_info" class="text-input" placeholder="Additional information" rows="2" cols="48"></textarea><br>
<p>If you're logged in, you may receive some Karma for your service.</p>
<button type="submit" name="feature_submit" class="button button1">SUBMIT</button>
</form><br><br>
</div>
</div>
</div>
</body>
</html>
