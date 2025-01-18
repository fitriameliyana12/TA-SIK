<?php

namespace App\Http\Requests\Pasien;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
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
      'no_rekam_medis' => 'required',
      'nama' => 'required',
      'tanggal_lahir' => 'required',
      'jenis_kelamin' => 'required',
      'alamat' => 'required',
      'telepon' => 'required',
    ];
  }
}
