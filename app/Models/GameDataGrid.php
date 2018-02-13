<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GameDataGrid extends Model
{
    protected $table = 'game_data_grid';
    protected $fillable = [
        "game_id", "grid"
    ];
}
