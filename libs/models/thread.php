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
    
    
    private function __construct($id, $name, $creator, $post_count, $last_post) {
        $this->id = $id;
        $this->name = $name;
        $this->creator = $creator;
        $this->post_count = $post_count;
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
    /**
     * Returns the number of posts belonging to a thread with given id
     * 
     * @param integer $thread_id thread id
     * @return integer number of posts in the thread
     */
    public static function getThreadPostCount($thread_id) {
        $result = Database::executeQueryReturnSingle("
                SELECT COUNT(thread_posts.thread_id) AS number_posts
                FROM thread_posts WHERE thread_posts.thread_id = ?",
                array($thread_id));
        return $result->number_posts;
    }
    
    /**
     * Loads all threads that belong to given topic
     * 
     * @param integer $topic_id topic-id
     * @return array of threads that belong to the topic
     */
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
   /**
    * Creates a new thread in the database
    * 
    * @param integer $userID user id of the creator
    * @param integer $topicID topic id it belongs to
    * @param string $title Thread title
    * @param string $text Thread text
    * @return integer id of the new row
    */
    public static function createNewThread($userID, $topicID, $title, $text) {
        
        $threadID = Database::executeQueryReturnSingle("INSERT INTO threads 
            VALUES (DEFAULT, ?, ?, ?) 
            RETURNING thread_id", array($title, $userID, $topicID));
        Post::createNewPost($userID, $threadID->thread_id, $text);        
        return $threadID->thread_id;
    }
    

    /**
     * Renames a thread with given id
     * 
     * @param integer $threadID thread id
     * @param string $name New name
     */
    public static function renameThread($threadID, $name) {
         Database::executeQueryReturnSingle("UPDATE threads 
            SET thread_name = ? WHERE thread_id = ?", array($name, $threadID));
    }
    /**
     * Deletes thread with given id and all the posts that belong to it
     * @param integer  $threadID thread id
     */
    public static function deleteThread($threadID) {
        Database::executeQueryReturnSingle("DELETE FROM posts 
            WHERE post_id 
            IN 
              (SELECT post_id 
                FROM thread_posts 
                WHERE thread_id=?)", array($threadID));
        Database::executeQueryReturnSingle("DELETE FROM threads WHERE thread_id=?", array($threadID));
    }
    
    /**
     * Loads the users that have read the given thread 
     * @param integer $threadID thread id
     * @return array of users that have read the thread
     */
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
    /**
     * Marks the given thread as read and saves the id of the final post on the page
     * 
     * @param integer $threadID thread id
     * @param integer $userID user id
     * @param integer $postID post id
     */
    public function markAsRead($threadID, $userID, $postID) {
        // see if this row exists
        $result = Database::executeQueryReturnSingle("SELECT count(*) as count 
            FROM read_threads 
            WHERE thread_id = ? AND user_id = ?", array($threadID, $userID));
        // if row exists, update it. Otherwise insert new row
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