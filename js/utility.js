function openWindow(addr) {
    window.open(addr, '_self');
}

function confirm_post_delete(id) {
    var result = confirm("Really delete this post (post_id: " + id + ")");
    
    if (result === true) {
        $.get("delete_post.php?postid=" + id, function () { window.location.reload(); });
    }
    
}

function confirm_thread_delete(id, name) {
    var result = confirm("Really delete this thread (" + name + ")");
    
    if (result === true) {
        $.get("delete_thread.php?threadid=" + id, function () { window.location.reload(); });
    }
    
}

function ask_new_thread_name(id, oldName) {
    var name = prompt("Give new thread name", oldName);
    if (name !== null) {
        $.get("rename_thread.php?threadid=" + id + "&name="+name, function () { window.location.reload(); });  
    }
}

function create_new_topic() {
    var name = prompt("Give the name for new topic name");
    if (name !== null) {
        $.get("topic_management.php?action=new&name="+name, function () { window.location.reload(); });  
    }
}

function ask_new_topic_name(id, oldName) {
    var name = prompt("Give new topic name", oldName);
    if (name !== null) {
        $.get("topic_management.php?action=rename&topicid=" + id + "&name="+name, function () { window.location.reload(); });  
    }
    
    
}

function confirm_topic_delete(id, name) {
    var result = confirm("Really delete topic " + name + "?");
    if (result === true) {
        $.get("topic_management.php?action=delete&topicid=" + id, function () { window.location.reload(); });
    }
}


function handleRoleChange(fieldname, userid) {
    var newRole = $("#" + fieldname).val();
 
    $.get("role_change.php?userid=" + userid + "&role=" + newRole, function () { window.location.reload(); });
}


function logoff() {
    $.get("logoff.php", function () { window.location.reload(); });
}