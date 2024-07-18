<?php

namespace App\Http\Requests;

use App\Models\Cast;
use Illuminate\Foundation\Http\FormRequest;

class CastMovieRequest extends FormRequest
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
            'cast_id' => 'required|exists:casts,id',
            'movie_id' => 'required|exists:movies,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Inputan name harus di isi.',
            'cast_id.required' => 'Inputan cast_id harus di isi.',
            'cast_id.exists' => 'Cast yang anda pilih tidak ada.',
            'movie_id.required' => 'Inputan movie_id harus di isi.',
            'movie_id.exists' => 'Movie yang anda pilih tidak ada.',
        ];
    }
}
