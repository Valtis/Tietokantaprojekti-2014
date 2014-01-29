function openWindow(addr) {
    window.open(addr, '_self');
}

function confirm_post_delete(id) {
    var result = confirm("Really delete this post (post_id: " + id + ")");
    
    if (result == true) {
        $.get("delete_post.php?postid=" + id, function () { window.location.reload(); });
    }
    
}

function confirm_thread_delete(id, name) {
    var result = confirm("Really delete this thread (" + name + ")");
    
    if (result == true) {
        $.get("delete_thread.php?threadid=" + id, function () { window.location.reload(); });
    }
    
}

function logoff() {
    $.get("logoff.php", function () { window.location.reload(); });
}