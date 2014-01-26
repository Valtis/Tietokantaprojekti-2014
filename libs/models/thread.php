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
       // $results = Database::executeQueryReturnAll("SELECT threads.thread_id, thread_name, COUNT(thread_posts.thread_id) AS number_posts FROM threads LEFT JOIN thread_posts ON threads.thread_id = thread_posts.thread_id WHERE topic_id=? GROUP BY threads.thread_id, thread_name", array($topic_id));
        
        $results = Database::executeQueryReturnAll("SELECT threads.thread_id, thread_name, user_name, COUNT(thread_posts.thread_id) AS number_posts "
                . "FROM threads, thread_posts, users WHERE threads.thread_id = thread_posts.thread_id AND users.user_id=threads.starter_id AND topic_id=? "
                . "GROUP BY threads.thread_id, thread_name, users.user_name", array($topic_id));
        
        $threads = array();

        foreach ($results as $row) {
            $threads[$row->thread_id] = new Thread($row->thread_id, $row->thread_name, $row->user_name, $row->number_posts);
        }
        
        return $threads;
    }
    
}