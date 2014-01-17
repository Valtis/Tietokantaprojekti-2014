<?php
const PASSWORD_HASHING_ITERATIONS = 10000;
require_once "database.php";

class AccessLevel {
    
    const NORMAL_USER = 0;
    const BANNED = 1;
    const MODERATOR = 2;
    const ADMIN = 3;    
}

class User {
    private $id;
    private $name;
    private $password;
    private $salt;
    private $email;
    private $iterations;
    private $access_level;
    
       
    public function __construct() {
        $this->name = NULL;
        $this->password = NULL;
        $this->salt = self::createSalt();
        $this->email = NULL;
        $this->iterations = NULL;
        $this->access_level = NULL;
    }
    
    public function getName() {
        return $this->name;
    }
    
    public function setName($n) {
        $this->name = $n;
    }
    
    public function getPassword() {
        return $this->password;        
    }
    
    public function setPassword($pw) {
        $this->password = self::hashPassword($pw, $this->salt, PASSWORD_HASHING_ITERATIONS);   
        $this->iterations = PASSWORD_HASHING_ITERATIONS;
    }
    
    public function getIterations() {
        return $this->iterations;
    }
    public function getSalt() {
        return $this->salt;        
    }
    
    public static function loadUser($name, $password) {
        $results = self::getUserData($name, $password);
        
        if ($results == NULL) {
            return NULL;
        }
        
        return self::setUpUser($results);
    }
    
    private static function getUserData($name, $password) {
        $connection = Database::getConnection();
        $sql = "SELECT * FROM users WHERE user_name = ?";
        $query = $connection->prepare($sql);
        $query->execute(array($name));
        $results = $query->fetchObject();
        
        if ($results == NULL) {
            return NULL;
        }
               
        if (self::hashPassword($password, $results->user_salt, $results->iterations) != $results->user_password) {
            return NULL;
        }
        
        return $results;
        
    }
    
    private static function setUpUser($results) {
        $user = new User();
        
        
        $user->id = $results->user_id;
        $user->salt = $results->user_salt;
        $user->name = $results->user_name;
        $user->email = $results->email;
        $user->password = $results->user_password;
        $user->iterations = $results->iterations;
        $user->access_level = $results->access_level;      
        return $user;
    }
            
    // todo - extract as generic utility functions?
    private static function hashPassword($password, $salt, $iterations) {
        for ($i = 0; $i < $iterations; $i++) {
            $password = sha1($password . $salt);
        }
        return $password;
    }
    
    private static function createSalt() {
        
        return sha1(microtime() . session_id());
    }
    
}
