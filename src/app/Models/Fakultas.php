<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fakultas extends Model
{
    protected $primaryKey = 'fakultas_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['nama_fakultas'];


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($fakultas) {
            \Log::info('Model nama_fakultas saat creating:', [$fakultas->nama_fakultas]);

            if (empty($fakultas->nama_fakultas)) {
                throw new \Exception('Nama fakultas harus diisi.');
            }

            $words = explode(' ', $fakultas->nama_fakultas);
            $inisialFakultas = '';
            foreach ($words as $word) {
                $inisialFakultas .= strtoupper(substr($word, 0, 1));
            }

            $countExisting = self::where('fakultas_id', 'LIKE', $inisialFakultas . '%')->count();

            $fakultas->fakultas_id = $inisialFakultas . str_pad($countExisting + 1, 2, '0', STR_PAD_LEFT);
        });
    }

    public function jurusans(): HasMany
    {
        return $this->hasMany(Jurusan::class, 'fakultas_id', 'fakultas_id');
    }

    public function getJumlahJurusanAttribute(): int
    {
        return $this->jurusans()->count();
    }

    public function getJumlahMahasiswaAttribute(): int
    {
        return $this->jurusans()->withCount('mahasiswas')->get()->sum('mahasiswas_count');
    }
}

