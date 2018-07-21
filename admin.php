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
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog</title>
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
            $admin = "<div><a href='edit_post.php?pid=$id' class='button button2'>EDIT</a>&nbsp;<a href='del_post.php?pid=$id' class='button button3'>DELETE</a></div>";
        }

        $posts .= "<div><h2><a href='view_post.php?pid=$id' target='_blank'>$title</a></h2><p>$date by <a href='profile.php?id=$userid'>$author</a></p>$admin</div><br><div class='divider'></div>";
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
            <button type="submit" class="button button1">SET</button>
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
    <li>
        <div class="collapsible-header"><i class="medium material-icons">star</i>Add or remove Karma</div>
        <div class="collapsible-body">
        <span>
            <form action="admin.php" method="post" enctype="multipart/form-data">
            <input type="text" name="set_karma_username" class="text-input" placeholder="Username"><br><br>
            <input type="text" name="set_karma" class="text-input" placeholder="Karma Amount"><br><br>
            <div class="switch">
                <label>
                Remove
                <input type="checkbox" name="yes_no2">
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

                        $bug_reports = "<br>
                                        <div><h5 class='blue-text text-darken-2'>Bug report id:</h5><h6>$bug_id</h6>
                                        <h5 class='blue-text text-darken-2'>Title:</h5><h6>$bug_title</h6>
                                        <h5 class='blue-text text-darken-2'>Affected pages:</h5><h6>$bug_page</h6>
                                        <h5 class='blue-text text-darken-2'>More information:</h5><h6>$bug_more_info</h6>
                                        <h5 class='blue-text text-darken-2'>Reported by:</h5><h6>$bug_username</h6></div>
                                        <br>
                                        <div class='divider'></div>";
                        echo $bug_reports;
                    }
                }
            }
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

                        $feature_requests = "<br>
                                        <div><h5 class='blue-text text-darken-2'>Feature request id:</h5><h6>$feature_id</h6>
                                        <h5 class='blue-text text-darken-2'>Title:</h5><h6>$feature_title</h6>
                                        <h5 class='blue-text text-darken-2'>More information:</h5><h6>$feature_more_info</h6>
                                        <h5 class='blue-text text-darken-2'>Requested by:</h5><h6>$feature_username</h6></div>
                                        <br>
                                        <div class='divider'></div>";
                        echo $feature_requests;
                    
                    
                    }
                }
            }
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
<script>
var elem = document.querySelector('.collapsible.expandable');
var instance = M.Collapsible.init(elem, {
  accordion: false
});</script>
</body>
</html>