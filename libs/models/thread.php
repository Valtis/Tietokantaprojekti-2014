<?php
require_once "database.php";
require_once "user.php";

class Thread {
    private $id;
    private $name;
    private $creator;
    private $post_count;
    
    
    private function __construct($id, $name, $thread_count) {
        $this->id = $id;
        $this->name = $name;
        $this->topic_thread_count = $thread_count;
    }
    
    
    public function getName() {
        return $this->name;
    }
    
    public function getID() {
        return $this->id;
    }
    
    public function getThreadCount() {
        return $this->topic_thread_count;
    }
    
    function loadThreads() {
        $results = Database::executeQueryReturnAll("SELECT * FROM threads");
        
        $topics = array();
        $i = 0;
        foreach ($results as $row) {
            $post_counrt = Database::executeQueryReturnSingle("SELECT COUNT(*) FROM thread_posts WHERE thread_id = ?", array($row->thread_id));
            $creator = 
            
            $topics[$i] = new Topic($row->thread_id, $row->thread_name, $creator->name, $post_count->count);
            $i++;
        }
        
        return $topics;
    }
    
}