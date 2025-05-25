<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Dosen extends Model
{
    protected $primaryKey = 'nip';      
    public $incrementing = false;       
    protected $keyType = 'string';      

    protected $fillable = [
        'nip',
        'nama_dosen',
        'jenis_kelamin',
        'email',
        'jurusan_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($dosen) {
            do {
                $randomId = str_pad(rand(0, 9999), 4, '0', STR_PAD_LEFT);

                $digits = str_split($randomId);

                $isAscending = true;
                $isDescending = true;
                for ($i = 1; $i < count($digits); $i++) {
                    if ((int)$digits[$i] !== (int)$digits[$i - 1] + 1) {
                        $isAscending = false;
                    }  
                    if ((int)$digits[$i] !== (int)$digits[$i - 1] - 1) {
                        $isDescending = false;
                    }
                }
                $isSequential = $isAscending || $isDescending;

                $allSame = count(array_unique($digits)) === 1;

            } while (
                $randomId === '1234' ||                  
                $isSequential ||                        
                $allSame ||                            
                self::where('nip', $randomId)->exists() 
            );

            $dosen->nip = $randomId;
        });
    }

    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class, 'jurusan_id', 'jurusan_id');
    }

    public function mengajar()
    {
        return $this->hasMany(DosenCourse::class, 'dosen_id', 'dosen_id');
    }


}
