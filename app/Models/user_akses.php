<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_akses extends Model
{
    protected $guarded = ['id'];
    use HasFactory;
    public function notulen()
    {
        return $this->belongsTo(notulen::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
