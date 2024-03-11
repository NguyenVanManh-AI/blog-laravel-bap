<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Liked extends Model
{
    use HasFactory;

    protected $fillable = [
        'id', 'id_article', 'id_users',
    ];

    public function user()
    {
        return $this->belongsTo(Article::class);
    }
}
