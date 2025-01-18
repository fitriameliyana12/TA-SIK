<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fisioterapis extends Model
{
  use HasFactory;
  protected $guarded = ['id'];
  protected $table = 'fisioterapis'; // Nama tabel
  protected $primaryKey = 'id'; // Primary key
  
  protected $fillable = [
    'nama',
    'tanggal_lahir',
    'alamat',
    'jenis_kelamin',
    'kehadiran',
    'id_user', // pastikan id_user termasuk di sini
];

  public function pasiens()
  {
    return $this->hasMany(Pasien::class);
  }
  public $timestamps = false;

  public function pasien()
{
    return $this->belongsTo(Pasien::class, 'id_pasien');
    return $this->hasMany(Pasien::class, 'id_fisioterapis');
}

public function antrian()
{
    return $this->hasMany(Antrian::class, 'id');
}

public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
        // return $this->belongsTo(User::class, 'id_user');
    }

    public function rekamMedis()
{
    return $this->hasMany(RekamMedis::class, 'id', 'id');
}


}
