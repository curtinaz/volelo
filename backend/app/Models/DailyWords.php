<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyWords extends Model
{
    use HasFactory;

    protected $fillable = [
        "word",
        "game_date"
    ];
}
