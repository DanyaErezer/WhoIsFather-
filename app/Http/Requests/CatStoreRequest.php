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
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:25',
            'gender' => 'required|string|in:male,female',
            'age' => 'required|integer|min:0',
            'mother_id' => 'nullable|integer|exists:cats,id',
            'father_ids' => 'nullable|integer|array',
            'father_ids.*' => 'integer|exists:cats,id',
        ];
    }
}
