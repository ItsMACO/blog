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
    <form action="admin_new.php" method="post" enctype="multipart/form-data">
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
            $sql_add_countdown = $pdo->prepare("INSERT INTO countdowns (event, date, time) VALUES (?, ?, ?)");
			$result_add_countdown = $sql_add_countdown->execute([$event, $date, $time]);
        }
        ?>
    <form action='admin_new.php' method='post' enctype="multipart/form-data">
        <select name='active_countdown'>
            <?php
            $sql_exist_countdown = $pdo->prepare("SELECT * FROM countdowns ORDER BY id DESC");
			$sql_exist_countdown->execute();
            $result_exist_countdown = $sql_exist_countdown->fetchAll();
            if($result_exist_countdown) {
                foreach($result_exist_countdown as $row) {
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
<div id="help-countdown" class="modal">
    <div class="modal-content">
        <h4>Countdown Help</h4>
        <p>To create a new countdown, insert an Event name into the input field, then set the date and time you want to count down to and click ADD.</p>
        <p>To display a countdown on the front page, scroll down a little bit and choose an event from the dropdown menu, then click SET ACTIVE.</p>
    </div>
    <div class="modal-footer">
        <a href="#!" class="modal-close btn-flat">Close</a>
    </div>
</div>
<script>
$(document).ready(function(){
    $('#help-countdown').modal();
  });
</script>