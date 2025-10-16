<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    /** @use HasFactory<\Database\Factories\ShortLinkFactory> */
    use HasFactory;

     protected $fillable = [
        'user_id',
        'original_url',
        'code',
        'clicks',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
