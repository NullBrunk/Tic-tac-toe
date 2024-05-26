<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string|null $winner
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\GameFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Game newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Game query()
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Game whereWinner($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperGame {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $email
 * @property string $name
 * @property string $password
 * @property string|null $confirmation_token
 * @property string|null $secret
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereConfirmationToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $user_id
 * @property string $game_id
 * @property string $symbol
 * @method static \Illuminate\Database\Eloquent\Builder|User_join newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User_join newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User_join query()
 * @method static \Illuminate\Database\Eloquent\Builder|User_join whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User_join whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User_join whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser_join {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $user_id
 * @property string $game_id
 * @property string $symbol
 * @property string $position
 * @method static \Illuminate\Database\Eloquent\Builder|User_move newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User_move newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User_move query()
 * @method static \Illuminate\Database\Eloquent\Builder|User_move whereGameId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User_move wherePosition($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User_move whereSymbol($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User_move whereUserId($value)
 * @mixin \Eloquent
 */
	#[\AllowDynamicProperties]
	class IdeHelperUser_move {}
}

