<?php
    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        header('Location: login.php');
    }
	if(!isset($_SESSION)) {
		session_start();
	}
?>
<div class='wrap-content'>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <input type="text" name="set_karma_username" class="text-input" placeholder="Username" <?php if(isset($_GET['set_karma'])) { ?> value="<?php echo $_GET['set_karma']; ?>"<?php } ?>><br><br>
        <input type="text" name="set_karma" class="text-input" placeholder="Karma Amount"><br><br>
            <div class="switch">
                <label>
                Remove
                <input type="checkbox" name="yes_no2" <?php if(isset($_GET['set_karma'])) { ?> checked <?php } ?>>
                <span class="lever"></span>
                Add
                </label>
            </div><br>
        <button type="submit" class="button button1">SET</button>
    </form>
</div>
<?php
require_once 'db.php';
if(isset($_POST['set_karma_username']) && isset($_POST['set_karma'])){
    $set_karma_username = strip_tags($_POST['set_karma_username']);
    $set_karma_username = mysqli_real_escape_string($con, $set_karma_username);
    $set_karma = strip_tags($_POST['set_karma']);
    $set_karma = mysqli_real_escape_string($con, $set_karma);
    if(isset($_POST['yes_no2'])) {
        $sql_set_karma = "UPDATE users SET karma = karma + $set_karma WHERE username='$set_karma_username'";
        mysqli_query($con, $sql_set_karma);
    } else {
        $sql_set_karma = "UPDATE users SET karma = karma - $set_karma WHERE username='$set_karma_username'";
        mysqli_query($con, $sql_set_karma);
    }
}
?>