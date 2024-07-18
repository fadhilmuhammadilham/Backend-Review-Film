<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CastRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'age' => 'required|integer',
            'bio' => 'required'
        ];

    }

    public function messages(): array
    {
        return [
            'name.required' => 'Inputan name harus di isi.',
            'name.max' => 'name tidak boleh lebih dari 255 karakter.',
            'age.required' => 'Inputan age harus di isi',
            'age.integer' => 'Inputan age harus berupa angka',
            'bio.required' => 'Inputan bio harus di isi',
        ];
    }
}
