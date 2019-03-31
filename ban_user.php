<?php
    require_once 'db.php';
    if(isset($_GET['ban_name'])) {
    $ban_name = $_GET['ban_name'];
    }
    if(isset($_POST['ban_confirm'])) {
        $ban_username = $_POST['ban_username'];
        $ban_time = time() + $_POST['ban_time'] * 86400;
        $reason = $_POST['ban_reason'];
        $sql_punish = "INSERT INTO bans (ban_to, ban_until, reason) VALUES ('$ban_username', '$ban_time', '$reason')";
        mysqli_query($con, $sql_punish);
    }
    ?>
    <form action='admin.php' method='post' enctype='multipart/form-data'>
    <input type='text' name='ban_username' class='text-input' placeholder='Username' value=<?php if(isset($_GET['ban_name'])) {echo "'".$ban_name."'";} 
    ?>><br><br>
    <input type='number' name='ban_time' class='text-input' value='1' required><p style='display: inline-block;'>&nbsp;day(s).</p><br><br>
    <input type='text' name='ban_reason' placeholder='Reason' class='text-input' required><br><br>
    <button type='submit' name='ban_confirm' class='button button3'>CONFIRM</button>
    </form>