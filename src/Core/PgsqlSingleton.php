<?php 

/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */

 namespace Core;
class PgsqlSingleton
{
    private static $instance = null;
    private $pool;
    

    private function __construct()
    {
        
     
    
        // $this->pool = new B2BPgsqlConnectionPool();
        $this->pool = new PgsqlConnectionPool();
    }

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PgsqlSingleton();
        }

        return self::$instance->pool;   
    }
}
