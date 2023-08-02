<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Repositories;
use Core\PgsqlConnectionPool;
use Models\Product;

class Repository
{
    public $pgsqlConnectionPool;
    public $table;

    public function __construct(PgsqlConnectionPool $connectionPool)
    {
        $this->pgsqlConnectionPool = $connectionPool;
    }
    public function getPgsqlConnection()
    {
        return $this->pgsqlConnectionPool->getConnection();
    }

    public function getAll()
    {
        $dbi = $this->getPgsqlConnection();
        $query = "SELECT * FROM $this->table";

        $result = pg_query($dbi, $query);

        $data = [];
        while ($row = pg_fetch_object($result)) {
            $data[] = $row;
        }

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $data;
    }

    public function getById($id)
    {
        $dbi = $this->getPgsqlConnection();
        $query = "SELECT * FROM $this->table WHERE id = $id";
        $result = pg_query($dbi, $query);
        $data = pg_fetch_object($result);
        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $data;
    }

    public function create($data)
    {
        $dbi = $this->getPgsqlConnection();

        $keys = implode(', ', array_keys($data));
        $values = implode("', '", array_values($data));
        $query = "INSERT INTO $this->table ($keys) VALUES ($values)";
        $result = pg_query($dbi, $query);

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $result;
    }

    public function update($id, $data)
    {
        $dbi = $this->getPgsqlConnection();
        $set = [];
        foreach ($data as $key => $value) {
            $set[] = "$key = '$value'";
        }
        $set = implode(', ', $set);
        $query = "UPDATE $this->table SET $set WHERE id = $id";
        $result = pg_query($dbi, $query);

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $result;
    }

    public function delete($id)
    {
        $dbi = $this->getPgsqlConnection();
        $query = "DELETE FROM $this->table WHERE id = $id";
        $result = pg_query($dbi, $query);

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        
        return $result;
    }
}
