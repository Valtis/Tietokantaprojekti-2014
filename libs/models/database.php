<?php
    class Database {
        private static $connection = NULL;
        
        
        public static function getConnection() {
            if (self::$connection == NULL) {
                self::$connection = new PDO("pgsql:");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            
            return self::$connection;           
        }
        
    }


    