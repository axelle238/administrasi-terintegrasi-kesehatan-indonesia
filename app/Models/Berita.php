<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Berita extends Model
{
    use HasFactory;

    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'thumbnail',
        'kategori',
        'status',
        'views',
        'user_id'
    ];

    public function penulis()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
