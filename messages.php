<style>
body {
    background: white !important;
}
</style>
<?php
require_once 'db.php';
include_once 'head_links.php';
if(isset($_SESSION['id'])) {
    $user = $_SESSION['id'];
    $sql_notify = "SELECT notifytime FROM users WHERE id='$user'";
    $result_notify = mysqli_query($con, $sql_notify);
    $row = mysqli_fetch_assoc($result_notify);
    $notifytime = $row['notifytime'];
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
include 'notifytime.php';
?>