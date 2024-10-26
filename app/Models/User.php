<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin IdeHelperUser
 */
class User extends Model implements Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        "created_at" => "date",
    ];

    public function get_joined_games(): BelongsToMany {
        return $this->belongsToMany(Game::class, "user_joins");
    }


    // Implementation des méthodes de l'interface Authenticatable pour que
    // notre model user custom marche avec filament
    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName(): string {
        return "id";
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier(): mixed {
        return $this->id;
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword(): string {
       return $this->password;
    }

    /**
     * Get the token value for the "remember me" session.
     * @return string
     */
    public function getRememberToken(): string {
        return "Not implemented";
    }

    public function setRememberToken($value): void {
        // Not implemented
    }

    public function getRememberTokenName(): string {
        return "Not implemented";
    }

}
