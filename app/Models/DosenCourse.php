<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DosenCourse extends Model
{
    public $incrementing = false; 
    protected $primaryKey = null; 
    protected $table = 'dosen_course';

    protected $fillable = [
        'nip', 'course_id', 'jurusan_id', 'thn_akademik', 'semester', 'tanggal', 'waktu_mulai', 'waktu_selesai', 'ruang'
    ];

    public function getRouteKeyName()
    {
        return 'composite_key';
    }

    public function getRouteKey()
    {
        return implode('|', [
            $this->nip,
            $this->thn_akademik,
            $this->semester,
            $this->tanggal,
            $this->waktu_mulai,
            $this->waktu_selesai,
            $this->ruang,
        ]);
    }

    public function getCompositeKeyAttribute()
    {
        return $this->getRouteKey();
    }

    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'nip', 'nip');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'jurusan_id');
    }


}
