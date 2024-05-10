<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "created_at" => "date",
    ];

    public function get_joined_games() {
        return $this->belongsToMany(Game::class, "user_joins");
    }
}
