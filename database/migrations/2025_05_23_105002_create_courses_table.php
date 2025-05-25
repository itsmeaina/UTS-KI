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
        Schema::create('courses', function (Blueprint $table) {
            $table->string('course_id')->primary();  
            $table->string('nama_mata_kuliah');
            $table->string('bidang_mata_kuliah');
            $table->integer('sks')->default(3);
            $table->unsignedTinyInteger('semester');
            $table->string('jurusan_id')->nullable();            
            $table->timestamps();

            $table->foreign('jurusan_id')->references('jurusan_id')->on('jurusans')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
