<?php
require_once 'libs/models/database.php';

class Post {
    private $post_id;
    private $poster_id;
    private $poster_name;
    private $text;
    private $posted_date;
    private $is_deleted;
    private $replies_to;
    
    private function __construct($id, $poster_id, $poster_name, $text, $posted_date, $is_deleted, $replies_to) {
        $this->post_id = $id;
        $this->poster_id = $poster_id;
        $this->poster_name = $poster_name;
        $this->text = $text;
        $this->posted_date = $posted_date;
        $this->is_deleted = $is_deleted;
        $this->replies_to = $replies_to;
    }
    
    public function getPostID() {
        return $this->post_id;
    }  
    
    public function getPosterID() {
        return $this->poster_id;
    } 
    
    public function getPosterName() {
        return $this->poster_name;
    }
    
    public function getPostText() {
        return $this->text;
    }
    
    public function getPostDate() {
        return $this->posted_date;
    }
    
    public function isDeleted() {
        return $this->is_deleted;
    }
    
    public function markAsDeleted($deleter) {
        $this->is_deleted = "true";
        $this->text = "This post has been deleted by " . $deleter;
        $this->replies_to = NULL;
    }

    public function repliesToID() {
        return $this->replies_to;
    }
    
    public static function loadPost($post_id) {
        $result = Database::executeQueryReturnSingle("SELECT post_id, user_name, poster_id, text, posted_date, is_deleted, replies_to
            FROM posts, users WHERE posts.poster_id=users.user_id AND post_id=?", array($post_id));
        if ($result == NULL) {
            return NULL;
        }
        
        return new Post($result->post_id, $result->poster_id, $result->user_name, $result->text, $result->posted_date, $result->is_deleted, $result->replies_to);
    }

    public static function loadPosts($thread_id) {

        $results = Database::executeQueryReturnAll("SELECT posts.post_id, poster_id, user_name, text, posted_date, is_deleted, replies_to FROM posts, thread_posts, users"
                . " WHERE posts.post_id = thread_posts.post_id AND posts.poster_id = users.user_id AND thread_id=? ORDER BY posts.post_id ASC", array($thread_id));
       
        $posts = array();
        
        foreach ($results as $row) {
            $posts[$row->post_id] = new Post($row->post_id, $row->poster_id, $row->user_name, $row->text, $row->posted_date, $row->is_deleted, $row->replies_to);
        }
        
        return $posts;
    }
    
    public static function createNewPost($posterid, $threadid, $text, $replies_to = NULL) {
        $ret = Database::executeQueryReturnSingle("INSERT INTO posts VALUES (DEFAULT, ?, ?, ?, ?, ?) RETURNING post_id", array($posterid, $text, date('Y-m-d H:i:s', time()), "false", $replies_to));
        
        Database::executeQueryReturnSingle("INSERT INTO thread_posts VALUES (?, ?)", array($threadid, $ret->post_id));
        return $ret->post_id;
    }

  
    
    public function savePost() {
        Database::executeQueryReturnSingle("UPDATE posts 
            SET poster_id = ?, text = ?, posted_date = ?, is_deleted = ?, replies_to = ? 
            WHERE post_id = ?",
                array($this->poster_id, $this->text, $this->posted_date, $this->is_deleted, $this->replies_to, $this->post_id));
    }
    
    
}

