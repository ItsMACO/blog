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
  if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $date = $row['date'];
        $content = $row['content'];
        $author = $row['author'];
        $image = $row['image'];
        $flair = $row['flair'];
      
      if(is_int($author)) {
          $sql_profile = "SELECT * FROM users WHERE username='$author'";
          $result_profile = mysqli_query($con, $sql_profile) or die(mysqli_error($con));
          if (mysqli_num_rows($result_profile) > 0) {
              while ($row = mysqli_fetch_assoc($result_profile)) {
                  $userid = $row['id'];
                  $username = $row['username'];
                  $email = $row['email'];
                } 
            }
          $output = $bbcode->Parse($content);
          if(isset($_SESSION['username']) && $_SESSION['username'] == $author) {
          $edit_delete = "<div>
              <a href='#stats' class='button button1 modal-trigger'>STATS</a>
              <a href='edit_post.php?pid=$pid' class='button button2'>EDIT</a>&nbsp;
              <a href='del_post.php?pid=$pid' class='button button3'>DELETE</a>
              </div>";
          } else {
              $edit_delete = "<div>";
          }
        }
    }
}
require_once 'nbbc.php';
$bbcode = new BBCode;
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
