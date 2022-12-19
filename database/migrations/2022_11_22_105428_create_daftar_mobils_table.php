<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('daftar_mobils', function (Blueprint $table) {
            $table->id();
            $table->integer('id_cabang');
            $table->string('model');
            $table->string('tipe');
            $table->string('kapasitas');
            $table->integer('harga');
            $table->longText('deskripsi');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('daftar_mobils');
    }
};
