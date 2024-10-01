<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuizRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * You can add authorization logic here.
     * 
     * @return bool
     */
    public function authorize()
    {
        return true; // Return true to allow all authorized users to make the request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'nullable|date',
            'questions' => 'required|array',
            'questions.*.question_text' => 'required|string',
            'questions.*.correct_answer' => 'required|string',
            'questions.*.options' => 'required|array',
        ];
    }
}
