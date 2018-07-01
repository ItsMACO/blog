<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>
<body>
<?php
    include_once('db.php');
    $sql_profile = "SELECT * FROM users ORDER BY id DESC";
    $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error());

    if (mysqli_num_rows($result_profile) > 0) {
        while ($row = mysqli_fetch_assoc($result_profile)) {
            $userid = $row['id'];
            $username = $row['username'];
            $email = $row['email'];
        }
    }
?>
<ul id="slide-out" class="sidenav sidenav-fixed">
    <li><div class="user-view grey darken-2">
      <a href="#name">
      <span class="white-text name">
        <?php 
            if (isset($_SESSION['id'])) {
                echo "Welcome ".$_SESSION['username']."!";
            }
        ?>
      </span>
      </a>
      <span class="white-text email"></span>
    </div></li>
    <?php
    if (isset($_SESSION['id'])) {
        $uid = $_SESSION['id'];
      echo "<li><a href='index.php'><i class='small material-icons'>home</i>Home</a></li>";
      echo "<li class='blue darken-2'><a href='post.php' class='white-text'><i class='small material-icons'>add</i>New Post</a></li>";
      echo "<li><a href='search.php'><i class='small material-icons'>search</i>Search</a></li>";
      echo "<li><a href='edit_userdata?uid=$uid'><i class='small material-icons'>account_box</i>Edit User Data</a></li>";
      echo "<li><a href='admin.php'><i class='small material-icons'>adb</i>Admin</a></li>";
      echo "<li class='red darken-2'><a href='logout.php' class='white-text'><i class='small material-icons'>cancel</i>Logout</a></li>";
    } else {
        echo "<li><a href='login.php'><i class='small material-icons'>arrow_forward</i>Login</a></li>";
        echo "<li><a href='register.php'><i class='small material-icons'>add_circle_outline</i>Register</a></li>";
        echo "<li><a href='search.php'><i class='small material-icons'>search</i>Search</a></li>";
    }
    ?>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
</body>
</html>