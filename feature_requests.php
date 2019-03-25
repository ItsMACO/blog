<?php
require_once 'db.php';
if(!isset($_SESSION)) {
	session_start();
}
    $sql_features = "SELECT * FROM feature_requests";
    $result_features = mysqli_query($con, $sql_features) or die(mysqli_error($con));
    if (mysqli_num_rows($result_features) > 0) {
        while ($row = mysqli_fetch_assoc($result_features)) {
            $feature_id = $row['feature_id'];
            $feature_title = $row['feature_title'];
            $feature_more_info = $row['feature_more_info'];
            $feature_userid = $row['userid'];

            $sql_profile = "SELECT * FROM users WHERE id='$feature_userid'";
            $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
            if (mysqli_num_rows($result_profile) > 0) {
                while ($row = mysqli_fetch_assoc($result_profile)) {
                    $feature_username = $row['username'];

                    $feature_requests = "<div><h6 class='blue-text text-darken-2'>Title:</h6><p>$feature_title</p>
                                    <h6 class='blue-text text-darken-2'>More information:</h6><p>$feature_more_info</p>
                                    <h6 class='blue-text text-darken-2'>Requested by:</h6><p>$feature_username</p>
                                    <a href='admin.php?set_karma=$feature_username' class='button-small button1'>REWARD KARMA</a><br>
                                    </div><br>
                                    <div class='divider'></div>";
                    echo $feature_requests;
                }
            }
        }
    } else {
        echo "There are no feature requests!<br>";
    }
?>