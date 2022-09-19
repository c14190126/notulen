<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class klien extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function notulen()
    {
        return $this->hasMany(notulen::class);
    }
}
