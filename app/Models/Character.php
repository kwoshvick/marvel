<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Character extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'marvel_id', 'description',
        'thumbnail', 'series', 'stories', 'comics'
        ];
}
