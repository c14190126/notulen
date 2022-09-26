<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotesNotulen extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function notulen()
    {
        return $this->belongsTo(notulen::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }
}
