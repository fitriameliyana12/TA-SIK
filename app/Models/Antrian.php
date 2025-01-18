<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Antrian extends Model
{
  use HasFactory;
  // protected $guarded = ['id_antrian'];
  protected $primaryKey = 'id_antrian';
  public $timestamps = false;
  protected $table = 'antrian'; 
  protected $fillable = [
    'id_pasien',
    'id',
    'keluhan',
    'tanggal_terapi',
    'jam_terapi',
    'status',
];

  public function pasien()
{
    return $this->belongsTo(Pasien::class, 'id_pasien');
}

public function fisioterapis()
{
    return $this->belongsTo(Fisioterapis::class, 'id', 'id');
}

public function rekamMedis()
{
    return $this->hasOne(RekamMedis::class, 'id_antrian');
}

public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

}
