<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class KHS extends Model
{
    use HasFactory;

    protected $primaryKey = null;
    public $incrementing = false;
    protected $keyType = 'string'; 

        protected $compositeKey = ['nim', 'course_id', 'semester', 'thn_akademik'];

    protected $fillable = [
        'nim',
        'course_id',
        'semester',
        'thn_akademik',
        'nilai_huruf',
        'nilai_angka',
    ];

    // Hapus fungsi getKeyName supaya tidak override dengan array

    public function getKey()
    {
        return implode('_', array_map(fn($keyName) => $this->getAttribute($keyName), $this->compositeKey));
    }

    public function getRouteKeyName()
    {
        return 'composite_key';
    }

    public function getRouteKey()
    {
        return $this->composite_key;
    }

    public function getCompositeKeyAttribute()
    {
        return implode('_', array_map(function ($key) {
            return $this->getAttribute($key);
        }, $this->compositeKey));
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mahasiswa::class, 'nim', 'nim');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function scopeByMahasiswaDanMakul($query, $nim, $courseId, $semester, $tahunAkademik)
    {
        return $query->where([
            'nim' => $nim,
            'course_id' => $courseId,
            'semester' => $semester,
            'thn_akademik' => $tahunAkademik,
        ]);
    }
}

