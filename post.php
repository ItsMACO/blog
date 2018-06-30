<?php
    session_start();
    include_once('db.php');

    if(isset($_POST['post'])) {
        $title = strip_tags($_POST['title']);
        $content = strip_tags($_POST['content']);

        $title = mysqli_real_escape_string($con, $title);
        $content = mysqli_real_escape_string($con, $content);
    
        $date = date('l jS \of F Y h:i:s A');

        $sql = "INSERT into posts (title, content, date) VALUES ('$title', '$content', '$date')";

        if($title == "" || $content == "") {
            echo "Please complete your post!";
            return;
        }

        mysqli_query($con, $sql);

        header('Location: index.php');
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog - Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body>
    <form action="post.php" method="post" enctype="multipart/form-data">
    <input placeholder="Title" name="title" type="text" autofocus size="48"><br><br>
    <textarea placeholder="Content" name="content" rows="20" cols="50"></textarea><br>
    <input name="post" type="submit" value="Post">
    </form>
</body>
</html>