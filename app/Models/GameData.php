<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameData extends Model
{
    protected $table = 'game_data';
    protected $fillable = [
        "game_name", "game_type"
    ];

}
