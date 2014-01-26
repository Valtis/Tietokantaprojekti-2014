<?php
require_once "database.php";

class Topic {
    private $id;
    private $name;
    private $topic_thread_count;
    
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
    
    function loadTopics() {
        $results = Database::executeQueryReturnAll("SELECT * FROM topics");
        
        $topics = array();
        $i = 0;
        foreach ($results as $row) {
            $thread_cnt = Database::executeQueryReturnSingle("SELECT COUNT(*) FROM threads WHERE topic_id = ?", array($row->topic_id));
            $topics[$i] = new Topic($row->topic_id, $row->name, $thread_cnt->count);
            $i++;
        }
        
        return $topics;
    }
    
}
