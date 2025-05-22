<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'api_token'];
    public function products(){
        return $this->HasMany(product::class);
    }
}
