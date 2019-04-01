<?php
	require_once 'db.php';
	include_once 'head_links.php';
	
	$bug_id = $_GET['bug_id'];
	
	$sql_close = "UPDATE bug_reports SET status='closed' WHERE bug_id='$bug_id'";
	mysqli_query($con, $sql_close);
?>