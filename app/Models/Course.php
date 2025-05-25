<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Course extends Model
{
    protected $primaryKey = 'course_id';  
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['course_id', 'nama_mata_kuliah', 'bidang_mata_kuliah', 'semester'];

    protected static function booted()
    {
        static::creating(function ($course) {
            $singkatan = collect(explode(' ', $course->bidang_mata_kuliah))
                ->map(fn ($word) => strtoupper(substr($word, 0, 1)))
                ->join('');

            $semester = $course->semester; 

            $count = self::where('bidang_mata_kuliah', $course->bidang_mata_kuliah)
                         ->where('semester', $semester)
                         ->count() + 1;

            $kode = $singkatan . $semester . str_pad($count, 2, '0', STR_PAD_LEFT);

            $course->course_id = $kode;
        });
    }

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'jurusan_id');
    }

    public function mahasiswas(): BelongsToMany
    {
        return $this->belongsToMany(Mahasiswa::class, 'course_mahasiswa', 'course_id', 'nim');
    }

    public function dosens(): BelongsToMany
    {
        return $this->belongsToMany(Dosen::class, 'course_dosen', 'course_id', 'dosen_nip');
    }

    public function pengajar()
    {
        return $this->hasMany(DosenCourse::class, 'course_id', 'course_id');
    }

}
