<?php
require_once 'db.php';
if(!isset($_SESSION)) {
	session_start();
}
    $sql_post_reports = "SELECT * FROM post_reports ORDER BY id";
    $result_post_reports = mysqli_query($con, $sql_post_reports) or die(mysqli_error($con));
    if (mysqli_num_rows($result_post_reports) > 0) {
        while ($row = mysqli_fetch_assoc($result_post_reports)) {
            $post_report_id = $row['id'];
            $post_report_postid = $row['postid'];
            $post_report_user_from = $row['user_from'];
            $post_report_reason = $row['reason'];

            $sql_profile = "SELECT * FROM users WHERE id='$post_report_user_from'";
            $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
            if (mysqli_num_rows($result_profile) > 0) {
                while ($row = mysqli_fetch_assoc($result_profile)) {
                    $post_report_username = $row['username'];

                    $post_reports = "<div><h6 class='blue-text text-darken-2'>Post link:</h6><a href='view_post.php?pid=$post_report_postid'>$post_report_postid</a><br><br>
                                    <a href='del_post.php?pid=$post_report_postid' class='button-small button3'>REMOVE POST</a><br>
                                    <h6 class='blue-text text-darken-2'>Reported by:</h6><a href='profile.php?id=$post_report_user_from'>$post_report_username</a><br><br>
                                    <a href='admin.php?set_karma=$post_report_username' class='button-small button1'>REWARD KARMA</a><br>
                                    <h6 class='blue-text text-darken-2'>Reason:</h6><h6>$post_report_reason</h6></div>
                                    <br>
                                    <div class='divider'></div>";
                    echo $post_reports;
                }
            }
        }
    } else {
        echo "There are no post reports!<br>";
    }
?>