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
        Schema::create('dosen_course', function (Blueprint $table) {
            $table->string('nip', 20);
            $table->string('course_id', 20);
            $table->string('jurusan_id', 20);
            $table->string('thn_akademik', 20);
            $table->string('semester', 8);
            $table->string('tanggal', 10);
            $table->string('waktu_mulai', 15);
            $table->string('waktu_selesai', 15);
            $table->string('ruang', 6);
            $table->timestamps();

            $table->primary(['nip', 'thn_akademik', 'semester', 'tanggal', 'waktu_mulai','waktu_selesai', 'ruang']);
            $table->foreign('nip')->references('nip')->on('dosens');
            $table->foreign('course_id')->references('course_id')->on('courses');
            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusans');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dosen_course');
    }
};
