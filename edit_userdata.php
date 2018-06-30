<?php
    session_start();
    include_once('db.php');

    if(!isset($_SESSION['username'])) {
        header('Location: login.php');
        return;
    }
    if(!isset($_GET['uid'])) {
        header('Location: index.php');
    }

        $uid = $_GET['uid'];

    if(isset($_POST['update_data'])) {
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);

        $username = mysqli_real_escape_string($con, $username);
        $password = mysqli_real_escape_string($con, $password);

        $sql = "UPDATE users SET username='$username', password='$password'' WHERE id=$uid";

        if($username == "" || $password == "") {
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
$sql_get = "SELECT * FROM users WHERE id=$uid LIMIT 1";
$result = mysqli_query($con, $sql_get);

if(mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $password = $row['password'];

        echo "<form action='edit_userdata.php?uid=$uid' method='post' enctype='multipart/form-data'>";
        echo "<input placeholder='Username' name='username' type='text' value='$username' autofocus size='48'><br><br>";
        echo "<input placeholder='Password' name='password' type='password' autofocus size='48'><br><br>";


    }
}
?>
    <input name="update_data" type="submit" value="Update Data">
    </form>
</body>
</html>