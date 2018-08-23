<?php
    session_start();
    require 'db.php';
    require 'sidebar_new.php';
    $pid = $_GET['pid'];

    $sql_get = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
    $result = mysqli_query($con, $sql_get);

    if(mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $author = $row['author'];

            if($_SESSION['admin'] == 0 && $author != $_SESSION['username']) {
                header('Location: index.php');
            }
        }
    }

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
        return;
    }
    if(!isset($_GET['pid'])) {
        header('Location: index.php');
    }


    if(isset($_POST['update'])) {
        $title = strip_tags($_POST['title']);
        $content = strip_tags($_POST['content']);
        $flair = strip_tags($_POST['flair']);

        $title = mysqli_real_escape_string($con, $title);
        $content = mysqli_real_escape_string($con, $content);
        $flair = strip_tags($_POST['flair']);
    
        $date = date('l jS \of F Y h:i:s A');

        $sql = "UPDATE posts SET title='$title', content='$content', date='$date', flair='$flair' WHERE id=$pid";

        if($title == "" || $content == "") {
            echo "Please complete your post!";
            return;
        }

        mysqli_query($con, $sql);
        header('Location: view_post.php?pid='.$pid);
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Blog - Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.css?<?php echo time(); ?>">
    <script src="materialize/js/materialize.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>">
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="center-align">
<br><br><br><br>
<?php
$sql_get = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
$result = mysqli_query($con, $sql_get);

if(mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $content = $row['content'];

        echo "<form action='edit_post.php?pid=$pid' method='post' enctype='multipart/form-data'>";
        echo "<input placeholder='Title' name='title' type='text' value='$title' autofocus size='48' class='text-input'><br><br>";
        echo "<textarea placeholder='Content' name='content' rows='20' cols='50' class='text-input'>$content</textarea><br><br>";
        echo "<select name='flair' class='select-flair' required>";
        $sql_flair = "SELECT * FROM flairs";
        $result_flair = mysqli_query($con, $sql_flair) or die(mysqli_error($con));
        if(mysqli_num_rows($result_flair) > 0) {
            while($row = mysqli_fetch_assoc($result_flair)) {
                $flairid = $row['flairid'];
                $flairname = $row['flairname'];

                echo "<option value='$flairname'>$flairname</option>";
            }
        }
        echo "</select><br><br>";
        }
}
?>
      <button type="submit" name="update" class="button button1">UPDATE</button>
    </form><br><br>
    </div>
    </div>
    </div>
</body>
</html>