<?php
const PASSWORD_HASHING_ITERATIONS = 100;

class AccessLevel {
    
    const NORMAL_USER = 0;
    const BANNED = 1;
    const MODERATOR = 2;
    const ADMIN = 3;    
}

class User {
    private $name;
    private $password;
    private $salt;
    private $email;
    private $iterations;
    private $access_level;
    
       
    public function __construct() {
        $this->name = NULL;
        $this->password = NULL;
        $this->salt = CreateSalt();
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
    
    public static function loadUser($name, $password) {
        
    }
            
    // todo - extract as generic utility functions?
    private static function hashPassword($password) {
        for ($i = 0; $i < PASSWORD_HASHING_ITERATIONS; $i++) {
            $password = sha1($password . $this->salt);
        }
        return $password;
    }
    
    private static function createSalt() {
                
    }
    
}
?>