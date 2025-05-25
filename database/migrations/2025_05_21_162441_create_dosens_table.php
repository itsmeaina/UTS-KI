<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dosens', function (Blueprint $table) {
            $table->string('nip')->primary();
            $table->string('nama_dosen');
            $table->string('jenis_kelamin');
            $table->string('email')->unique();
            $table->string('jurusan_id');
            $table->timestamps();

            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosens');
    }
};
