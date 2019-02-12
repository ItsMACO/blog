<?php
    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        header('Location: login.php');
    }
?>
<div class='wrap-content'>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <input type="text" name="set_admin" class="text-input" placeholder="Username"><br><br>
            <div class="switch">
                <label>
                No
                <input type="checkbox" name="yes_no">
                <span class="lever"></span>
                Yes
                </label>
            </div><br>
        <button type="submit" class="button button1" id="set_admin_btn">SET</button>
    </form>
</div>
<?php
require_once 'db.php';
if(isset($_POST['set_admin'])){
    $set_admin = strip_tags($_POST['set_admin']);
    $set_admin = mysqli_real_escape_string($con, $set_admin);
    if(isset($_POST['yes_no'])) {
        $sql_set_admin = "UPDATE users SET admin=1 WHERE username='$set_admin'";
        mysqli_query($con, $sql_set_admin);
    } else {
        $sql_set_admin = "UPDATE users SET admin=0 WHERE username='$set_admin'";
        mysqli_query($con, $sql_set_admin);
    }
}
?>