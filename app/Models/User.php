<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable;

  /**
   * The attributes that are mass assignable.
   *
   * @var string[]
   */
  protected $table = 'user'; 
  protected $primaryKey = 'id_user'; 
  protected $fillable = ['username', 'password', 'telepon', 'role', 'foto'];

  // Jika tidak ingin menggunakan timestamp created_at dan updated_at
  public $timestamps = true;

  protected $hidden = [
    'password',
    'remember_token',
  ];

  public function pasien()
  {
      // return $this->hasOne(Pasien::class, 'id_user', 'id_user');
      return $this->hasOne(Pasien::class, 'id_user');
  }

  public function fisioterapis()
{
    return $this->hasOne(Fisioterapis::class, 'id_user'); // Sesuaikan dengan kolom foreign key
}

public function rekamMedis()
{
    return $this->hasMany(RekamMedis::class, 'id_user', 'id_user');
}
}
