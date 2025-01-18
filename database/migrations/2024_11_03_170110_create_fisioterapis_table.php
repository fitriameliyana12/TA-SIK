<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFisioterapisTable extends Migration
{
    public function up()
    {
        Schema::create('fisioterapis', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->date('tanggal_lahir');
            $table->string('telepon');
            $table->text('alamat');
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('kehadiran'); // Sesuaikan dengan tipe data yang tepat
        });
    }

    public function down()
    {
        Schema::dropIfExists('fisioterapis');
    }
}
