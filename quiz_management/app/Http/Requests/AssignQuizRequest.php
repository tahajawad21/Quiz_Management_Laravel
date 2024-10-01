<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignQuizRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'user_id' => 'required|exists:users,id',
        ];
    }
}
