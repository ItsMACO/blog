<?php
    session_start();
    include_once('db.php');

    if(isset($_POST['post'])) {
        $title = strip_tags($_POST['title']);
        $content = strip_tags($_POST['content']);

        $title = mysqli_real_escape_string($con, $title);
        $content = mysqli_real_escape_string($con, $content);
    
        $date = date('l jS \of F Y h:i:s A');
        $author = $_SESSION['username'];

        $sql = "INSERT into posts (title, content, date, author) VALUES ('$title', '$content', '$date', '$author')";

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
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <script src="materialize/js/materialize.js"></script>
    <link rel="stylesheet" type="text/css" media="screen" href="main.css" />
    <script src="main.js"></script>
</head>
<body style="background: white !important;">
<div class="container-fluid">
<div class="row">
<div class="col s3">
<?php
include('sidebar.php');
?>
</div>
<div class="col s8">
<br><br><br><br>
    <form action="post.php" method="post" enctype="multipart/form-data">
    <input placeholder="Title" name="title" type="text" autofocus size="48"><br><br>
    <textarea placeholder="Content" name="content" rows="20" cols="50" class="materialize-textarea"></textarea><br>
    <div class="button login">
      <button type="submit" name="post"><span>POST</span></button>
    </div>
    </form>
    </div>
    </div>
    </div>
    <div class="col s1"></div>
</body>
</html>