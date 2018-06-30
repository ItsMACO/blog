<?php
    session_start();
    include_once('db.php');

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
        return;
    }
    if(!isset($_GET['pid'])) {
        header('Location: index.php');
    }

        $pid = $_GET['pid'];

    if(isset($_POST['update'])) {
        $title = strip_tags($_POST['title']);
        $content = strip_tags($_POST['content']);

        $title = mysqli_real_escape_string($con, $title);
        $content = mysqli_real_escape_string($con, $content);
    
        $date = date('l jS \of F Y h:i:s A');

        $sql = "UPDATE posts SET title='$title', content='$content', date='$date' WHERE id=$pid";

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
    <script src="main.js"></script>
</head>
<body>
<?php
$sql_get = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
$result = mysqli_query($con, $sql_get);

if(mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row['title'];
        $content = $row['content'];

        echo "<form action='edit_post.php?pid=$pid' method='post' enctype='multipart/form-data'>";
        echo "<input placeholder='Title' name='title' type='text' value='$title' autofocus size='48'><br><br>";
        echo "<textarea placeholder='Content' name='content' rows='20' cols='50' class='materialize-textarea'>$content</textarea><br>";


    }
}
?>
    <input name="update" type="submit" value="Update">
    </form>
</body>
</html>