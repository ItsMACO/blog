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

        //insert image
        
        $target_dir = "images/";
        $target_upload = basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $target_upload;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
            $check = getimagesize($_FILES["image"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $uploadOk = 1;
            } else {
                echo "File is not an image.";
                $uploadOk = 0;
            }

        // Check if file already exists
        if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
        }
        // Check file size
        if ($_FILES["image"]["size"] > 5000000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }
        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
        } else {
                move_uploaded_file( $_FILES['image']['tmp_name'], $target_file);
        }
        if($target_upload == "" || !$target_upload) {
        $sql = "INSERT into posts (title, content, date, author, image) VALUES ('$title', '$content', '$date', '$author', 'images/default.png')";
        } else {
        $sql = "INSERT into posts (title, content, date, author, image) VALUES ('$title', '$content', '$date', '$author', '$target_file')";
        }

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
    <input name="image" type="file" autofocus size="48"><br>
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