<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepoRequest extends FormRequest
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
    public function rules()
{
    return [
        'nama_depo' => 'required|string|max:255',
        'lokasi' => 'required|string',
        'kapasitas' => 'required|numeric|min:1|max:5000', // Contoh: kapasitas minimal 1, maks 5000
        // tambahkan aturan lain
    ];
}
}
