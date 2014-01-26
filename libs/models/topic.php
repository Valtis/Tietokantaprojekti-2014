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
        $results = Database::executeQueryReturnAll("SELECT topics.topic_id, name, COUNT(threads.topic_id) AS number_threads FROM topics LEFT JOIN threads ON topics.topic_id = threads.topic_id GROUP BY topics.topic_id, name");
        
        $topics = array();

        foreach ($results as $row) {
            $topics[$row->topic_id] = new Topic($row->topic_id, $row->name, $row->number_threads);

        }
        
        return $topics;
    }
    
}
