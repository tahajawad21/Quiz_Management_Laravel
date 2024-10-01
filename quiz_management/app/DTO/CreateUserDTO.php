<?php

namespace App\DTO;

class CreateUserDTO
{
    public $name;
    public $email;
    public $password;
    public $role;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->role = $data['role'] ?? 'student'; // Default to 'student' if role is not provided
    }
}
