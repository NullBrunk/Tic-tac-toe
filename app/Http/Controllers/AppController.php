<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User_join;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class AppController extends Controller
{
    public function generate() {
        
        // Generate a token
        $uuid = Str::random(40);
    
        // Create the game
        Game::create([
            "gameid" => $uuid
        ]);

        // Redirect to the page
        return to_route("app.join_game", $uuid);
    }

    public function join_game(string $id) {
        $joined_user = User_join::where("gameid", "=", $id);

        $count = $joined_user -> count();
        if($count === 2 && $joined_user -> where("player", "=", session("id")) -> count() === 0) {
            return abort(403);
        }

        User_join::create([
            "gameid" => $id,
            "player" => session("id"),
            "symbol" => $count === 0 ? "O" : "X",
        ]);
    }
}
