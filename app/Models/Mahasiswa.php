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
        'nim',
        'nama_mahasiswa',
        'jenis_kelamin',
        'jurusan_id',
        'date_birth',
        'year_admission',
        'status',
    ];

    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class,'jurusan_id', 'jurusan_id' );
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($mahasiswa) {
            if (empty($mahasiswa->year_admission)) {
                throw new \Exception('Tahun masuk (admission_year) harus diisi.');
            }

            if (empty($mahasiswa->jurusan_id)) {
                throw new \Exception('Jurusan harus diisi.');
            }

            $admissionYear = $mahasiswa->year_admission;

            // Ambil 3 digit angka paling akhir dari jurusan_id
            preg_match('/(\d{3})$/', $mahasiswa->jurusan_id, $matches);
            if (!isset($matches[1])) {
                throw new \Exception('Format jurusan_id tidak valid. Harus mengandung 3 angka di akhir.');
            }

            $jurusanCode = $matches[1]; // Misal: '101'
            $prefix = $admissionYear . $jurusanCode;

            // Ambil semua mahasiswa dengan jurusan yang sama (tanpa memperhatikan tahun)
            $latest = self::where('nim', 'like', '%'.$jurusanCode.'%')
                ->orderByDesc('nim')
                ->first();

            if ($latest) {
                // Ambil 2 digit terakhir
                $lastSequence = intval(substr($latest->nim, -2));
                $nextSequence = $lastSequence + 1;
            } else {
                $nextSequence = 1;
            }

            // Set NIM
            $mahasiswa->nim = $prefix . str_pad($nextSequence, 2, '0', STR_PAD_LEFT);
        });
    }

}
