<!DOCTYPE html>
<html>
<head>
    <?php
    require_once 'db.php';
    include 'head_links.php';
    include 'settings.php';
    ?>
</head>
<body>
<div class="container-fluid">
<div class="navbar" id="navbar">
<?php
if(!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['id'])) {
?>
<div class='full'>
<a href='#notifications' id='notify_btn' class='modal-trigger nav-link'>
<?php
        $user = $_SESSION['id'];
        $user_name = $_SESSION['username'];
        $sql_notify = "SELECT notifytime FROM users WHERE id='$user'";
        $result_notify = mysqli_query($con, $sql_notify);
        $row = mysqli_fetch_assoc($result_notify);
        $notifytime = $row['notifytime'];

        $sql_comments = "SELECT * FROM comments WHERE (comment_to='$user') AND (time>$notifytime) AND NOT (comment_from='$user')";
        $result_comments = mysqli_query($con, $sql_comments);
        $sql_mentions = "SELECT * FROM mentions WHERE (username='$user_name') AND (time>$notifytime)";
        $result_mentions = mysqli_query($con, $sql_mentions);
        $sql_messages = "SELECT * FROM messages WHERE (user_to='$user') AND (time>$notifytime)";
        $result_messages = mysqli_query($con, $sql_messages);

        if(mysqli_num_rows($result_comments) > 0 || mysqli_num_rows($result_mentions) > 0 || mysqli_num_rows($result_messages) > 0) {
        ?>
        <i class="orange-custom material-icons">notifications_active</i></a>
        <?php } else { ?>
        <i class="material-icons">notifications</i></a>
        <?php } ?>
        <span id='profile-navbar'><a class='dropdown-trigger nav-link' href='#' data-target='dropdown1'><?php echo $user_name; ?></a></span>
        <ul id='dropdown1' class='dropdown-content'>
        <li><a href='profile?id=<?php echo $user; ?>'>Profile</a></li>
        <li><a href='logout'>Logout</a></li>
        </ul>
        <form action='search.php?<?php echo $searchtxt; ?>'>
        <input type='text' class='text-input' name='searchtxt' placeholder='Search'>
        </form>
</div>
<div class='small'>
<a href='#notifications' id='notify_btn' class='modal-trigger nav-link'>
<?php
        $user = $_SESSION['id'];
        $user_name = $_SESSION['username'];
        $sql_notify = "SELECT notifytime FROM users WHERE id='$user'";
        $result_notify = mysqli_query($con, $sql_notify);
        $row = mysqli_fetch_assoc($result_notify);
        $notifytime = $row['notifytime'];

        $sql_comments = "SELECT * FROM comments WHERE (comment_to='$user') AND (time>$notifytime) AND NOT (comment_from='$user')";
        $result_comments = mysqli_query($con, $sql_comments);
        $sql_mentions = "SELECT * FROM mentions WHERE (username='$user_name') AND (time>$notifytime)";
        $result_mentions = mysqli_query($con, $sql_mentions);
        $sql_admin_msg = "SELECT * FROM admin_msg WHERE (user_to='$user') AND (time>$notifytime)";
        $result_admin_msg = mysqli_query($con, $sql_admin_msg);

        if(mysqli_num_rows($result_comments) > 0 || mysqli_num_rows($result_mentions) > 0 || mysqli_num_rows($result_admin_msg) > 0) {
        ?>
        <i class="orange-custom material-icons">notifications_active</i></a>
        <?php } else { ?>
        <i class="material-icons">notifications</i></a>
        <?php } ?>
        <span id='profile-navbar'><a class='dropdown-trigger nav-link' href='#' data-target='dropdown2'><i class='material-icons'>account_circle</i></a></span>
        <ul id='dropdown2' class='dropdown-content'>
        <li><a href='profile?id=<?php echo $user; ?>'>Profile</a></li>
        <li><a href='logout'>Logout</a></li>
        </ul>
        <a href='search.php' class='menu-icon nav-link'><i class='material-icons'>search</i></a>
</div>
<?php
} else {
    echo "<div class='hide-nav'>
    <a href='register.php' class='register nav-link'>Register</a>
    <a href='login.php' class='login nav-link'>Login</a>
    <a href='register.php' class='menu-icon' onclick='navbarMenu()'><i class='material-icons'>person_add</i></a>
    <a href='login.php' class='menu-icon' onclick='navbarMenu()'><i class='material-icons'>arrow_forward</i></a>
    </div>";
}
?>
</div>
</div>

<div id="notifications" class="modal">
    <div class="modal-content">
      <h4>Notifications</h4>
      <div id='notify_iframe'></div>
    </div>
    <div class="modal-footer">
      <a href="#!" class="modal-close btn-flat">Close</a>
    </div>
  </div>
<script>
var elem = document.querySelector('#notifications');
var instance = M.Modal.init(elem, {
  accordion: false
});
document.getElementById('notify_btn').onclick = function(){
    document.getElementById('notify_iframe').innerHTML = "<iframe src='notifications.php' height='400px' class='notifications-modal'></iframe>";
    };

$('.dropdown-trigger').dropdown({coverTrigger: false});
</script>
</body>
</html>