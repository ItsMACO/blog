<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
</head>
<body>
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
      <li><a href="post.php">New Post</a></li>
      <li><a href="search.php">Search</a></li>
      <li><a href="edit_userdata.php">Edit User Data</a></li>
      <li><a href="admin.php">Admin</a></li>
      <li><a href="logout.php">Logout</a></li>
    </ul>
    <a href="#" data-target="slide-out" class="sidenav-trigger"><i class="material-icons">menu</i></a>
</body>
</html>