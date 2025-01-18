<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
  use HasFactory;
  protected $guarded = ['id_pasien'];
  protected $primaryKey = 'id_pasien';
  public $timestamps = false;
  protected $table = 'pasien'; 

  public function antrian()
{
    // return $this->hasOne(Antrian::class, 'id_pasien');
    return $this->hasMany(Antrian::class, 'id_pasien');
}

  public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
        // return $this->belongsTo(User::class, 'id_user');
    }

//     public function rekamMedis()
// {
//     return $this->hasMany(RekamMedis::class, 'id_pasien');
// }
public function fisioterapis()
{
    return $this->belongsTo(Fisioterapis::class, 'id');
}

public function rekamMedis()
{
    return $this->hasMany(RekamMedis::class, 'id_pasien', 'id_pasien');
}

public function riwayatTerapi()
{
    return $this->hasMany(RiwayatTerapi::class, 'id_pasien', 'id_pasien');
}

}
