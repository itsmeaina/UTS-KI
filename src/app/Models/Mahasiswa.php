<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Mahasiswa extends Model
{
    protected $primaryKey = 'nim';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'name',
        'nim',
        'jurusan_id',
        'course_id',
        'email',
        'gender',
        'phone',
        'date_of_birth',
        'status',
    ];

    // RELASI
    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'jurusan_id');
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mahasiswa) {
            $jurusanId = $mahasiswa->jurusan_id;

            $latest = self::where('jurusan_id', $jurusanId)
                ->orderByDesc('nim')
                ->first();

            if ($latest) {
                $lastSequence = intval(substr($latest->nim, 3));
                $nextSequence = $lastSequence + 1;
            } else {
                $nextSequence = 1;
            }

            $mahasiswa->nim = $jurusanId . str_pad($nextSequence, 4, '0', STR_PAD_LEFT);
        });
    }
}
