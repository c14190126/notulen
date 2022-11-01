<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Perusahaan extends Model
{
    use HasFactory;

    protected $guarded = [
        'id',
    ];

    public function klien()
    {
        return $this->belongsTo(klien::class);
    }
    public function notulen()
    {
        return $this->hasMany(notulen::class);
    }
}
