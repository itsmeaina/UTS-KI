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
        Schema::create('k_h_s', function (Blueprint $table) {
            $table->string('nim', 50);
            $table->string('semester', 20);
            $table->string('thn_akademik', 20);
            $table->string('nilai_huruf', 5);
            $table->string('nilai_angka', 5);
            $table->string('course_id', 20);
            $table->timestamps();

            $table->primary(['nim', 'course_id', 'semester', 'thn_akademik']);
            $table->foreign('nim')->references('nim')->on('mahasiswas')->onDelete('cascade');
            $table->foreign('course_id')->references('course_id')->on('courses')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('k_h_s');
    }
};
