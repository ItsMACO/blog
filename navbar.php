<!DOCTYPE html>
<html>
<head>
    <?php
    require_once 'db.php';
    include 'head_links.php';
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

        if(mysqli_num_rows($result_comments) > 0 || mysqli_num_rows($result_mentions) > 0) {
        ?>
        <i class="orange-custom material-icons">notifications_active</i></a>
        <?php } else { ?>
        <i class="material-icons">notifications</i></a>
        <?php } ?>
        <a href='#messages' id='msg_btn' class='modal-trigger nav-link'><i class='material-icons'>message</i></a>
        
        <span id='profile-navbar'><a class='dropdown-trigger nav-link' href='#' data-target='dropdown1'><?php echo $user_name; ?></a></span>
        <ul id='dropdown1' class='dropdown-content'>
        <li><a href='profile?id=<?php echo $user; ?>'>Profile</a></li>
        <li><a href='logout'>Logout</a></li>
        </ul>
        <form action='search.php?<?php 
		if(isset($searchtxt)) {
			echo $searchtxt; 
		}
		?>'>
        <input type='text' class='text-input' name='searchtxt' placeholder='Search'>
        </form>
		<?php
		if(isset($_SESSION['banned'])) {
			if($_SESSION['banned'] == 1) {
				echo "<a href='#banned_modal' id='banned_btn' class='modal-trigger nav-link'>
					<i class='material-icons red-text'>error</i>
				</a>";
			}
		}
		?>
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

        if(mysqli_num_rows($result_comments) > 0 || mysqli_num_rows($result_mentions) > 0) {
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
?>
    <div class='hide-nav'>
    <a href="register.php?location=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class='register nav-link'>Register</a>
    <a href="login.php?location=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class='login nav-link'>Login</a>
    <a href="register.php?location=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class='menu-icon' onclick='navbarMenu()'><i class='material-icons'>person_add</i></a>
    <a href="login.php?location=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" class='menu-icon' onclick='navbarMenu()'><i class='material-icons'>arrow_forward</i></a>
    </div>
<?php
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
    
<div id="banned_modal" class="modal">
  <div class="modal-content">
    <h4>You have been banned</h4>
      <h5>You have been banned and can't create new posts or comment on posts. Your ban expires: </h5>
      <!--TODO banned until time -->
  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-close btn-flat">Close</a>
  </div>
</div>  

<div id="messages" class="modal">
  <div class="modal-content">
    <h4>Messages</h4>
    <div id='messages'></div>
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
var elem = document.querySelector('#banned_modal');
var instance = M.Modal.init(elem, {
  accordion: false
});
var elem = document.querySelector('#messages');
var instance = M.Modal.init(elem, {
  accordion: false
});
document.getElementById('notify_btn').onclick = function(){
  document.getElementById('notify_iframe').innerHTML = "<iframe src='notifications.php' height='400px' class='notifications-modal'></iframe>";
};
document.getElementById('msg_btn').onclick = function(){
  document.getElementById('messages').innerHTML = "<iframe src='messages.php' height='400px' class='notifications-modal'></iframe>";
};


$('.dropdown-trigger').dropdown({coverTrigger: false});
</script>
</body>
</html>
