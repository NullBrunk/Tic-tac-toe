<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User_join;
use App\Models\User_play;
use Illuminate\Support\Str;

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
        
        $user_has_not_join = $joined_user -> where("player", "=", session("id")) -> count() === 0;
        if($count === 2 && $user_has_not_join) {
            return abort(403);
        } 
        else if($user_has_not_join) {
            $symbol = $count === 0 ? "O" : "X";

            User_join::create([
                "gameid" => $id,
                "player" => session("id"),
                "symbol" => $symbol,
            ]);
            session(["symbol" => $symbol]);
            $count++;
        }

        $morpion = [["", "", ""], ["", "", ""], ["", "", ""]];
        foreach(User_play::where("gameid", $id) -> get() -> toArray() as $coup) {
            $morpion[
                floor($coup["position"]/3)
            ]
            [
                $coup["position"]%3
            ] = $coup["symbol"];
        }

        return view("app.morpion", [ "morpion" => $morpion, "alone" => $count === 1, "gameid" => $id ]);
    }

    /**
     *  @param string $id 
     *  @param int $case
     */
    public function users_plays(string $id, int $position) {
        $players = User_join::where("gameid", "=", $id);
           
        // There is only one player in the game
        if($players -> get() -> count() !== 2) {
            return abort(401);
        }
        
        // The player try to play 2 times in a row
        if(User_play::where("gameid", $id) -> get() -> last() -> userid === session("id")) {
            return abort(401);
        }
        

        $symbol = $players 
                -> where("player", "=", session("id")) 
                -> get() 
                -> first() 
                -> symbol;
        
        // Check si il y a deja un symbole placé la 
        if(sizeof(
            User_play::where("gameid", "=", $id) 
                -> where("position", "=", $position) 
                -> get() 
                -> toArray()
            ) === 0
        ) {
            // Si il n'y en a pas, on place le symbole
            User_play::create([
                "gameid" => $id,
                "userid" => session("id"),
                "position" => $position,
                "symbol" => $symbol        
            ]);
        } else {
            return abort(401);
        }

    }
}
