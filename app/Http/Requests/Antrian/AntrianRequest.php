<?php

namespace App\Http\Requests\Antrian;

use Illuminate\Foundation\Http\FormRequest;

class AntrianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Validasi untuk id_pasien
            'id_pasien' => 'required|exists:pasien,id_pasien', // Memastikan pasien ada di tabel pasien
            'id' => 'required|exists:fisioterapis,id', 

            // Validasi untuk kolom antrian
            'keluhan' => 'required|string|max:255',
            'jam_terapi' => 'required|date_format:H:i', // Format jam terapi
            'tanggal_terapi' => 'required|date|after_or_equal:today', // Tanggal terapi harus valid dan tidak di masa lalu
        ];
    }
}
