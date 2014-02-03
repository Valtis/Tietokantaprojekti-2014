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
               
    private function __construct($id, $name, $email, $pw, $salt, $iterations, $access) {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->password = $pw;
        $this->salt = $salt;
        $this->iterations = $iterations;
        $this->access_level = $access;
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
    
    public function getIterations() {
        return $this->iterations;
    }
    
    public function getSalt() {
        return $this->salt;        
    }
    
    public function setAccessLevel($accessLevel) {
        $this->access_level = $accessLevel;
    }
    
    public function isBanned() {
        return $this->access_level == AccessLevel::BANNED;        
    }
        
    public function hasNormalAccess() {
        return $this->access_level != AccessLevel::BANNED;
    }
    
    public function hasModeratorAccess() {
        return $this->access_level == AccessLevel::MODERATOR || $this->access_level == AccessLevel::ADMIN;
    }
    
    public function hasAdminAccess() {
        return $this->access_level == AccessLevel::ADMIN;
    }
    
    
    public static function userExists($name) {
        $results = Database::executeQueryReturnSingle("SELECT * FROM users WHERE user_name = ?", array($name));
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
    
    public static function loadUserByID($id) {
        $results = Database::executeQueryReturnSingle("SELECT * FROM users WHERE user_id = ?", array($id));
        return self::loadUserByDatabaseResults($results);
    }
    
    public static function loadUser($name, $password) {
        $results = self::getUserData($name, $password);
        return self::loadUserByDatabaseResults($results);
    }
    
    public static function loadUsers() {
        $results = Database::executeQueryReturnAll("SELECT * FROM users ORDER BY user_name ASC");
        $users = array();
        foreach ($results as $row) {
            $u = User::loadUserByDatabaseResults($row);
            $users[$u->getID()] = $u;
        }
        
        return $users;
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
    
    public static function loadUserByDatabaseResults($results) {
        if ($results == NULL) {
            return NULL;
        }
    
        return new User(
                $results->user_id, 
                $results->user_name,
                $results->email,
                $results->user_password, 
                $results->user_salt, 
                $results->iterations, 
                $results->access_level);        
    }
    
    
    public function saveUser() {
        Database::executeQueryReturnSingle("UPDATE users 
            SET user_name = ?, email = ?, user_password = ?, user_salt = ?, iterations = ?, access_level = ? 
            WHERE user_id = ?", 
                array($this->name, $this->email, $this->password,
                    $this->salt, $this->iterations, $this->access_level,
                    $this->id));
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
