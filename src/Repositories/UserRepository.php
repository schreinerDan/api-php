<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Repositories;

use Core\PgsqlConnectionPool;
use Models\User;

class UserRepository extends Repository {
    public function __construct(PgsqlConnectionPool $connectionPool) {
        parent::__construct($connectionPool);
        $this->table = "users";
    }

    
    
    public function getUserByUsername($name) {
        $dbi = $this->getPgsqlConnection();
        $query = "SELECT * FROM users WHERE username = '$name'";
        $result = pg_query($dbi, $query);
        $data = pg_fetch_object($result);
        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $data;
        
    }
    public function createUser(User $user) {   

        $dbi = $this->getPgsqlConnection();
        $query = "INSERT INTO users (username,
                                        password,
                                        is_enabled,
                                        register_date,
                                        name,
                                        surname,
                                        email,
                                        phone,
                                        role)
                              VALUES   ( ' $user->username',
                                        '$user->password',
                                        true,
                                        'NOW()',
                                        '$user->name',
                                        '$user->surname',
                                        '$user->email',
                                        $user->phone,
                                        $user->role)";
        $result = pg_query($dbi, $query);

        $this->pgsqlConnectionPool->releaseConnection($dbi);
        return $result;
    }

    public function updateUser($id, User $user) {
        $data = [
            'username' => $user->username,
            'password' => $user->password,
            'is_enabled' => $user->is_enabled,
            'register_date' => $user->register_date,
            'name' => $user->name,
            'surname' => $user->surname,
            'email' => $user->email,
            'phone' => $user->phone,
            'role' => $user->role
        ];
        return $this->update($id, $data);
    }

   
}
