<?php

namespace App\Http\Requests\Fisioterapis;

use Illuminate\Foundation\Http\FormRequest;

class FisioterapisRequest extends FormRequest
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
      'id_user' => 'required|exists:users,id', // Pastikan validasi id_user
      'nama' => 'required|string|max:255',
      'tanggal_lahir' => 'required|date',
      'alamat' => 'required|string',
      'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
      'kehadiran' => 'nullable|string',
  ];
  }
}
