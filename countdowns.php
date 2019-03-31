<?php
    require_once 'db.php';
    if(!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
        header('Location: login.php');
    }
	if(!isset($_SESSION)) {
		session_start();
	}
?>
<div class='wrap-content'>
    <a href="#help-countdown" class="button-small button2 modal-trigger">HELP?</a><br><br>
    <form action="admin.php" method="post" enctype="multipart/form-data">
        <input type="text" name="event" class='text-input' placeholder="Event name"><br><br>
        <input type="date" name="date" class="text-input"><br><br>
        <input type="time" name="time" class="text-input"><br><br>
        <button type="submit" name="add_countdown" class="button button1">ADD</button>
    </form><br><br>
    <div class='divider'></div><div class='divider'></div><div class='divider'></div><br><br>
        <?php
        include_once 'head_links.php';
        //ADD COUNTDOWN
        if(isset($_POST['add_countdown'])) {
            $event = strtoupper($_POST['event']);
            $date = $_POST['date'];
            $time = $_POST['time'];
            $sql_add_countdown = "INSERT INTO countdowns (event, date, time) VALUES ('$event', '$date', '$time')";
            mysqli_query($con, $sql_add_countdown);
        }
        ?>
    <form action='admin.php' method='post' enctype="multipart/form-data">
        <select name='active_countdown'>
            <?php
            $sql_exist_countdown = "SELECT * FROM countdowns ORDER BY id DESC";
            $result_exist_countdown = mysqli_query($con, $sql_exist_countdown);
            if(mysqli_num_rows($result_exist_countdown) > 0) {
                while($row = mysqli_fetch_assoc($result_exist_countdown)) {
                    $countdown_id = $row['id'];
                    $countdown_event = $row['event'];
                    $countdown_date = $row['date'];
                    $countdown_time = $row['time'];
                    
                    echo "<option value='".$countdown_id."'>$countdown_event ($countdown_date $countdown_time)</option>";
                }
            }
            ?>
        </select><br><br>
        <button type="submit" name="set_active_countdown" class="button button1">SET ACTIVE</button>
        <button type="submit" name="set_all_inactive" class="button button3">SET ALL INACTIVE</button>
    </form>
    <?php
    //SET ACTIVE COUNTDOWN
    if(isset($_POST['set_active_countdown'])) {
        $set_active_event = $_POST['active_countdown'];
        $sql_set_active = "UPDATE countdowns SET active=1 WHERE id='$set_active_event'";
        $sql_set_inactive = "UPDATE countdowns SET active=0 WHERE NOT id='$set_active_event'";
        mysqli_query($con, $sql_set_active);
        mysqli_query($con, $sql_set_inactive);
    }
    //SET ALL INACTIVE
    if(isset($_POST['set_all_inactive'])) {
        $sql_set_all_inactive = "UPDATE countdowns SET active=0";
        mysqli_query($con, $sql_set_all_inactive);
    }
    ?>
</div>