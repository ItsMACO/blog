<?php
require_once 'db.php';
$sql_countdown = $pdo->prepare("SELECT * FROM countdowns WHERE active=1 LIMIT 1");
$sql_countdown->execute();
$result_countdown = $sql_countdown->fetch(PDO::FETCH_ASSOC);
if($result_countdown) {
    $event = $result_countdown['event'];
    $date = $result_countdown['date'];
    $time = $result_countdown['time'];
    echo "<center><div class='countdown-wrap'>";
    echo "<div class='countdown'>";
    echo "<h5><b>".$event."</b></h5>";
    echo "<h5 id='countdown'></h5>";
    echo "<br></div></div>";
    echo "</center>";
    echo "<br>";
}
?>