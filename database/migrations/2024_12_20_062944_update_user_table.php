<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::table('user', function (Blueprint $table) {
        $table->string('telepon')->nullable()->change(); // Mengubah kolom telepon menjadi nullable
    });
}

public function down()
{
    Schema::table('user', function (Blueprint $table) {
        $table->string('telepon')->nullable(false)->change(); // Membalikkan perubahan jika rollback
    });
}
}
