<?php
/**
 * @author Daniel Schreiner
 * @email schreiner.daniel@gmail.com
 */
namespace Dto;
use Models\User;


class UserDTO {
    private $id;
    private $username;
    private $is_enabled;
    private $register_date;
    private $name;
    private $surname;
    private $email;
    private $phone;
    private $role;
    
    public function __construct(User $user) {
        $this->id = $user->id  ?? null;
        $this->username = $user->username  ?? null;
        $this->is_enabled = $user->is_enabled  ?? null;;
        $this->register_date = $user->register_date  ?? null;;
        $this->name = $user->name  ?? null;;
        $this->surname = $user->surname  ?? null;;
        $this->email = $user->email  ?? null;;
        $this->phone = $user->phone  ?? null;;
        $this->role = $user->role  ?? null;;
    }
}


