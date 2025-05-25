<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('jurusans', function (Blueprint $table) {
            $table->string('jurusan_id')->primary();
            $table->string('nama_jurusan');
            $table->string('fakultas_id');
            $table->timestamps();

            $table->foreign('fakultas_id')->references('fakultas_id')->on('fakultas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('jurusan', function (Blueprint $table) {
            $table->dropForeign(['fakultas_id']);
        });
        Schema::dropIfExists('jurusans');
    }

};
