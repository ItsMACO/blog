<?php
require_once 'db.php';
include 'sidebar_new.php';
if (!isset($_SESSION)) {
    session_start();
}
if(isset($_SESSION['id'])) {
	$user = $_SESSION['id'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Blog</title>
</head>
<body>
<div class="container-fluid">
<div class="wrap">
<div class="wrap-content">
<?php
include_once 'countdown.php';
?>
<script>
// Set the date we're counting down to
var countDownDate = new Date("<?php echo $date." ".$time; ?>").getTime();

// Update the count down every 0.1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display
  document.getElementById("countdown").innerHTML = "<b>" + days + "</b>d <b>" + hours + "</b>h <b>"
  + minutes + "</b>m <b>" + seconds + "</b>s ";

  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("countdown").innerHTML = "IT'S HERE";
  }
}, 100);
</script>
<?php
require_once 'nbbc.php';
$bbcode = new BBCode;

if(!isset($_GET['order']) || $_GET['order'] == "new") {
    $sql = "SELECT * FROM posts ORDER BY id DESC";
    echo "<a href='?order=top' class='button-small button2'>ORDER BY TOP POSTS</a><br><br><div class='divider'></div>";
} else {
    $sql = "SELECT * FROM posts ORDER BY likes DESC";
    echo "<a href='?order=new' class='button-small button2'>ORDER BY NEW POSTS</a><br><br><div class='divider'></div>";
}
$result = mysqli_query($con, $sql) or die(mysqli_error($con));

$posts = "";

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $id = $row['id'];
        $title = $row['title'];
        $content = html_entity_decode($row['content']);
        $date = $row['date'];
		$date = date('d.m.Y h:i', $date);
        $author = $row['author'];
        $image = $row['image'];
        $flair = $row['flair'];
		
		$sql_flair = "SELECT flairname FROM flairs WHERE flairid='$flair'";
		$result_flair = mysqli_query($con, $sql_flair);
		if(mysqli_num_rows($result_flair) > 0) {
			while ($row = mysqli_fetch_assoc($result_flair)) {
                $flair = $row['flairname'];
            }
		}

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

        $posts .= "<div class='row'>
            <div class='col s12 m8 l8'>
            <h3 class='break-long-words'><a href='view_post.php?pid=$id'>$title</a></h3><h6 class='flair'>$flair</h6>
            <p>$date by <a href='profile.php?id=$userid'>$author</a></p>
            <h6 class='break-long-words'>" . substr($output, 0, 140) . "...</h6><br>
            <a href='view_post.php?pid=$id' class='button button1'>READ MORE</a>
            <a href='?read_later=$id' class='button button2'>READ LATER</a>
            </div>
            <div class='col s12 m4 l4'><br><br><img src='$image' class='post-image'></div><br><br>
            </div><br>";
    }
    echo $posts;
    if(isset($_GET['read_later'])) {
        header('Refresh:0');
        if(!isset($_SESSION['id'])) {
            header('Location: login.php?location='.urlencode($_SERVER['REQUEST_URI']));
        } else {
            $read_postid = $_GET['read_later'];
            $read_later_exists = mysqli_query($con, "SELECT * FROM read_later WHERE (read_user='$user') AND (read_postid='$read_postid')");
            if(mysqli_num_rows($read_later_exists) > 0) {
                echo "You've already saved this post.";
            } else {
                $sql_read_later = "INSERT INTO read_later (read_user, read_postid) VALUES ('$user', '$read_postid')";
                mysqli_query($con, $sql_read_later);
            }
        }
    }

} else {
    echo "There are no posts to display!";
}
?>
<!--DIV CONTAINER FLUID -->
</div>
<!--DIV WRAP -->
</div>
</div>
</body>
</html>