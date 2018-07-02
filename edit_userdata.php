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

    $uid = $_SESSION['id'];

    if(isset($_POST['update_data'])) {
        $username = strip_tags($_POST['username']);
        $password = strip_tags($_POST['password']);
        $email = strip_tags($_POST['email']);

        $username = mysqli_real_escape_string($con, $username);
        $password = mysqli_real_escape_string($con, $password);
        $email = mysqli_real_escape_string($con, $email);

        $password = md5($password);

        $sql = "UPDATE users SET username='$username', password='$password', email='$email' WHERE id=$uid";

        if($username == "" || $password == "" || $email == "") {
            echo "Please fill in your data!";
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
    <script src="main.js"></script>
    <link rel="stylesheet" href="main.css">
</head>
<body style="background: white !important;">
<div class="container-fluid">
<div class="row">
<div class="col s3">
<?php
include('sidebar.php');
?>
</div>
<div class="col s8"><br><br><br><br>
<?php
$sql_get = "SELECT * FROM users WHERE id=$uid LIMIT 1";
$result = mysqli_query($con, $sql_get);

if(mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $password = $row['password'];
        $email = $row['email'];

        echo "<form action='edit_userdata.php?uid=$uid' method='post' enctype='multipart/form-data'>";
        echo "<input placeholder='Username' name='username' type='text' value='$username' autofocus size='48'><br><br>";
        echo "<input placeholder='Password' name='password' type='password' autofocus size='48'><br><br>";
        echo "<input placeholder='Email' name='email' type='text' value='$email'><br><br>";


    }
}
?>
<div class="button login">
      <button type="submit" name="update_data"><span>UPDATE DATA</span></button>
   </div>
    </form>
    </div>
    </div>
    </div>
<div class="col s1"></div>
</body>
</html>