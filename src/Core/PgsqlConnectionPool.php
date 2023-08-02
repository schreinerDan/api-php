<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Core;

class PgsqlConnectionPool
{
    private $connections = [];
    private $config;
    private $maxConnections =10;
    private $host = '131.0.96.82';
    private $user = 'postgres';
    private $password = 'entra@1234';
    private $database = 'postgres';

    public function __construct()
    {
        for ($i = 0; $i < $this->maxConnections; $i++) {
            $this->connections[] = pg_connect(
                "host=$this->host dbname=$this->database user=$this->user password=$this->password"
            );
        }
    }

    private function createConnection()
    {
        return pg_connect(
            "host=$this->config['host'] dbname=$this->config['database'] user=$this->config['user'] password=$this->config['password']"
        );
    }

    private function isAlive($connection)
    {
        if (!pg_ping($connection)) {
            return false;
        }

        return true;
    }

    // Obtém uma conexão do pool
    public function getConnection()
    {
        if (count($this->connections) > 0) {
            return array_pop($this->connections);
        } else {
            return pg_connect(
                "host=$this->host dbname=$this->database user=$this->user password=$this->password"
            );
        }
    }

    // Libera uma conexão e a devolve ao pool
    public function releaseConnection($connection)
    {
        if (count($this->connections) < $this->maxConnections) {
            $this->connections[] = $connection;
        } else {
            pg_close($connection);
        }
    }
}
