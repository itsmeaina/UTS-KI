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

            // Buat inisial dari nama fakultas
            $words = explode(' ', $fakultas->nama_fakultas);
            $inisialFakultas = '';
            foreach ($words as $word) {
                $inisialFakultas .= strtoupper(substr($word, 0, 1));
            }

            // Ambil angka terakhir dari seluruh fakultas_id (tidak peduli inisial)
            $lastFakultas = self::orderByRaw("CAST(SUBSTRING(fakultas_id, LENGTH(fakultas_id) - 1) AS UNSIGNED) DESC")
                ->first();

            if ($lastFakultas) {
                $lastNumber = intval(substr($lastFakultas->fakultas_id, -2)); // dua digit terakhir
                $newNumber = $lastNumber + 1;
            } else {
                $newNumber = 1;
            }

            // Buat fakultas_id = inisial + nomor global
            $fakultas->fakultas_id = $inisialFakultas . str_pad($newNumber, 2, '0', STR_PAD_LEFT);
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

}

