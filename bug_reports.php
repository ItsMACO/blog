<div class='wrap-content'>
<?php
    require_once 'db.php';
	if(!isset($_SESSION)) {
		session_start();
	}
    include_once 'admin_back.php';
    $bug_reports = "";
    $sql_bugs = "SELECT * FROM bug_reports";
    $result_bugs = mysqli_query($con, $sql_bugs) or die(mysqli_error($con));
    if (mysqli_num_rows($result_bugs) > 0) {
        while ($row = mysqli_fetch_assoc($result_bugs)) {
            $bug_id = $row['bug_id'];
            $bug_title = $row['bug_title'];
            $bug_page = $row['bug_page'];
            $bug_more_info = $row['bug_more_info'];
            $bug_userid = $row['bug_from'];
				$sql_username = "SELECT username FROM users WHERE id='$bug_userid'";
				$result_username = mysqli_query($con, $sql_username);
				if(mysqli_num_rows($result_username) > 0) {
					$row = mysqli_fetch_assoc($result_username);
					$bug_username = $row['username'];
				}

            $bug_reports .= "<div><h6 class='blue-text text-darken-2'>Title:</h6><p>$bug_title</p>
                            <h6 class='blue-text text-darken-2'>Affected pages:</h6><p>$bug_page</p>
                            <h6 class='blue-text text-darken-2'>More information:</h6><p>$bug_more_info</p>
                            <h6 class='blue-text text-darken-2'>Reported by:</h6><p>$bug_username</p>
                            <a href='admin_new.php?set_karma=$bug_username' class='button-small button1'>REWARD KARMA</a><br><br>
                            <a href='close_bug_report.php?bug_id=$bug_id' class='button-small button2'>CLOSE REPORT</a>
                            <br>
                            </div><br>
                            <div class='divider'></div>";
        }
        echo $bug_reports;
    } else {
        echo "There are no bug reports! Yay!<br>";
    }
        ?>
</div>
