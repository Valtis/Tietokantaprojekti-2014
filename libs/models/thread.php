<?php
require_once "database.php";

class Thread {
    private $id;
    private $name;
    private $creator;
    private $post_count;
    
    
    private function __construct($id, $name, $creator, $thread_count) {
        $this->id = $id;
        $this->name = $name;
        $this->creator = $creator;
        $this->post_count = $thread_count;
    }
    
    
    public function getName() {
        return $this->name;
    }
    
    public function getID() {
        return $this->id;
    }
    
    public function getPostCount() {
        return $this->post_count;
    }
    
    public function getNewMessagesPosted() {
        return "PLACEHOLDER";
    }
    
    
    public function getCreator() {
        return $this->creator;
    }
    
    function loadThreads($topic_id) {
        
        $results = Database::executeQueryReturnAll("SELECT threads.thread_id, thread_name, user_name, COUNT(thread_posts.thread_id) AS number_posts "
                . "FROM threads, thread_posts, users WHERE threads.thread_id = thread_posts.thread_id AND users.user_id=threads.starter_id AND topic_id=? "
                . "GROUP BY threads.thread_id, thread_name, users.user_name", array($topic_id));
        
        $threads = array();

        foreach ($results as $row) {
            $threads[$row->thread_id] = new Thread($row->thread_id, $row->thread_name, $row->user_name, $row->number_posts);
        }
        
        return $threads;
    }
    
    public function markAsRead($threadID, $userID, $postID) {
        $result = Database::executeQueryReturnSingle("SELECT count(*) as count 
            FROM read_threads 
            WHERE thread_id = ? AND user_id = ?", array($threadID, $userID));
        if ($result->count == 0) {
            Database::executeQueryReturnSingle("INSERT INTO read_threads VALUES (?, ?, ?)", array($threadID, $userID, $postID));
        } else {
            Database::executeQueryReturnSingle(
                    "UPDATE read_threads 
                        SET post_id = ? 
                        WHERE thread_id = ? AND user_id = ?", array($postID, $threadID, $userID));
        }
    }
}