<html>
<head>
<?php
  include_once 'head_links.php';
  if(!$_SESSION) {
    session_start();
  }
  
  $pid = $_GET['pid'];
  $sql = "SELECT * FROM posts WHERE id=$pid LIMIT 1";
  $result = mysqli_query($con, $sql) or die(mysqli_error($con));
  $row = mysqli_fetch_assoc($result) {
  $pagetitle = $row['title'];
  $image = $row['image'];
      }
  }
?>
?>
<title><?php echo $pagetitle; ?></title>
</head>
<body>
<div class='container-fluid'>
  <div class='wrap'>
    <div class='wrap-content'>
    
      <div class='header'>
        <div class='row'>
          <div class='col s12 m6 l4'>
            <img src='<?php echo $image; ?>'>
          </div>
          <div class='col s12 m6 l8'>
            <h3 class='break-long-words screen'><?php echo $pagetitle; ?></h3>
          </div>
      </div>
      
    </div>
  </div>
</div>
</body>
</html>
