<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'start_time', 'end_time'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
    public function students()
    {
        return $this->belongsToMany(User::class)->withPivot('assigned_at', 'status', 'due_date');
    }
    
    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('status', 'assigned_at', 'attempted_at', 'due_date')->withTimestamps();
    }
    

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

}
