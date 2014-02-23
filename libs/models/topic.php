<?php
require_once "database.php";
require_once "libs/models/thread.php";

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
    
    /**
     * Loads all topics
     * @return array of topics
     */
    public static function loadTopics() {
        $results = Database::executeQueryReturnAll("SELECT topics.topic_id, name, COUNT(threads.topic_id) AS number_threads "
                . "FROM topics "
                . "LEFT JOIN threads ON topics.topic_id = threads.topic_id "
                . "GROUP BY topics.topic_id, name "
                . "ORDER BY topics.topic_id ASC");
        
        $topics = array();

        foreach ($results as $row) {
            $topics[$row->topic_id] = new Topic($row->topic_id, $row->name, $row->number_threads);

        }
        
        return $topics;
    }
    /**
     * Inserts new topic with given name into database
     * @param string $name Name of the topic
     */
    public static function newTopic($name) {
       Database::executeQueryReturnSingle("INSERT INTO topics VALUES (DEFAULT, ?)", array($name));
    }
    /**
     * Renames topic with given id
     * 
     * @param integer $id topic id
     * @param string $name new name
     */
    public static function renameTopic($id, $name) {
        Database::executeQueryReturnSingle("UPDATE topics "
                . "SET name=? "
                . "WHERE topic_id=?", array($name, $id));
    }
    /**
     * Deletes topic with given id as well as all the threads that belong to it. 
     * @param integer $id topic id
     */
    public static function deleteTopic($id) {
        $results = Database::executeQueryReturnALL("SELECT thread_id "
                . "FROM threads WHERE threads.topic_id = ?", array($id));
        
        foreach ($results as $row) {
            Thread::deleteThread($row->thread_id);
        }
        
        Database::executeQueryReturnSingle("DELETE FROM topics "
                . "WHERE topic_id=?", array($id));
    }
    
}
