<?php
include 'db.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css?<?php echo time(); ?>">
    <script src="materialize/js/materialize.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="styles.css?<?php echo time(); ?>" />
    <script src="main.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
<div class="navbar">
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
    echo "<div class='right-align'>";
    echo "<a href='#notifications' class='modal-trigger'>";
        
        $user = $_SESSION['id'];
        $sql_notify = "SELECT notifytime FROM users WHERE id='$user'";
        $result_notify = mysqli_query($con, $sql_notify);
        $row = mysqli_fetch_assoc($result_notify);
        $notifytime = $row['notifytime'];

        $sql_comments = "SELECT * FROM comments WHERE (comment_to='$user') AND (time>$notifytime) AND NOT (comment_from='$user')";
        $result_comments = mysqli_query($con, $sql_comments);

        if(mysqli_num_rows($result_comments) > 0) {
        ?>
        <i class="orange-custom material-icons">notifications_active</i></a>
        <?php
        } else {
        ?>
        <i class="material-icons">notifications</i></a>
        <?php
        }
    echo "<span><a href='profile.php?id=$user'>$user_username</a></span>
    </div>";
} else {
    echo "<div class='right-align'>
    <a href='login.php'>Login</a>&nbsp;
    <a href='register.php'>Register</a>
    </div>";
}
?>
</div>
</div>
<div id="notifications" class="modal">
    <div class="modal-content">
      <h4>Notifications</h4>
      <iframe src="notifications.php" height="400px" class="notifications-modal"></iframe>
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
</script>
</body>
</html>