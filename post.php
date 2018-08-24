<?php
session_start();
include_once 'db.php';
include 'sidebar_new.php';

if (isset($_POST['post'])) {
    $title = strip_tags($_POST['title']);
    $content = strip_tags($_POST['content']);
    $flair = strip_tags($_POST['flair']);

    $title = mysqli_real_escape_string($con, $title);
    $content = mysqli_real_escape_string($con, $content);
    $flair = mysqli_real_escape_string($con, $flair);

    $date = date('l jS \of F Y h:i:s A');
    $author = $_SESSION['username'];

    if(isset($_POST['image'])) {
    //insert image
    $target_dir = "images/";
    $target_upload = basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $target_upload;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["image"]["tmp_name"]);
    if ($check !== false) {
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
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
        && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
        // if everything is ok, try to upload file
    } else {
        move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
    }
        $sql = "INSERT into posts (title, content, date, author, image, flair) VALUES ('$title', '$content', '$date', '$author', '$target_file', '$flair')";
    } else {
        $sql = "INSERT into posts (title, content, date, author, image, flair) VALUES ('$title', '$content', '$date', '$author', 'images/default.png', '$flair')";
    }

    if ($title == "" || $content == "") {
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
    <title>Create Post</title>
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="center-align">
<br><br>
    <form action="post.php" method="post" id="post" enctype="multipart/form-data">
    <input placeholder="Title" name="title" type="text" autofocus size="48" class="text-input" required><br><br>
    <textarea placeholder="Content" id="content" name="content" rows="20" cols="50" class="text-input" required></textarea><br>
</div>
<div class="row">
    <div class="col s3 center-align">
    <button type="button" id="bold" class='button-small button1'><b>B</b></button>
    </div>
    <div class="col s3 center-align">
    <button type="button" id="italic" class='button-small button1'><i>I</i></button>
    </div>
    <div class="col s3 center-align">
    <button type="button" id="underline" class='button-small button1'><u>U</u></button>
    </div>
    <div class="col s3 center-align">
    <button type="button" id="strike" class='button-small button1'><s>S</s></button>
    </div>
</div>
<div class='center-align'>
    <select name="flair" class="select-flair" required>
    <?php
    $sql_flair = "SELECT * FROM flairs";
    $result_flair = mysqli_query($con, $sql_flair) or die(mysqli_error($con));
    if(mysqli_num_rows($result_flair) > 0) {
        while($row = mysqli_fetch_assoc($result_flair)) {
            $flairid = $row['flairid'];
            $flairname = $row['flairname'];

            echo "<option value='$flairname'>$flairname</option>";
        }
    }
    ?>
    </select><br><br>
    <input name="image" type="file" name="post-image" autofocus size="48" class="button button2"><br><br>
      <button type="submit" name="post" class="button button1">POST</button>
    </form><br><br>
    </div>
    </div>
    </div>
    <script>
      document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('select');
    var instances = M.FormSelect.init(elems, options);
  });
    </script>
    <script type="text/javascript">
    $(function () {
        $('#bold').on('click', function () {
            var text = $('#content');
            text.val(text.val() + ' [b][/b]');    
        });
    });
    $(function () {
        $('#italic').on('click', function () {
            var text = $('#content');
            text.val(text.val() + ' [i][/i]');    
        });
    });
    $(function () {
        $('#underline').on('click', function () {
            var text = $('#content');
            text.val(text.val() + ' [u][/u]');    
        });
    });
    $(function () {
        $('#strike').on('click', function () {
            var text = $('#content');
            text.val(text.val() + ' [s][/s]');    
        });
    });
</script>
</body>
</html>