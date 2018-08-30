<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <?php
    include 'head_links.html';
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
    $user = $_SESSION['id'];
    $sql_username = "SELECT * FROM users WHERE id='$user'";
    $result_username = mysqli_query($con, $sql_username);
    $row = mysqli_fetch_assoc($result_username);
    $user_username = $row['username'];
    echo "<div>";
    echo "<a href='#notifications' id='notify_btn' class='modal-trigger always-visible'>";
        
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
        <?php
        } else {
        ?>
        <i class="material-icons">notifications</i></a>
        <?php
        }
    echo "<span><a href='profile.php?id=$user'>$user_username</a></span>
    <span><a href='profile.php?id=$user' class='menu-icon'><i class='material-icons'>account_circle</i></a></span>
    </div>";
} else {
    echo "<div class='hide-nav'>
    <a href='register.php' class='register'>Register</a>
    <a href='login.php' class='login'>Login</a>
    <a href='register.php' class='menu-icon' onclick='navbarMenu()'><i class='material-icons'>person_add</i></a>
    <a href='login.php' class='menu-icon' onclick='navbarMenu()'><i class='material-icons'>arrow_forward</i></a>
    </div>";
}
?>

<form action='search.php?<?php echo $searchtxt; ?>'>
<input type='text' class='text-input' name='searchtxt' placeholder='Search'>
</form>
<a href='search.php' class='menu-icon'><i class='material-icons'>search</i></a>
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
</script>
</body>
</html>