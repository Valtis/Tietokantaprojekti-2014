function openWindow(addr) {
    window.open(addr, '_self');
}

function confirm_delete(id) {
    var result = confirm("Really delete this post (post_id: " + id + ")");
    
    if (result == true) {
        $.get("delete_post.php?postid=" + id, function () { window.location.reload(); });
    }
    
    return true;
}