<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan
    protected $table = 'rekam_medis';

    // Menentukan primary key
    protected $primaryKey = 'id_rekam_medis';
    // protected $fillable = ['id_antrian', 'evaluasi'];

    // Menghindari error karena timestamp
    public $timestamps = false;

    // Melindungi kolom id_rekam_medis agar tidak dapat diisi secara mass-assignment
    protected $guarded = ['id_rekam_medis'];

    /**
     * Relasi ke model Pasien
     * Rekam Medis milik satu Pasien
     */
    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    /**
     * Relasi ke model User
     * Rekam Medis terkait dengan User untuk data telepon
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke model Fisioterapis
     * Rekam Medis ditangani oleh satu Fisioterapis
     */
    public function fisioterapis()
    {
        return $this->belongsTo(Fisioterapis::class, 'id', 'id');
    }

    /**
     * Relasi ke model Antrian
     * Rekam Medis terkait dengan Antrian untuk keluhan dan tanggal terapi
     */
    public function antrian()
    {
        return $this->belongsTo(Antrian::class, 'id_antrian');
    }
}
