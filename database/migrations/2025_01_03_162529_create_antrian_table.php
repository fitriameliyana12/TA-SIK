<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAntrianTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('antrian', function (Blueprint $table) {
            $table->id('id_antrian'); // Menggunakan 'id_antrian' sebagai primary key
            $table->unsignedBigInteger('id_pasien'); // Kolom ID Pasien
            $table->unsignedBigInteger('id'); // Menggunakan 'id' untuk ID Fisioterapis (kolom berbeda)
            $table->integer('usia'); // Kolom usia pasien
            $table->text('keluhan'); // Kolom keluhan pasien
            $table->date('tanggal_terapi'); // Kolom tanggal terapi
            $table->time('jam_terapi'); // Kolom jam terapi
            $table->string('status')->default('tertunda'); // Status antrian, default 'tertunda'
            $table->timestamps(); // Kolom created_at dan updated_at

            // Relasi ke tabel pasien dan fisioterapis
            $table->foreign('id_pasien')->references('id_pasien')->on('pasien')->onDelete('cascade');
            $table->foreign('id')->references('id')->on('fisioterapis')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('antrian');
    }
}
