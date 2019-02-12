<?php
include 'online_log.php';
include 'db.php';
include 'head_links.html';
?>
<!DOCTYPE html>
<html>
<head>
    <title>Notifications</title>
</head>
<body style="background: #fafafa !important;">
<div class="container-fluid">
    <?php
    $user = $_SESSION['id'];
    $sql_notify = "SELECT notifytime FROM users WHERE id='$user'";
    $result_notify = mysqli_query($con, $sql_notify);
    $row = mysqli_fetch_assoc($result_notify);
    $notifytime = $row['notifytime'];

    $sql_comments = "SELECT * FROM comments WHERE (comment_to='$user') AND NOT (comment_from='$user')";
    $result_comments = mysqli_query($con, $sql_comments);

    if(mysqli_num_rows($result_comments) > 0) {
        while($row = mysqli_fetch_assoc($result_comments)) {
            $comment_id = $row['comment_id'];
            $comment_from = $row['comment_from'];
            $comment_to = $row['comment_to'];
            $postid = $row['postid'];
            $time = $row['time'];
            $comment_content = $row['comment_content'];

            $sql_comment_post = "SELECT * FROM posts WHERE id='$postid'";
            $result_comment_post = mysqli_query($con, $sql_comment_post);
            if(mysqli_num_rows($result_comment_post) > 0) {
                while($row = mysqli_fetch_assoc($result_comment_post)) {
                    $comment_post_id = $row['id'];
                    $comment_post_name = $row['title'];

                    $new_comment = "";
                    if($time>$notifytime) {
                        $new_comment = "<p>New comment: <br></p>";
                    }
                    $notify_comment = "<div style='margin: 25px;'>$new_comment<h6 class='break-long-words'>$comment_from</h6>
                    <h6 class='break-long-words'>$comment_content</h6>
                    <a href='view_post.php?pid=$comment_post_id#$comment_id' class='button-small button1'>GO THERE</a>
                    </div><br><div class='divider'></div>";

                    echo $notify_comment;
                }
            }
        }
    }



    $user_name = $_SESSION['username'];
    $sql_mentions = "SELECT * FROM mentions WHERE (username='$user_name')";
    $result_mentions = mysqli_query($con, $sql_mentions);

    if(mysqli_num_rows($result_mentions) > 0) {
        while($row = mysqli_fetch_assoc($result_mentions)) {
            $mention_id = $row['id'];
            $mention_username = $row['username'];
            $mention_postid = $row['postid'];
            $time = $row['time'];

            $sql_mention_post = "SELECT * FROM posts WHERE id='$mention_postid'";
            $result_mention_post = mysqli_query($con, $sql_mention_post);
            if(mysqli_num_rows($result_mention_post) > 0) {
                while($row = mysqli_fetch_assoc($result_mention_post)) {
                    $mention_post_title = $row['title'];

                    $new_mention = "";
                    if($time>$notifytime) {
                        $new_mention = "<p>New mention: <br></p>";
                    }
                    $notify_mention = "<div style='margin: 25px;'>$new_mention<h6 class='break-long-words'>$mention_post_title</h6>
                    <a href='view_post.php?pid=$mention_postid' class='button-small button1'>GO THERE</a>
                    </div><br><div class='divider'></div>";

                    echo $notify_mention;
                }
            }

            
    }
}

$sql_messages = "SELECT * FROM messages WHERE (user_to='$user')";
$result_messages = mysqli_query($con, $sql_messages);

if(mysqli_num_rows($result_messages) > 0) {
    while($row = mysqli_fetch_assoc($result_messages)) {
        $message_id = $row['id'];
        $message_text = $row['text'];
        $time = $row['time'];

        $new_message = "";
        if($time>$notifytime) {
            $new_message = "<p>New message: <br></p>";
        }

                $messages = "<div class='row'>
                <div class='col s1'><i class='material-icons'>email</i></div>
                $new_message
                <div class='col s11'>
                <h6 class='tiny-text break-long-words'>$message_text</h6>
                </div>
                </div>
                <div class='divider'></div>";

                echo $messages;
    }
}

if(mysqli_num_rows($result_comments) < 1 && mysqli_num_rows($result_mentions) < 1 && mysqli_num_rows($result_messages) < 1) {
    echo "<br>You have no new notifications!<br><br>";
}
?>
</div>

<?php
include 'notifytime.php';
?>
</body>
</html>