<?php
const PASSWORD_HASHING_ITERATIONS = 10000;
const SALT_SIZE = 40;
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
               echo "bfcdgdfv";
        $this->salt = self::createSalt();
               echo "asdasd";
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
        $this->password = hashPassword($pw, PASSWORD_HASHING_ITERATIONS);        
    }
    
    public function getSalt() {
        return $this->salt;        
    }
    
    public static function loadUser($name, $password) {
        $results = self::getUserData($password);
        
        if ($results == NULL) {
            return NULL;
        }
        
        $user = new User();
        return self::setUpUser($results);
        
        
    }
    
    private static function getUserData($password) {
        $connection = Database::getConnection();
        $sql = "SELECT * FROM users WHERE name = ?";
        $query = $connection->prepare($sql);
        $results = $query->execute(array($name));
        
        if ($results == NULL) {
            return NULL;
        }
        
        if (hashPassword($password, $results->iterations) !== $results->password) {
            return NULL;
        }   
    }
    
    private static function setUpUser($results) {
        $user = new User();
        
        $user->id = $results->user_id;
        $user->name = $results->user_name;
        $user->email = $results->email;
        $user->password = $results->password;
        $user->salt = $results->salt;
        $user->iterations = $results->iterations;
        $user->access_level = $results->access_level;        
    }
            
    // todo - extract as generic utility functions?
    private static function hashPassword($password, $iterations) {
        for ($i = 0; $i < $iterations; $i++) {
            $password = sha1($password . $this->salt);
        }
        return $password;
    }
    
    private static function createSalt() {
        echo "asdasd";
        return mcrypt_create_iv(SALT_SIZE);
    }
    
}
