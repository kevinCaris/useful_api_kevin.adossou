<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modules extends Model
{
    /** @use HasFactory<\Database\Factories\ModulesFactory> */
    use HasFactory;

      protected $fillable = [
        'name',
        'description',
    ];

  public function users()
    {
        return $this->belongsToMany(user::class, 'user_modules')
            ->withPivot('active')
            ->withTimestamps();
    }
}
