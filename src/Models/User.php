<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Models;
use Dto\UserDTO;

class User {
    private $id;
    private $username;
    private $password;
    private $is_enabled;
    private $register_date;
    private $name;
    private $surname;
    private $email;
    private $phone;
    private $role;

    public function __construct($data)
    {
        if (sizeof($data)>0) {
            $this->id = $data['id'] ?? null;
            $this->username = $data['username']  ?? null;
            $this->password = $data['password'] ?? null;
            $this->is_enabled = $data['is_enabled'] ?? null;
            $this->register_date = $data['register_date'] ?? null;
            $this->name = $data['name'] ?? null;
            $this->surname = $data['surname']  ?? 0;
            $this->email = (int)$data['email'] ?? 0;
            $this->phone = $data['phone'] ?? null;
            $this->role = $data['role'] ?? null;
        }
    }


    public function __set($name, $value)
    {
        $this->$name = $value;
    }
    public function __get($name)
    {
        return $this->$name;
    }

    public function toDTO() {
        return new UserDTO($this);
    }
}

