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
    $sql_msgtime = "SELECT msgtime FROM users WHERE id='$user'";
    $result_msgtime = mysqli_query($con, $sql_msgtime);
    $row = mysqli_fetch_assoc($result_msgtime);
    $msgtime = $row['msgtime'];
}
$sql_messages = "SELECT * FROM messages WHERE (user_to='$user') ORDER BY id DESC";
$result_messages = mysqli_query($con, $sql_messages);

if(mysqli_num_rows($result_messages) > 0) {
    while($row = mysqli_fetch_assoc($result_messages)) {
        $message_id = $row['id'];
        $message_from_id = $row['user_from'];
        $message_text = $row['text'];
        $time = $row['time'];

        $sql_message_from = "SELECT username FROM users WHERE id='$message_from_id'";
        $result_message_from = mysqli_query($con, $sql_message_from);
        $row = mysqli_fetch_assoc($result_message_from);
        $message_from = $row['username']; 

        $new_message = "";
        if($time>$msgtime) {
            $new_message = "<p><i>New message:</i></p>";
        }
		$time = date('d.m.Y h:i:s', $time);

                $messages = "<div class='row'>
                <div class='col s12'>
                $new_message
                <h6 class='break-long-words'><b>$message_from</b> says:</h6>
                <h6 class='tiny-text break-long-words'>$message_text</h6>
                <h6 class='tiny-text break-long-words'><i>$time</i></h6>
                <script>
                    $(document).ready(function() {
                        $('#reply').submit(function(e) {
                            e.preventDefault();
                            $.ajax( {
                                url: 'new_message.php',
                                method: 'post',
                                data: $('form').serialize(),
                                dataType: 'text',
                                success: function(strMessage) {
                                    $('#reply_btn').text('SENT');
                                    $('#reply')[0].reset();
                                }
                            });
                        });
                    });
                </script>
                <form action='' id='reply' method='post'>
                    <input type='text' name='reply_text' placeholder='Reply...'>
                    <button id='reply_btn' type='submit'>REPLY</button>
                </form>
                </div>
                </div>
                <div class='divider'></div>";

                echo $messages;
                if(isset($_POST['reply_btn'])) {
                    $_SESSION['message_from_id'] = $message_from_id;
                }
    }
}
include 'msgtime.php';
?>