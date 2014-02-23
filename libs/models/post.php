<?php
require_once "database.php";

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
    
    
    public function getFormattedPostText() {
        return nl2br($this->text);
    }
    
    public function setPostText($text) {
        $this->text = $text;
    }
    
    
    public function getPostDate() {
        return $this->posted_date;
    }
    
    public function isDeleted() {
        return $this->is_deleted;
    }
    
    public static function isPrivateMessage($postID, $userID) {
        
            $result = Database::executeQueryReturnSingle("SELECT private_messages.post_id as cnt FROM private_messages
                    WHERE private_messages.post_id = ? AND private_messages.receiver_id = ?", array($postID, $userID));
            
            return ($result != NULL);
    }
    /**
     * Marks post as deleted and replaces its text with notification
     * @param type $deleter User who deleted the post
     */
     
    public function markAsDeleted($deleter) {
        $this->is_deleted = true;
        $this->text = "This post has been deleted by " . $deleter;
        $this->replies_to = NULL;
    }
    /**
     * Edits post by changing the text new text and adds edit line with user name.
     * @param string $newText New text
     * @param string $username Username of the person who edited the message
     */
    public function editPost($newText, $username) {
      $this->text = $newText . "\nThis post was edited by " . $username . " at " . date('Y-m-d H:i:s', time());
      $this->savePost();        
    }

    public function repliesToID() {
        return $this->replies_to;
    }
    /**
     * Loads post with given id
     * @param type $post_id
     * @return \Post|null
     */
    public static function loadPost($post_id) {
        $result = Database::executeQueryReturnSingle("SELECT post_id, user_name, poster_id, text, posted_date, is_deleted, replies_to
            FROM posts, users WHERE posts.poster_id=users.user_id AND post_id=?", array($post_id));
        if ($result == NULL) {
            return NULL;
        }
        return self::postLoadHelper($result);
    }
    
    public static function getPostPositionInThread($post_id) {
        $result = Database::executeQueryReturnSingle("SELECT count(*) FROM thread_posts "
                . "WHERE thread_posts.post_id < ? AND thread_posts.thread_id = "
                    . "(SELECT thread_id FROM thread_posts "
                    . "WHERE thread_posts.post_id = ?)", array($post_id, $post_id));
        
        return $result->count;
    }
    
    public static function loadPrivateMessages($user_id) {
        $results = Database::executeQueryReturnAll("SELECT posts.post_id, poster_id, user_name, text, posted_date, is_deleted, replies_to FROM posts, private_messages, users
            WHERE posts.post_id = private_messages.post_id AND private_messages.receiver_id = ? AND users.user_id = posts.poster_id
            ORDER BY posts.posted_date DESC", array($user_id));
        
        foreach ($results as $row) {
           $posts[$row->post_id] = self::postLoadHelper($row);
        }             
        return $posts;        
    }
    
    public static function loadLastReadPostFromThread($thread_id, $user_id) {
        $result = Database::executeQueryReturnSingle("SELECT * FROM posts, read_threads 
            WHERE posts.post_id = read_threads.post_id AND read_threads.thread_id=? AND read_threads.user_id=?", 
                array($thread_id, $user_id));
        
        if (empty($result)) {
            return $result;
        }
        return self::postLoadHelper($result);
    }
    
    public static function findPostsByUsername($username, $beginDate, $endDate) {
        return self::findPostsByUsernameAndContent($username, "", $beginDate, $endDate);
    }
    
    public static function findPostsByContent($word, $beginDate, $endDate) {
        return self::findPostsByUsernameAndContent("", $word, $beginDate, $endDate);
    }
    
    public static function findPostsByUsernameAndContent($username, $word, $beginDate, $endDate) {
        $results = Database::executeQueryReturnAll(
                "SELECT posts.post_id, poster_id, user_name, text, posted_date, is_deleted, replies_to, threads.thread_id, topic_id 
                    FROM posts, thread_posts, users, threads 
                    WHERE posts.post_id = thread_posts.post_id 
                    AND users.user_id = posts.poster_id 
                    AND threads.thread_id = thread_posts.thread_id
                    AND posts.posted_date > ?
                    AND posts.posted_date < ?
                    AND LOWER(users.user_name) LIKE ?
                    AND LOWER(text) LIKE ?
                    ORDER BY posted_date DESC",
                array(date('Y-m-d H:i:s', $beginDate), 
                    date('Y-m-d H:i:s', $endDate), 
                    strtolower("%" . $username . "%"), 
                    strtolower("%" . $word . "%")));
        $posts = array();
        foreach ($results as $row) {
           $posts[$row->post_id]['post'] = self::postLoadHelper($row);
           $posts[$row->post_id]['threadid'] = $row->thread_id;
           $posts[$row->post_id]['topicid'] = $row->topic_id;
        }
        return $posts;    
    }

    public static function loadPosts($thread_id, $limit, $offset) {

        $results = Database::executeQueryReturnAll(
                "SELECT posts.post_id, poster_id, user_name, text, posted_date, is_deleted, replies_to 
                    FROM posts, thread_posts, users 
                    WHERE posts.post_id = thread_posts.post_id 
                    AND posts.poster_id = users.user_id 
                    AND thread_id=? 
                    ORDER BY posts.post_id ASC LIMIT ? OFFSET ?", 
                    array($thread_id, $limit, $offset));
     
        $posts = array();
        foreach ($results as $row) {
           $posts[$row->post_id] = self::postLoadHelper($row);
        }
        
        return $posts;
    }
    
    private static function postLoadHelper($row) {
         return new Post($row->post_id, $row->poster_id, $row->user_name, $row->text, $row->posted_date, $row->is_deleted, $row->replies_to);
       
    }
    
    public static function createNewPost($posterid, $threadid, $text, $replies_to = NULL) {
        $ret = Database::executeQueryReturnSingle("INSERT INTO posts VALUES (DEFAULT, ?, ?, ?, ?, ?) RETURNING post_id", array($posterid, $text, date('Y-m-d H:i:s', time()), 'false', $replies_to));
        
        Database::executeQueryReturnSingle("INSERT INTO thread_posts VALUES (?, ?)", array($threadid, $ret->post_id));
        return $ret->post_id;
    }
    
    public static function createNewPrivateMessage($posterid, $receiverID, $text, $replies_to = NULL) {
        $ret = Database::executeQueryReturnSingle("INSERT INTO posts VALUES (DEFAULT, ?, ?, ?, ?, ?) RETURNING post_id", array($posterid, $text, date('Y-m-d H:i:s', time()), 'false', $replies_to));
        
        Database::executeQueryReturnSingle("INSERT INTO private_messages VALUES (?, ?)", array($ret->post_id, $receiverID));
        return $ret->post_id;
    }

    public static function deletePost($postID) {
        
        Database::executeQueryReturnSingle("DELETE FROM posts WHERE posts.post_id = ?", array($postID));
    }
    
    public function savePost() {
        $delete = 'f';
        if ($this->isDeleted()) {
            $delete = 't';
        }
        Database::executeQueryReturnSingle("UPDATE posts 
            SET poster_id = ?, text = ?, posted_date = ?, is_deleted = ?, replies_to = ? 
            WHERE post_id = ?",
                array($this->poster_id, $this->text, $this->posted_date, $delete, $this->replies_to, $this->post_id));
    }
    
    
}

