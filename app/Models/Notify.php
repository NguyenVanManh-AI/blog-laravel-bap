<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'id_user', 'id_article', 'id_from', 'is_like',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
