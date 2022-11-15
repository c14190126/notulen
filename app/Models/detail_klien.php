<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class detail_klien extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function klien()
    {
        return $this->belongsTo(klien::class);
    }
    public function perusahaan()
    {
        return $this->belongsTo(Perusahaan::class);
    }
    public function notulen()
    {
        return $this->belongsTo(notulen::class);
    }
}
