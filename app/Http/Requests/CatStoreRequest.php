<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CatStoreRequest extends FormRequest
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
        'age' => 'required|integer|min:0|max:30',
        'mother_id' => 'nullable|exists:cats,id',
        'father_ids' => 'nullable|array',
        'father_ids.*' => 'exists:cats,id'
    ];
}
}
