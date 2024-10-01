<?php

namespace App\DTO;

class StudentSubmissionDTO
{
    public $name;
    public $email;
    public $cv_path;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->cv_path = $data['cv_path'];
    }
}
