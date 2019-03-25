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
            $bug_username = $row['bug_from'];

            $bug_reports .= "<div><h6 class='blue-text text-darken-2'>Title:</h6><p>$bug_title</p>
                            <h6 class='blue-text text-darken-2'>Affected pages:</h6><p>$bug_page</p>
                            <h6 class='blue-text text-darken-2'>More information:</h6><p>$bug_more_info</p>
                            <h6 class='blue-text text-darken-2'>Reported by:</h6><p>$bug_username</p>
                            <a href='admin.php?set_karma=$bug_username' class='button-small button1'>REWARD KARMA</a><br><br>
                            <a href='close_report.php' class='button-small button2'>CLOSE REPORT</a>
                            <br>
                            </div><br>
                            <div class='divider'></div>";
        }
        echo $bug_reports;
        if(isset($_POST['close_bug'])) {
            $sql_close_bug = "UPDATE bug_reports SET status='closed' WHERE bug_id=$bug_id";
            mysqli_query($con, $sql_close_bug);
        }
    } else {
        echo "There are no bug reports! Yay!<br>";
    }
        ?>
</div>
