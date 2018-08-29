<?php
include 'head_links.html';
session_start();
session_destroy();
?>

<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="refresh" content="1;url=index.php" />
    <title>Logging out...</title>
</head>
<body style="background: white !important;">
<div class='center-align' style='position: fixed; top: 40%; left: 50%;'>
    <p>Logging out...</p>
    <div class="preloader-wrapper big active">
    <div class="spinner-layer spinner-blue-only">
      <div class="circle-clipper left">
        <div class="circle"></div>
      </div><div class="gap-patch">
        <div class="circle"></div>
      </div><div class="circle-clipper right">
        <div class="circle"></div>
      </div>
    </div>
  </div>
</div>
</body>
</html>
