<?php

namespace App\Http\Requests;

use App\Models\Genre;
use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
            'title' => 'required|max:255',
            'summary' => 'required',
            'year' => 'required',
            'poster' => 'image|mimes:jpg,png,jpeg',
            'genre_id' => 'required|exists:genres,id',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Inputan title harus di isi.',
            'title.max' => 'Title tidak boleh lebih dari 255 karakter.',
            'summary.required' => 'Inputan summary harus di isi.',
            'year.required' => 'Inputan year harus di isi.',
            'year.date' => 'Year harus berupa tanggal yang valid.',
            'poster.mimes' => 'Poster harus berupa file dengan format: jpg, bmp, atau png.',
            'poster.image' => 'Poster harus berupa image.',
            'genre_id.required' => 'Inputan genre harus di isi.',
            'genre_id.exists' => 'Genre yang anda pilih tidak ada.',
        ];
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }
}
