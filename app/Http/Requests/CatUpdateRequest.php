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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'gender' => 'required|in:Male,Female',
            'age' => 'required|integer|min:0',
        ];
    }
}
