<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'gender' => 'nullable|string|in:Male,Female',
            'age_min' => 'nullable|integer|min:0',
            'age_max' => 'nullable|integer|min:0',
        ];
    }
}
