<?php
    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        header('Location: login.php');
    }
?>
<div class='wrap-content'>
<form action="admin.php" method="post" enctype="multipart/form-data">
    <input type="text" name="set_flair" class="text-input" placeholder="Flair name"><br><br>
    <button type="submit" class="button button1">ADD</button>
</form><br>
</div>
<?php
require_once 'db.php';
    if(isset($_POST['set_flair'])) {
        $set_flair = strip_tags($_POST['set_flair']);
        $set_flair = mysqli_real_escape_string($con, $set_flair);
        $sql_flair_exists = "SELECT * FROM flairs WHERE flairname='$set_flair'";
        $result_flair_exists = mysqli_query($con, $sql_flair_exists);
        if(mysqli_num_rows($result_flair_exists) > 0) {
            echo "This flair already exists!";
        } else {
            $sql_flair = "INSERT INTO flairs (flairname) VALUES ('$set_flair')";
            mysqli_query($con, $sql_flair);
        }
    }
?>