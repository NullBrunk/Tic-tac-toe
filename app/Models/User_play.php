<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_play extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        "gameid",
        "symbol",
        "position"
    ];
}
