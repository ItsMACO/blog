<?php
	require_once 'db.php';
	include_once 'head_links.php';
	$config = include 'config.php';
	
?>
<html>
<head>
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="wrap-content">
<br><br>
<form action="global_settings.php" method="post">
	<div class="switch">
		<label>
		Disabled
		<input type="checkbox" name="tf1">
		<span class="lever"></span>
		Enabled
		</label>
	</div><br>
<?php
	if(isset($POST['submit'])) {
		if(isset($_POST['tf1'])) {
			$config['reward_karma']['bug_report'] += 100;
		}
	}
?>
<button type="submit" name="submit" class="button button1">SUBMIT</button>
<p><?php echo $config['reward_karma']['bug_report']; ?></p>
</form><br><br>
</div>
</div>
</div>
</body>
</html>