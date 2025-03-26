<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:0',
            'mother_id' => 'nullable|exists:cats,id,gender,Female',
            'father_id' => 'nullable|exists:cats,id,gender,Male'
        ];
    }
}
