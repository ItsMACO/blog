<?php
session_start();
include_once 'db.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    return;
}
if (!isset($_GET['uid'])) {
    header('Location: index.php');
}

$uid = $_SESSION['id'];

if (isset($_POST['update_data'])) {
    $username = strip_tags($_POST['username']);
    $password = strip_tags($_POST['password']);
    $email = strip_tags($_POST['email']);

    $username = mysqli_real_escape_string($con, $username);
    $password = mysqli_real_escape_string($con, $password);
    $email = mysqli_real_escape_string($con, $email);

    $password = md5($password);

    $sql = "UPDATE users SET username='$username', password='$password', email='$email' WHERE id=$uid";

    if ($username == "" || $password == "" || $email == "") {
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
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css">
</head>
<body style="background: white !important;">
<div class="container-fluid">
<div class="row">
<div class="col s3">
<?php
include 'sidebar.php';
?>
</div>
<div class="col s8"><br><br><br><br>
<?php
$sql_get = "SELECT * FROM users WHERE id=$uid LIMIT 1";
$result = mysqli_query($con, $sql_get);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $username = $row['username'];
        $password = $row['password'];
        $email = $row['email'];

        echo "<form action='edit_userdata.php?uid=$uid' method='post' enctype='multipart/form-data'>";
        echo "<input placeholder='Username' name='username' type='text' value='$username' class='text-input' autofocus size='48'><br><br>";
        echo "<input placeholder='Password' name='password' type='password' class='text-input' autofocus size='48'><br><br>";
        echo "<input placeholder='Email' name='email' type='text' class='text-input' autofocus size='48' value='$email'><br><br>";
    }
}
?>
    <button type="submit" name="update_data" class="button button1"><span>UPDATE DATA</span></button>
    </form><br><br>
    <div class="divider"></div><br>
<?php
//insert image
if (isset($_POST['profile_picture_submit'])) {
    $target_dir = "images/profile/";
    $target_upload = basename($_FILES["profile_picture_upload"]["name"]);
    $target_file = $target_dir . $target_upload;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["profile_picture_upload"]["tmp_name"]);
    if ($check !== false) {
        //echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        echo "File is not an image.";
        $uploadOk = 0;
    }
    // Check file size
    if ($_FILES["profile_picture_upload"]["size"] > 5000000) {
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
        echo "";
        // if everything is ok, try to upload file
    } else {
        move_uploaded_file($_FILES['profile_picture_upload']['tmp_name'], $target_file);
        if ($target_upload == "" || !$target_upload) {
            $sql_image = "UPDATE users SET profile_pic='images/profile/default.png' WHERE id=$uid";
            mysqli_query($con, $sql_image);
        } else {
            $sql_image = "UPDATE users SET profile_pic='$target_file' WHERE id=$uid";
            mysqli_query($con, $sql_image);
        }
    }
}
?>
<form action="edit_userdata.php?uid=<?php echo $uid ?>" method="post" enctype="multipart/form-data">
<input name="profile_picture_upload" type="file" autofocus size="48" class="button button2"><br><br>
<button type="submit" name="profile_picture_submit" class="button button1">UPLOAD IMAGE</button>
</form>
    </div>
    </div>
    </div>
<div class="col s1"></div>
</body>
</html>