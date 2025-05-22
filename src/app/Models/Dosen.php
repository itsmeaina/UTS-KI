<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Dosen extends Model
{
    protected $primaryKey = 'nip';      // definisikan primary key
    public $incrementing = false;       // karena bukan auto increment
    protected $keyType = 'string';      // tipe primary key string

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_dosen', 'dosen_nip', 'course_id');
    }
}
