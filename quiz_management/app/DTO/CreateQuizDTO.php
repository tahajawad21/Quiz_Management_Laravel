<?php

namespace App\DTO;

class CreateQuizDTO
{
    public $title;
    public $description;
    public $startTime;
    public $endTime;

    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->startTime = $data['start_time'];
        $this->endTime = $data['end_time'];
    }
}
