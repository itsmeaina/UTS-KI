<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\BelongsTo;
use Illuminate\Database\Eloquent\BelongsToMany;

class Course extends Model
{
    protected $primaryKey = 'course_id';
    public $incrementing = false;
    protected $keyType = 'string';


    public function jurusan(): BelongsTo
    {
        return $this->belongsTo(Jurusan::class);
    }

    public function mahasiswas(): BelongsToMany
    {
        return $this->belongsToMany(Mahasiswa::class);
    }

    public function dosens(): BelongsToMany
    {
        return $this->belongsToMany(Dosen::class, 'course_dosen', 'course_id', 'dosen_nip');
    }

    protected $fillable = ['name'];
}
