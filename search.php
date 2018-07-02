<?php
session_start();
require_once('db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Search</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="materialize/css/materialize.min.css">
    <script src="materialize/js/materialize.js"></script>
    <script src="main.js"></script>
    <link rel="stylesheet" href="styles.css"></link>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col s3">
        <?php
        include('sidebar.php');
        ?>
        </div>
        <div class="col s8">
<br><br><br><br>
<form action="search.php" method="post">
<input type="text" name="searchtxt">
      <button type="submit" class="button button2" name="searchbtn"><span>SEARCH</span></button>
</form>


    <?php
    require_once('nbbc/nbbc.php');

    $bbcode = new BBCode;

    if(isset($_POST['searchtxt'])) {
        $searchtxt = $_POST['searchtxt'];
    }

    if(isset($_POST['searchbtn'])) {
        $sql = "SELECT * FROM posts WHERE (title LIKE '%$searchtxt%') OR (content LIKE '%$searchtxt%') ORDER BY id DESC";
        $result = mysqli_query($con, $sql) or die(mysqli_error());
    
        $posts = "";
    
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $title = $row['title'];
                $content = $row['content'];
                $date = $row['date'];
                
                if (isset($_SESSION['id'])) {
                }
                $output = $bbcode->Parse($content);
    
                $posts .="<br><div><h2><a href='view_post.php?pid=$id' class='blue-text darken-2'>$title</a></h2><p>$date</p><h6>".substr($output, 0, 360)."...</h6><br><a href='view_post.php?pid=$id' class='btn waves-effect waves-light blue darken-2'>Read more</a><br></div><br><div class='divider'></div>";
            
            }

            if(mysqli_num_rows($result) > 1) {
            echo "<br><br><br><br><br><br><br><br>Found ".mysqli_num_rows($result)." results.";
            }
            if(mysqli_num_rows($result) == 1) {
                echo "<br><br><br><br><br><br><br><br>Found ".mysqli_num_rows($result)." result.";
            }
            
            echo $posts;
            
        } else {
            echo "<br><br><br><br><br><br><br><br>No posts found!";
        }
    }

    ?>
</div>
<div class="col s1">
</body>
</html>