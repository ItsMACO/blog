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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/css/materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0-beta/js/materialize.min.js"></script>
    <script src="main.js"></script>
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <div class="col s1"></div>
        <div class="col s9">

<form action="search.php" method="post">
<input type="text" name="searchtxt">
<input type="submit" name="searchbtn" value="Search">
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
    
                $posts .="<div><h2><a href='view_post.php?pid=$id' class='blue-text darken-2'>$title</a></h2><p>$date</p><h6>".substr($output, 0, 360)."...</h6><br><a href='view_post.php?pid=$id' class='btn waves-effect waves-light blue darken-2'>Read more</a><br></div><br><div class='divider'></div>";
            
            }

            if(mysqli_num_rows($result) > 1) {
            echo "<br>Found ".mysqli_num_rows($result)." results.";
            }
            if(mysqli_num_rows($result) == 1) {
                echo "<br>Found ".mysqli_num_rows($result)." result.";
            }
            
            echo $posts;
            
        } else {
            echo "No posts found!";
        }
    }

    ?>
</div>
<div class="col s2 center-align">
</body>
</html>