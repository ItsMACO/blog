<?php
require_once 'db.php';
$sql_countdown = "SELECT * FROM countdowns WHERE active=1 LIMIT 1";
$result_countdown = mysqli_query($con, $sql_countdown);
if(mysqli_num_rows($result_countdown) > 0) {
    $row = mysqli_fetch_assoc($result_countdown);
    $event = $row['event'];
    $date = $row['date'];
    $time = $row['time'];
    echo "<center><div class='countdown-wrap'>";
    echo "<div class='countdown'>";
    echo "<h5><b>".$event."</b></h5>";
    echo "<h5 id='countdown'></h5>";
    echo "<br></div></div>";
    echo "</center>";
    echo "<br>";
}
?>