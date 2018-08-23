<?php
session_start();
include_once 'db.php';
include 'sidebar_new.php';

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    return;
}
if (!isset($_GET['uid'])) {
    header('Location: index.php');
}

$user = $_SESSION['id'];

if (isset($_POST['update_data'])) {
    $password = strip_tags($_POST['password']);
    $confirm_password = strip_tags($_POST['confirm_password']);
    $email = strip_tags($_POST['email']);
    $profile_bio = strip_tags($_POST['profile_bio']);

    $password = mysqli_real_escape_string($con, $password);
    $confirm_password = mysqli_real_escape_string($con, $confirm_password);
    $email = mysqli_real_escape_string($con, $email);
    $profile_bio = mysqli_real_escape_string($con, $profile_bio);

    if ($password == "" || $confirm_password == "" || $email == "") {
        echo "Please fill in your data!";
        return;
    }
    if($password != $confirm_password) {
        echo "Passwords do not match!";
        return;
    }
    
    $password = password_hash($password, PASSWORD_BCRYPT);
    $sql = "UPDATE users SET password='$password', email='$email', profile_bio='$profile_bio' WHERE id=$user";
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
    <link rel="stylesheet" href="styles.css?<?php echo time(); ?>">
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="center-align"><br><br>
<?php
$sql_get = "SELECT * FROM users WHERE id=$user LIMIT 1";
$result = mysqli_query($con, $sql_get);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $email = $row['email'];
        $profile_bio = $row['profile_bio'];

        echo "<form action='edit_userdata.php?uid=$user' method='post' enctype='multipart/form-data'>";
        echo "<input placeholder='Password' name='password' type='password' class='text-input' autofocus size='48' required><br><br>";
        echo "<input placeholder='Confirm Password' name='confirm_password' type='password' class='text-input' autofocus size='48' required><br><br>";
        echo "<input placeholder='Email' name='email' type='text' class='text-input' autofocus size='48' value='$email' required><br><br>";
        echo "<textarea placeholder='Profile Bio' name='profile_bio' class='text-input' autofocus required>$profile_bio</textarea><br><br>";
    }
}
?>
    <button type="submit" name="update_data" class="button button1"><span>UPDATE DATA</span></button>
    </form><br><br>
    <div class="divider"></div><br>
<?php
//insert profile image
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
            $sql_image = "UPDATE users SET profile_pic='images/profile/default.png' WHERE id=$user";
            mysqli_query($con, $sql_image);
        } else {
            $sql_image = "UPDATE users SET profile_pic='$target_file' WHERE id=$user";
            mysqli_query($con, $sql_image);
        }
    }
}
?>
<form action="edit_userdata.php?uid=<?php echo $user; ?>" method="post" enctype="multipart/form-data">
<input name="profile_picture_upload" type="file" autofocus size="48" class="button button2"><br><br>
<button type="submit" name="profile_picture_submit" class="button button1">UPLOAD PROFILE IMAGE</button>
</form><br><br>
    </div>
    </div>
    </div>
</body>
</html>