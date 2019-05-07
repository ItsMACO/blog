<?php
if (!isset($_SESSION)) {
    session_start();
}
require_once 'db.php';
if (isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
    $time = time();
	$update = $pdo->prepare("UPDATE users SET last_online=? WHERE id=?");
    $update->execute([$time, $user]);
}
