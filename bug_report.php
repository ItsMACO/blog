<?php
include 'sidebar_new.php';
require_once 'db.php';

if (isset($_POST['bug_submit'])) {
    $bug_title = strip_tags($_POST['bug_title']);
    $bug_page = strip_tags($_POST['bug_page']);
    $bug_more_info = strip_tags($_POST['bug_more_info']);

    $bug_title = stripslashes($bug_title);
    $bug_page = stripslashes($bug_page);
    $bug_more_info = stripslashes($bug_more_info);

    $bug_title = mysqli_real_escape_string($con, $bug_title);
    $bug_page = mysqli_real_escape_string($con, $bug_page);
    $bug_more_info = mysqli_real_escape_string($con, $bug_more_info);

    if(isset($_SESSION['username'])) {
        $bug_username = $_SESSION['username'];
    } else {
        $bug_userid = 99999;
    }
    $bug_store = "INSERT INTO bug_reports (bug_title, bug_page, bug_more_info, bug_from) VALUES ('$bug_title', '$bug_page', '$bug_more_info', '$bug_username')";

    mysqli_query($con, $bug_store);
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Bug Report</title>
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="wrap-content">
<br><br>
<form action="bug_report.php" method="post">
<input type="text" name="bug_title" size="48" placeholder="Your bug report title" class="text-input"><br><br>
<input type="text" name="bug_page" size="48" placeholder="On what page did it happen?" class="text-input"><br><br>
<textarea name="bug_more_info" class="text-input" placeholder="Additional information" rows="2" cols="48"></textarea><br>
<p>If you're logged in, you may receive some Karma for your service.</p>
<button type="submit" name="bug_submit" class="button button1">SUBMIT</button>
</form><br><br>
</div>
</div>
</div>
</body>
</html>
