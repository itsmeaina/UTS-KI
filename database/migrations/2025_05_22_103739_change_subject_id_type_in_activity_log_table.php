<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class ChangeSubjectIdTypeInActivityLogTable extends Migration
{
    public function up()
    {
        // Tambahkan kolom sementara bertipe varchar
        Schema::table('activity_log', function (Blueprint $table) {
            $table->string('subject_id_temp')->nullable();
        });

        // Salin isi kolom subject_id ke kolom sementara sebagai string
        DB::table('activity_log')->update([
            'subject_id_temp' => DB::raw('CAST(subject_id AS CHAR)')
        ]);

        // Hapus kolom subject_id lama
        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropColumn('subject_id');
        });

        // Ubah nama kolom sementara menjadi subject_id
        Schema::table('activity_log', function (Blueprint $table) {
            $table->string('subject_id')->nullable()->after('event');
        });

        DB::table('activity_log')->update([
            'subject_id' => DB::raw('subject_id_temp')
        ]);

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropColumn('subject_id_temp');
        });
    }

    public function down()
    {
        // Jika ingin rollback, lakukan langkah sebaliknya
        Schema::table('activity_log', function (Blueprint $table) {
            $table->integer('subject_id_temp')->nullable();
        });

        DB::table('activity_log')->update([
            'subject_id_temp' => DB::raw('CAST(subject_id AS UNSIGNED)')
        ]);

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropColumn('subject_id');
        });

        Schema::table('activity_log', function (Blueprint $table) {
            $table->integer('subject_id')->nullable()->after('event');
        });

        DB::table('activity_log')->update([
            'subject_id' => DB::raw('subject_id_temp')
        ]);

        Schema::table('activity_log', function (Blueprint $table) {
            $table->dropColumn('subject_id_temp');
        });
    }
}