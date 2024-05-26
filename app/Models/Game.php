<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Game extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        "created_at" => "date",
    ];

    public function get_joined_users(): BelongsToMany {
        return $this->belongsToMany(User::class, "user_joins");
    }

    public function get_played_move(): HasMany {
        return $this->hasMany(User_move::class);
    }
}
