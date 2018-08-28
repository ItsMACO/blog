<?php
include 'sidebar_new.php';
include_once 'db.php';

if (!isset($_SESSION['admin']) && $_SESSION['admin'] != 1) {
    header('Location: login.php');

}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
</head>
<body>
<div class="container-fluid">
    <div class="wrap">
        <div class="wrap-content">
        <br><br>
<ul class="collapsible expandable">
 <li>
   <div class="collapsible-header"><i class="medium material-icons">art_track</i>Edit or delete posts</div>
   <div class="collapsible-body"><span>
   <?php

$sql = "SELECT * FROM posts ORDER BY id DESC";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$posts = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $date = $row['date'];
        $author = $row['author'];
        $flair = $row['flair'];

        $sql_profile = "SELECT * FROM users WHERE username='$author'";
        $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
        if (mysqli_num_rows($result_profile) > 0) {
            while ($row = mysqli_fetch_assoc($result_profile)) {
                $userid = $row['id'];
                $username = $row['username'];
                $email = $row['email'];
            }
        }

        if (isset($_SESSION['id'])) {
            $admin = "<div><a href='edit_post.php?pid=$id' class='button-small button2'>EDIT</a>&nbsp;
            <a href='del_post.php?pid=$id' class='button-small button3'>DELETE</a></div>";
        }

        $posts .= "<div style='display: inline-block;'>
        <h4><a href='view_post.php?pid=$id' target='_blank' class='break-long-words'>$title</a></h4>
        <span class='flair'>$flair</span> by 
        <a href='profile.php?id=$userid'>$author</a><br><br>
        $admin</div><br><br><div class='divider'></div>";
    }

    echo $posts;

} else {
    echo "There are no posts to display!";
}

?>
   </span>
