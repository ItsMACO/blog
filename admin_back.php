<?php
require_once 'db.php';
include_once 'head_links.php';
?>
<div>
<button type='button' id='go_back' class='button button1' onclick='goBack()'>GO BACK</button>
</div><br>
<script>
function goBack() {
    document.getElementById('panels').innerHTML = "\
    <div class='row'>\
    \
    <div class='col s12 m3'>\
        <button type='button' id='edit_posts' class='button-admin break-long-words'>EDIT OR REMOVE POSTS</button>\
    </div>\
    <div class='col s12 m3'>\
        <button type='button' id='set_admin' class='button-admin break-long-words'>ADD OR REMOVE ADMIN</button>\
    </div>\
    <div class='col s12 m3'>\
        <button type='button' id='set_karma' class='button-admin break-long-words'>ADD OR REMOVE KARMA</button>\
    </div>\
    <div class='col s12 m3'>\
        <button type='button' id='add_flairs' class='button-admin break-long-words'>ADD FLAIRS</button>\
    </div>\
    \
    </div>\
    \
    <div class='row'>\
    \
    <div class='col s12 m3'>\
        <button type='button' id='countdowns' class='button-admin break-long-words'>COUNTDOWNS</button>\
    </div>\
    <div class='col s12 m3'>\
        <button type='button' id='bug_reports' class='button-admin break-long-words'>BUG REPORTS</button>\
    </div>\
    <div class='col s12 m3'>\
        <button type='button' id='feature_requests' class='button-admin break-long-words'>FEATURE REQUESTS</button>\
    </div>\
    <div class='col s12 m3'>\
        <button type='button' id='post_reports' class='button-admin break-long-words'>POST REPORTS</button>\
    </div>\
    \
    </div>\
    \
    <div class='row'>\
    \
    <div class='col s12 m3'>\
        <button type='button' id='user_reports' class='button-admin break-long-words'>USER REPORTS</button>\
    </div>\
    <div class='col s12 m3'>\
        <button type='button' id='ban_user' class='button-admin break-long-words'>BAN USER</button>\
    </div>";
}
</script>