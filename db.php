<?php
define('SQL_HOST', 'localhost');
define('SQL_DB', 'blog');
define('SQL_USERNAME', 'root');
define('SQL_PASSWORD', '');

$dsn = 'mysql:dbname='.SQL_DB.';host='.SQL_HOST.'';
$username = SQL_USERNAME;
$password = SQL_PASSWORD;
$con = new PDO($dsn, $username, $password);

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Connection failed: ' . $e->getMessage());
}

if(!isset($_SESSION)) {
    session_start();
}
?>