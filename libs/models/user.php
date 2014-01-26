<?php
const PASSWORD_HASHING_ITERATIONS = 10000;
require_once "database.php";

class AccessLevel {
    
    const NORMAL = 0;
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
    
       
    private function __construct() {
        $this->name = NULL;
        $this->password = NULL;
        $this->salt = NULL;
        $this->email = NULL;
        $this->iterations = NULL;
        $this->access_level = NULL;
    }
    
    public function getID() {
        return $this->id;
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
    
    public static function userExists($name) {
        $results = self::executeQuery("SELECT * FROM users WHERE user_name = ?", array($name));
        return !empty($results);
    }
    
    public static function createNewUser($name, $email, $password) {
       
        $salt = self::createSalt();
 
        self::saveNewUser(
                $name, 
                $email, 
                self::hashPassword($password, $salt, PASSWORD_HASHING_ITERATIONS),
                $salt,
                PASSWORD_HASHING_ITERATIONS,
                AccessLevel::NORMAL
                );
    }
    
    private static function saveNewUser($name, $email, $password, $salt, $iterations, $access_level) {
        Database::executeQueryReturnSingle("INSERT INTO users VALUES (DEFAULT, ?, ?, ?, ?, ?, ?)", array($name, $email, $password, $salt, $iterations, $access_level));
    }
    
    public static function loadUser($name, $password) {
        $results = self::getUserData($name, $password);
        
        if ($results == NULL) {
            return NULL;
        }
        
        return self::setUpUser($results);
    }
    
    private static function getUserData($name, $password) {
        $results = Database::executeQueryReturnSingle("SELECT * FROM users WHERE user_name = ?", array($name));
        
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
            $password = hash("sha256", $password . $salt);
        }
        return $password;
    }
    
    private static function createSalt() {
        return hash("sha256", microtime() . session_id());
    }
    
}
