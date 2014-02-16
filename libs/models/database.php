<?php
    class Database {
        private static $connection = NULL;
        
        
      private static function getConnection() {
            if (self::$connection == NULL) {
                self::$connection = new PDO("pgsql:");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            
            return self::$connection;           
        }
    
    private static function executeHelper($sql, $parameters) {
        $connection = self::getConnection();
        $query = $connection->prepare($sql);
        $query->execute($parameters); 
        return $query;
    }
    
        
    public static function executeQueryReturnSingle($sql, $parameters = array()) {
        $query = self::executeHelper($sql, $parameters);
        return $query->fetchObject();
    }
    
    public static function executeQueryReturnAll($sql, $parameters = array()) {
        $query = self::executeHelper($sql, $parameters);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
}


    