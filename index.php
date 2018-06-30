<?php
session_start();
require_once('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col s1"></div>
        <div class="col s9">
    <?php
    
    require_once('nbbc/nbbc.php');

    $bbcode = new BBCode;

    $sql = "SELECT * FROM posts ORDER BY id DESC";
    $result = mysqli_query($con, $sql) or die(mysqli_error());

    $posts = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $id = $row['id'];
            $title = $row['title'];
            $content = $row['content'];
            $date = $row['date'];
            
            if (isset($_SESSION['id'])) {
            }
            $output = $bbcode->Parse($content);

            $posts .="<div><h2><a href='view_post.php?pid=$id'>$title</a></h2><p>$date</p><h6>$output</h6><br><a href='view_post.php?pid=$id' class='btn waves-effect waves-light blue darken-2'>Read more</a><br></div><br><div class='divider'></div>";
        
        }
        
        echo $posts;
        
    } else {
        echo "There are no posts to display!";
    }
    ?>

</div>
<div class="col s2 center-align">
<br>
<?php

if (!isset($_SESSION['id'])) {
    echo "<br><br><a href='login.php' class='btn waves-effect waves-light blue darken-2'>Login</a>";
}
if (isset($_SESSION['id'])) {
        echo "<br><br><a href='edit_userdata.php?uid=$uid' class='btn waves-effect waves-light yellow darken-2'>Edit User Data</a>";
        echo "<br><br><a href='admin.php' class='btn waves-effect waves-light yellow darken-2'>Admin</a><br><br>";
        echo "<a href='logout.php' class='btn waves-effect waves-light red darken-2'>Logout</a>";
}
?>
</div>
<!--DIV ROW -->
</div>
<!--DIV CONTAINER FLUID -->
</div>
</body>
</html>