</div>
</li>
    <li>
        <div class="collapsible-header"><i class="medium material-icons">adb</i>Add or remove admin</div>
        <div class="collapsible-body">
        <span>
            <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="text" name="set_admin" class="text-input" placeholder="Username"><br><br>
            <div class="switch">
                <label>
                No
                <input type="checkbox" name="yes_no">
                <span class="lever"></span>
                Yes
                </label>
            </div><br>
            <button type="submit" class="button button1" id="set_admin_btn">SET</button>
            </form>
            <?php
            if(isset($_POST['set_admin'])){
                $set_admin = strip_tags($_POST['set_admin']);
                $set_admin = mysqli_real_escape_string($con, $set_admin);
                if(isset($_POST['yes_no'])) {
                    $sql_set_admin = "UPDATE users SET admin=1 WHERE username='$set_admin'";
                    mysqli_query($con, $sql_set_admin);
                } else {
                    $sql_set_admin = "UPDATE users SET admin=0 WHERE username='$set_admin'";
                    mysqli_query($con, $sql_set_admin);
                }
            }
            ?>
        </span></div>
    </li>
    </li>
        <li <?php if(isset($_GET['set_karma'])) { ?> class="active" <?php } ?>>
        <div class="collapsible-header"><i class="medium material-icons">star</i>Add or remove Karma</div>
        <div class="collapsible-body">
        <span>
            <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="text" name="set_karma_username" class="text-input" placeholder="Username" <?php if(isset($_GET['set_karma'])) { ?> value="<?php echo $_GET['set_karma']; ?>"<?php } ?>><br><br>
            <input type="text" name="set_karma" class="text-input" placeholder="Karma Amount"><br><br>
            <div class="switch">
                <label>
                Remove
                <input type="checkbox" name="yes_no2" <?php if(isset($_GET['set_karma'])) { ?> checked <?php } ?>>
                <span class="lever"></span>
                Add
                </label>
            </div><br>
            <button type="submit" class="button button1">SET</button>
            </form>
            <?php
            if(isset($_POST['set_karma_username']) && isset($_POST['set_karma'])){
                $set_karma_username = strip_tags($_POST['set_karma_username']);
                $set_karma_username = mysqli_real_escape_string($con, $set_karma_username);
                $set_karma = strip_tags($_POST['set_karma']);
                $set_karma = mysqli_real_escape_string($con, $set_karma);
                if(isset($_POST['yes_no2'])) {
                    $sql_set_karma = "UPDATE users SET karma = karma + $set_karma WHERE username='$set_karma_username'";
                    mysqli_query($con, $sql_set_karma);
                } else {
                    $sql_set_karma = "UPDATE users SET karma = karma - $set_karma WHERE username='$set_karma_username'";
                    mysqli_query($con, $sql_set_karma);
                }
            }
            ?>
        </span></div>
    </li>
    <li>
        <div class="collapsible-header"><i class="medium material-icons">local_offer</i>Add flairs</div>
        <div class="collapsible-body">
        <span>
            <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="text" name="set_flair" class="text-input" placeholder="Flair name"><br><br>
            <button type="submit" class="button button1">ADD</button>
            </form><br>
            <?php
            if(isset($_POST['set_flair'])) {
                $set_flair = strip_tags($_POST['set_flair']);
                $set_flair = mysqli_real_escape_string($con, $set_flair);
                $sql_flair_exists = "SELECT * FROM flairs WHERE flairname='$set_flair'";
                $result_flair_exists = mysqli_query($con, $sql_flair_exists);
                if(mysqli_num_rows($result_flair_exists) > 0) {
                    echo "This flair already exists!";
                } else {
                $sql_flair = "INSERT INTO flairs (flairname) VALUES ('$set_flair')";
                mysqli_query($con, $sql_flair);
                }
            }
            ?>
        </span></div>
    </li>
    <li>
        <div class="collapsible-header"><i class="medium material-icons">add_alarm</i>Add or set active countdown</div>
        <div class="collapsible-body">
        <span>
            <a href="#help-countdown" class="button-small button2 modal-trigger">HELP?</a><br><br>
            <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="text" name="event" class='text-input' placeholder="Event name"><br><br>
            <input type="date" name="date" class="text-input"><br><br>
            <input type="time" name="time" class="text-input"><br><br>
            <button type="submit" name="add_countdown" class="button button1">ADD</button>
            </form><br><br>
            <div class='divider'></div><div class='divider'></div><div class='divider'></div><br><br>
            <?php
            if(isset($_POST['add_countdown'])) {
                $event = $_POST['event'];
                $date = $_POST['date'];
                $time = $_POST['time'];
                $sql_add_countdown = "INSERT INTO countdowns (event, date, time) VALUES ('$event', '$date', '$time')";
                mysqli_query($con, $sql_add_countdown);
            }
            ?>
            <form action='admin.php' method='post' enctype="multipart/form-data">
            <select name='active_countdown'>
            <?php
            $sql_exist_countdown = "SELECT * FROM countdowns ORDER BY id DESC";
            $result_exist_countdown = mysqli_query($con, $sql_exist_countdown);
            if(mysqli_num_rows($result_exist_countdown) > 0) {
                while($row = mysqli_fetch_assoc($result_exist_countdown)) {
                    $countdown_id = $row['id'];
                    $countdown_event = $row['event'];
                    $countdown_date = $row['date'];
                    $countdown_time = $row['time'];
                    
                    echo "<option value='".$countdown_id."'>$countdown_event ($countdown_date $countdown_time)</option>";
                }
            }
            ?>
            </select><br><br>
            <button type="submit" name="set_active_countdown" class="button button1">SET ACTIVE</button>
            </form>
            <?php
            if(isset($_POST['set_active_countdown'])) {
                $set_active_event = $_POST['active_countdown'];
                $sql_set_active = "UPDATE countdowns SET active=1 WHERE id='$set_active_event'";
                $sql_set_inactive = "UPDATE countdowns SET active=0 WHERE NOT id='$set_active_event'";
                mysqli_query($con, $sql_set_active);
                mysqli_query($con, $sql_set_inactive);
            }
            ?>
        </span></div>
    </li>
    <li>
        <div class="collapsible-header"><i class="medium material-icons">bug_report</i>Show bug reports</div>
        <div class="collapsible-body">
        <span>
        <?php
        $sql_bugs = "SELECT * FROM bug_reports";
        $result_bugs = mysqli_query($con, $sql_bugs) or die(mysqli_error($con));
        if (mysqli_num_rows($result_bugs) > 0) {
            while ($row = mysqli_fetch_assoc($result_bugs)) {
                $bug_id = $row['bug_id'];
                $bug_title = $row['bug_title'];
                $bug_page = $row['bug_page'];
                $bug_more_info = $row['bug_more_info'];
                $bug_userid = $row['userid'];

                $sql_profile = "SELECT * FROM users WHERE id='$bug_userid'";
                $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
                if (mysqli_num_rows($result_profile) > 0) {
                    while ($row = mysqli_fetch_assoc($result_profile)) {
                        $bug_username = $row['username'];

                        $bug_reports = "<div><h5 class='blue-text text-darken-2'>Title:</h5><h6>$bug_title</h6>
                                        <h5 class='blue-text text-darken-2'>Affected pages:</h5><h6>$bug_page</h6>
                                        <h5 class='blue-text text-darken-2'>More information:</h5><h6>$bug_more_info</h6>
                                        <h5 class='blue-text text-darken-2'>Reported by:</h5><h6>$bug_username</h6>
                                        <a href='admin.php?set_karma=$bug_username' class='button-small button1'>REWARD KARMA</a><br>
                                        </div><br>
                                        <div class='divider'></div>";
                        echo $bug_reports;
                    }
                }
            }
        } else {
            echo "There are no bug reports! Yay!<br>";
        }
            ?>
        </span></div>
    </li>
    <li>
        <div class="collapsible-header"><i class="medium material-icons">playlist_add</i>Show feature requests</div>
        <div class="collapsible-body">
        <span>
        <?php
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

                        $feature_requests = "<div><h5 class='blue-text text-darken-2'>Title:</h5><h6>$feature_title</h6>
                                        <h5 class='blue-text text-darken-2'>More information:</h5><h6>$feature_more_info</h6>
                                        <h5 class='blue-text text-darken-2'>Requested by:</h5><h6>$feature_username</h6>
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
        </span></div>
    </li>
    <li>
        <div class="collapsible-header red-text text-darken-2"><i class="medium material-icons">report</i>Show post reports</div>
        <div class="collapsible-body">
        <span>
        <?php
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

                        $post_reports = "<div><h5 class='blue-text text-darken-2'>Post link:</h5><a href='view_post.php?pid=$post_report_postid'>$post_report_postid</a><br><br>
                                        <a href='del_post.php?pid=$post_report_postid' class='button-small button3'>REMOVE POST</a><br>
                                        <h5 class='blue-text text-darken-2'>Reported by:</h5><a href='profile.php?id=$post_report_user_from'>$post_report_username</a><br><br>
                                        <a href='admin.php?set_karma=$post_report_username' class='button-small button1'>REWARD KARMA</a><br>
                                        <h5 class='blue-text text-darken-2'>Reason:</h5><h6>$post_report_reason</h6></div>
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
        </span></div>
    </li>
    <li>
        <div class="collapsible-header red-text text-darken-2"><i class="medium material-icons">person</i>Show user reports</div>
        <div class="collapsible-body">
        <span>
        <?php
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

                        $user_reports = "<div><h5 class='blue-text text-darken-2'>User:</h5><a href='profile.php?id=$user_report_userid'>$user_reported</a><br><br>
                                        <a href='punish_user.php?id=$userid' class='button-small button3'>PUNISH USER</a><br>
                                        <h5 class='blue-text text-darken-2'>Reported by:</h5><a href='profile.php?id=$user_report_user_from'>$user_reported_by</a><br><br>
                                        <a href='admin.php?set_karma=$user_reported_by' class='button-small button1'>REWARD KARMA</a><br>
                                        <h5 class='blue-text text-darken-2'>Reason:</h5><h6>$user_report_reason</h6></div>
                                        <br>
                                        <div class='divider'></div>";
                        echo $user_reports;
                    }
        } else {
            echo "There are no user reports!<br>";
        }
            ?>
        </span></div>
    </li>
</ul>
<br>
</div>
<!--DIV ROW -->
</div>
<!--DIV CONTAINER FLUID -->
</div>
<div id="help-countdown" class="modal">
    <div class="modal-content">
      <h4>Countdown Help</h4>
      <p>To create a new countdown, insert an Event name into the input field, then set the date and time you want to count down to and click ADD.</p>
      <p>To display a countdown on the homepage, scroll down a little bit and choose an event from the dropdown menu, then click SET ACTIVE.</p>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close btn-flat">Close</a>
    </div>
  </div>
<script>
var elem = document.querySelector('#help-countdown');
var instance = M.Modal.init(elem, {
  accordion: false
});
</script>
<script>
var elem = document.querySelector('.collapsible.expandable');
var instance = M.Collapsible.init(elem, {
  accordion: false
});
</script>
</body>
</html>