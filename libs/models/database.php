<?php
    class Database {
        private static $connection = NULL;
        
      /**
       * Function that returns database connection. If connection does not exists, 
       * create one
       * 
       * @return PDO Database connection
       */  
      private static function getConnection() {
            if (self::$connection == NULL) {
                self::$connection = new PDO("pgsql:");
                self::$connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }
            
            return self::$connection;           
        }
    /**
     * Helper function that prepares and executes the query and returns the result
     * 
     * @param string $sql Query
     * @param array of strings $parameters Parameters to be used in the query
     * @return query returns executed query
     */
    private static function executeHelper($sql, $parameters) {
        $connection = self::getConnection();
        $query = $connection->prepare($sql);
        $query->execute($parameters); 
        return $query;
    }
    
    /**
     * Executes given query with given parameters and returns single (first) result
     * 
     * @param string $sql Query
     * @param array of strings $parameters Parameters to be used in the query
     * @return object containing result of the query
     */    
    public static function executeQueryReturnSingle($sql, $parameters = array()) {
        $query = self::executeHelper($sql, $parameters);
        return $query->fetchObject();
    }
    /**
     * Executes given query with given parameters and returns all the rows that matched
     * the query
     * 
     * @param string $sql Query
     * @param array of strings $parameters Parameters to be used in the query
     * @return array of objects that contain rows that matched the query
     */
    public static function executeQueryReturnAll($sql, $parameters = array()) {
        $query = self::executeHelper($sql, $parameters);
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
    
}


    