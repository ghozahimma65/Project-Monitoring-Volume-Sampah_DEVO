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
            'lokasi'    => 'required|string',
            'panjang'   => 'required|numeric|min:0.1|max:5000', // <-- Ubah di sini
            'lebar'     => 'required|numeric|min:0.1|max:5000', // <-- Ubah di sini
            'tinggi'    => 'required|numeric|min:0.1|max:5000', // <-- Ubah di sini
    ];
}
}
