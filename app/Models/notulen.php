<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class notulen extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function klien()
    {
        return $this->belongsTo(klien::class);
    }
    public function user()
    {
        return $this->belongsTo(user::class);
    }
    public function user_akses()
    {
        return $this->hasMany(user_akses::class);
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function($query, $search) {
            return $query->where(function($query) use ($search) {
                   $query->where('judul_meeting', 'like', '%' . $search . '%')
                         ->orWhere('isi_notulen', 'like', '%' . $search . '%')
                         ->orWhere('revisi_notulen', 'like', '%' . $search . '%');
            });
        });
    }
}
