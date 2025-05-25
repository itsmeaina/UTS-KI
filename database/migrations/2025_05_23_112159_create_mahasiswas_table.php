<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->string('nim')->primary();
            $table->string('nama_mahasiswa')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('jurusan_id');
            $table->date('date_birth')->nullable();
            $table->year('year_admission')->nullable();
            $table->string('status');
            $table->timestamps();

            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mahasiswas');
    }
};
