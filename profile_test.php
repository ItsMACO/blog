<?php
include 'sidebar_new.php';
include_once 'db.php';
if(!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>
</head>
<body>
<div class="container-fluid">
    <div class="wrap">
        <div class="center-align">
        <br>
<?php
$id = $_GET['id'];
$uid = $_GET['id'];

require_once 'nbbc.php';
$bbcode = new BBCode;

$sql_profile = "SELECT * FROM users WHERE id=$id";
$result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));

if (mysqli_num_rows($result_profile) > 0) {
    while ($row = mysqli_fetch_assoc($result_profile)) {
        $userid = $row['id'];
        $username = $row['username'];
        $email = $row['email'];
        $isAdmin = $row['admin'];
        $profile_bio = $row['profile_bio'];
        $karma = $row['karma'];
        $profile_pic = $row['profile_pic'];
        $date_joined = $row['date_joined'];
    }

    $sql_top_cont = "SELECT id FROM users ORDER BY karma DESC LIMIT 1";
    $result_top_cont = mysqli_query($con, $sql_top_cont);
    $row = mysqli_fetch_assoc($result_top_cont);
    $top_cont = $row['id'];

    if($isAdmin == 1) {
        $admin_pin = "<i class='material-icons tooltipped' data-position='bottom' data-tooltip='Admin'>verified_user</i>";
    } else {
        $admin_pin = "";
    }
    if($top_cont == $uid) {
        $top_cont_pin = "<i class='material-icons tooltipped' data-position='bottom' data-tooltip='Top Contributor'>sentiment_very_satisfied</i>";
    } else {
        $top_cont_pin = "";
    }
        echo "<center><img src='$profile_pic' class='profile-picture'></center>";
        echo "<div><h2>$username $admin_pin $top_cont_pin</h2></div>";
    if ($user == $id) {
        echo "<a href='edit_userdata.php?uid=$id' name='edit_userdata' class='button button1'>EDIT USER DATA</a><br><br>";
    } else {
        ?>
        <script>
        $("#follow").click(function() {

            var url = "follow.php"; // the script where you handle the form input.
        
            $.ajax({
                   type: "POST",
                   url: url,
                   data: $("#follow_form").serialize(), // serializes the form's elements.
                   success: function(data)
                   {
                       alert(data); // show response from the php script.
                   }
                 });
        
                 return false; // avoid to execute the actual submit of the form.
        });
        </script>
        <?php
        echo "<form action='' method='post' id='follow_form'>";
        $sql_follow_already = "SELECT * FROM follows WHERE follow_from='$user' AND follow_to='$id'";
        $result_follow_already = mysqli_query($con, $sql_follow_already);
        if(mysqli_num_rows($result_follow_already) > 0) {
            echo "<button type='submit' name='unfollow' class='button button2'>UNFOLLOW</button>&nbsp;";
        } else {
            echo "<button type='submit' name='follow' id='follow' class='button button1'>FOLLOW</button>&nbsp;";
        }
        echo "</form>";
        if(isset($_POST['unfollow'])) {
            mysqli_query($con, "DELETE FROM follows WHERE follow_from='$user' AND follow_to='$id'");
            header("Refresh:0");
        }
        echo "<a href='#reportuser' name='report_user' class='modal-trigger button button3'>REPORT USER</a><br><br>";
    }
    echo "<div class='divider'></div>";
    echo "<h5>Current Karma - $karma</h5>";
}
?>

<div class="row">
<div class="col s12 m6 l6">
<ul class="collapsible expandable">
<li class="active">
<div class="collapsible-header"><i class="medium material-icons">art_track</i>Profile bio</div>
<div class="collapsible-body">
<span>
    <?php
    $sql_profile = "SELECT * FROM users WHERE id=$id";
    $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
    
    $row = mysqli_fetch_assoc($result_profile);
    $profile_bio = $row['profile_bio'];
    if(!empty($profile_bio)) {
        echo "<p class='break-long-words'>\"".$profile_bio."\"</p>";
        echo "Joined: ".date('d.m.Y', $date_joined);
    } else {
        echo "It's quiet here...";
    }
    ?>
</span>
</div>
</li>
<?php
if($user == $id) {
?>
<li>
<div class="collapsible-header"><i class="medium material-icons">book</i>Saved posts</div>
<div class="collapsible-body">
<span>
    <?php
    $sql_read_later = "SELECT * FROM read_later WHERE read_user='$user' ORDER BY read_id DESC";
    $result_read_later = mysqli_query($con, $sql_read_later) or die(mysqli_error($con));
    
    if(mysqli_num_rows($result_read_later) > 0) {
        while($row = mysqli_fetch_assoc($result_read_later)) {
            $read_later_postid = $row['read_postid'];

            $sql_read_later_title = "SELECT * FROM posts WHERE id='$read_later_postid'";
            $result_read_later_title = mysqli_query($con, $sql_read_later_title);
            
            if(mysqli_num_rows($result_read_later_title) > 0) {
                while($row = mysqli_fetch_assoc($result_read_later_title)) {
                    $read_later_title = $row['title'];

                    $read_later_posts = "<div><h6><a href='view_post.php?pid=$read_later_postid'>$read_later_title</a></h6></div>";
                    echo $read_later_posts;
                }
            } 
        }
    } else {
        echo "No saved posts";
    }
    ?>
</span>
</div>
</li>
<?php } ?>
</ul>
</div>
<div class="col s12 m6 l6">
<?php
$sql = "SELECT * FROM posts WHERE author='$username' ORDER BY id DESC";
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$posts = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $content = $row['content'];
        $date = $row['date'];
        $author = $row['author'];

        $posts .= "<div><h6><a href='view_post.php?pid=$id'>$title</a></h6></div>";
    }
    $result_number = mysqli_num_rows($result);
    if ($result_number == 0 || $result_number > 1) {
        echo "<div><h5 class='break-long-words'>Author of $result_number posts<br>$posts</h5></div><br>";
    } else {
        echo "<div><h5 class='break-long-words'>Author of $result_number post<br>$posts</h5></div><br>";
    }
}
?>
</div>
</div>
</div>
</div>
</div>

<?php
if(isset($_POST['report-submit'])) {
    if(isset($_POST['reason'])) {
        $reason = $_POST['reason'];
        $time = time();     
            if(isset($_SESSION['id'])) {
                $user = $_SESSION['id'];
                $sql_report = "INSERT INTO user_reports (userid, user_from, reason, time) VALUES ('$uid', '$user', '$reason', '$time')";
            } else {
                $sql_report = "INSERT INTO user_reports (userid, user_from, reason, time) VALUES ('$uid', '0', '$reason', '$time')";
            }
            mysqli_query($con, $sql_report) or die(mysqli_error($con));
    }
}
?>

<div id="reportuser" class="modal">
    <div class="modal-content">
      <h4>Report User</h4>
        <form action="profile.php?id=<?php echo $uid; ?>" method="post" enctype="multipart/form-data">
        <p>I would like to report this user because...</p>
        <input type='text' name='reason' class='text-input'>
        <button type='submit' name='report-submit' class='button button3'>REPORT</button>
    </form>
    </div>
  </div>
<script>
var elem = document.querySelector('.collapsible.expandable');
var instance = M.Collapsible.init(elem, {
  accordion: false
});

var elem = document.querySelector('.tooltipped');
var instance = M.Tooltip.init(elem, {
  accordion: false
});

var elem = document.querySelector('#reportuser');
var instance = M.Modal.init(elem, {
  accordion: false
});
</script>
</body>
</html>