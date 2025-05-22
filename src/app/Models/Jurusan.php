<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jurusan extends Model
{
    protected $table = 'jurusan';

    protected $primaryKey = 'jurusan_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['jurusan_id', 'nama_jurusan', 'fakultas_id'];

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id', 'fakultas_id');
    }

    public function mahasiswas(): HasMany
    {
        return $this->hasMany(Mahasiswa::class, 'jurusan_id', 'jurusan_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }

    public function dosens(): HasMany
    {
        return $this->hasMany(Dosen::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($jurusan) {
            if (empty($jurusan->nama_jurusan)) {
                throw new \Exception('Nama jurusan harus diisi.');
            }
            if (empty($jurusan->fakultas_id)) {
                throw new \Exception('Fakultas harus diisi.');
            }

            $words = explode(' ', $jurusan->nama_jurusan);
            $inisialJurusan = '';
            foreach ($words as $word) {
                $inisialJurusan .= strtoupper(substr($word, 0, 1));
            }

            $nomorFakultas = $jurusan->fakultas_id;

            $baseId = $inisialJurusan . $nomorFakultas;

            $countExisting = self::where('jurusan_id', 'LIKE', $baseId . '%')->count();

            if ($countExisting > 0) {
                $jurusan->jurusan_id = $baseId . '-' . str_pad($countExisting + 1, 2, '0', STR_PAD_LEFT);
            } else {
                $jurusan->jurusan_id = $baseId;
            }
        });
    }
}
