<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Opname extends Model
{
    use HasFactory;

    protected $fillable = ['tanggal', 'user_id', 'keterangan', 'status'];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function details()
    {
        return $this->hasMany(OpnameDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}