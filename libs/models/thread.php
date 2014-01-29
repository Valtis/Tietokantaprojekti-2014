<?php
require_once "database.php";
require_once "user.php";
require_once "post.php";

class Thread {
    private $id;
    private $name;
    private $creator;
    private $post_count;
    private $last_post;
    
    
    private function __construct($id, $name, $creator, $thread_count, $last_post) {
        $this->id = $id;
        $this->name = $name;
        $this->creator = $creator;
        $this->post_count = $thread_count;
        $this->last_post = $last_post;
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
    
    public function getLastPostDate() {
        return $this->last_post;
    }
    
    
    public function getCreator() {
        return $this->creator;
    }
    
    
    
    public static function loadThreads($topic_id) {
        
        $results = Database::executeQueryReturnAll("SELECT threads.thread_id, thread_name, user_name, COUNT(thread_posts.thread_id) AS number_posts, 
                    (SELECT MAX(posted_date) FROM posts, thread_posts WHERE posts.post_id = thread_posts.post_id AND thread_posts.thread_id = threads.thread_id) AS last_post "
                . "FROM threads, thread_posts, users WHERE threads.thread_id = thread_posts.thread_id AND users.user_id=threads.starter_id AND topic_id=? "
                . "GROUP BY threads.thread_id, thread_name, users.user_name " 
                . "ORDER BY last_post DESC"
                , array($topic_id));
        
        $threads = array();

        foreach ($results as $row) {
            $threads[$row->thread_id] = new Thread($row->thread_id, $row->thread_name, $row->user_name, $row->number_posts, $row->last_post);
 
        }
        
        return $threads;
    }
   
    public static function createNewThread($userID, $topicID, $title, $text) {
        
        $threadID = Database::executeQueryReturnSingle("INSERT INTO threads VALUES (DEFAULT, ?, ?, ?) RETURNING thread_id", array($title, $userID, $topicID));
        Post::createNewPost($userID, $threadID->thread_id, $text);        
        return $threadID->thread_id;
    }
    
    public static function deleteThread($threadID) {
        Database::executeQueryReturnSingle("DELETE FROM posts WHERE post_id IN (SELECT post_id FROM thread_posts WHERE thread_id=?)", array($threadID));
        Database::executeQueryReturnSingle("DELETE FROM threads WHERE thread_id=?", array($threadID));
    }
    
    //loadUserByDatabaseResults;
    public function getReaders($threadID) {
        $results = Database::executeQueryReturnAll("SELECT * FROM read_threads, users 
            WHERE thread_id = ? AND read_threads.user_id = users.user_id", array($threadID));
     
        $users = array();
        foreach ($results as $row) {
            $user = User::loadUserByDatabaseResults($row);
            $users[$user->getID()] = $user;
        }
        
        
        return $users;
        
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