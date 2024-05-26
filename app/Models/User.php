<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperUser
 */
class User extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "created_at" => "date",
    ];

    public function get_joined_games(): BelongsToMany {
        return $this->belongsToMany(Game::class, "user_joins");
    }
}
