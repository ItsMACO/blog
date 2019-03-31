<?php
    require_once 'db.php';
    $sql_user_reports = "SELECT * FROM user_reports ORDER BY id";
    $result_user_reports = mysqli_query($con, $sql_user_reports) or die(mysqli_error($con));
    if (mysqli_num_rows($result_user_reports) > 0) {
        while ($row = mysqli_fetch_assoc($result_user_reports)) {
            $user_report_id = $row['id'];
            $user_report_userid = $row['userid'];
            $user_report_user_from = $row['user_from'];
            $user_report_reason = $row['reason'];

            $sql_profile = "SELECT * FROM users WHERE id='$user_report_user_from'";
            $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
            $row = mysqli_fetch_assoc($result_profile);
            $user_reported_by = $row['username'];

            $sql_profile2 = "SELECT * FROM users WHERE id='$user_report_userid'";
            $result_profile2 = mysqli_query($con, $sql_profile2) or die(mysqli_error($con));
            $row = mysqli_fetch_assoc($result_profile2);
            $user_reported = $row['username'];

                    $user_reports = "<div><h6 class='blue-text text-darken-2'>User:</h6><a href='profile.php?id=$user_report_userid'>$user_reported</a><br><br>
                                    <a href='admin.php?ban_name=$user_reported' class='button-small button3 modal-trigger'>PUNISH</a><br>
                                    <h6 class='blue-text text-darken-2'>Reported by:</h6><a href='profile.php?id=$user_report_user_from'>$user_reported_by</a><br><br>
                                    <a href='admin.php?set_karma=$user_reported_by' class='button-small button1'>REWARD KARMA</a><br>
                                    <h6 class='blue-text text-darken-2'>Reason:</h6><h6>$user_report_reason</h6></div>
                                    <br>
                                    <div class='divider'></div>";
                    echo $user_reports;
                }
    } else {
        echo "There are no user reports!<br>";
    }
?>