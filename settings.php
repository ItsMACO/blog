<?php
require 'db.php';
$sql_settings = "SELECT * FROM settings";
$result_settings = mysqli_query($con, $sql_settings) or die(mysqli_error($con));

while($row = mysqli_fetch_assoc($result_settings)) {
    $property = $row['property'];
    $value = $row['value'];
}
?>