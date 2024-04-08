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

        $game = Game::where("gameid", "=", $id) -> get() -> first();

        return view("app.morpion", [ 
            "morpion" => $morpion, 
            "alone" => $count === 1, 
            "gameid" => $id, 
            "winner" => $game -> winner,
            "isended" => $game -> isended
        ]);
    }

    
    public function get_morpion(string $id): array {
        $coups = User_play::where("gameid", "=", $id) -> get();
        $morpion = [["", "", ""],["", "", ""],["", "", ""]];

        foreach($coups as $coup) {
            $pos = $coup -> position;
            
            $morpion[floor($pos/3)][$pos%3] = $coup -> symbol;
        }
        
        return $morpion;
    }
    
    public function check_win(array $morpion, int $position) {

        include_once "checkwin.php";

        $x = $position / 3;
        $y = $position % 3;

        return check_line($morpion, $x, $y) ||
            check_col($morpion, $x, $y) ||
            check_diagonale_dg($morpion, $x, $y) ||
            check_diagonale_gd($morpion, $x, $y);

    }
    
    /**
     *  @param string $id 
     *  @param int $case
     */
    public function users_plays(string $id, int $position) {

        $players = User_join::where("gameid", "=", $id);
        $game_coups = User_play::where("gameid", "=", $id);
        
        if(Game::where("gameid", "=", $id) -> get() -> first() -> isended) {
            return abort(401);
        }
        
        // There is only one player in the game
        if($players -> get() -> count() !== 2) {
            return abort(401);
        }
        
        // The player try to play 2 times in a row
        $last_turn = User_play::where("gameid", $id) -> get() -> last();

        if(isset($last_turn) && $last_turn -> userid === session("id")) {
            return abort(401);
        }
        

        $symbol = $players 
                -> where("player", "=", session("id")) 
                -> get() 
                -> first() 
                -> symbol;
        

        // Check si il y a deja un symbole placé la 
        if(sizeof(
                $game_coups -> where("position", "=", $position) 
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


            $win = self::check_win(self::get_morpion($id), $position);
            $ended = $game_coups -> count() === 9;

            if($win || $ended) {
                $game = Game::where("gameid", "=", $id);
                
                $game -> update([
                    "isended" => true
                ]); 

                if($ended) {
                    $game -> update([
                        "winner" => "draw"
                    ]);

                    return ["end" => 0];
                } 
                else {
                    $game -> update([
                        "winner" => $symbol
                    ]);

                    return ["end" => 1, "winner" => $symbol];
                }
            }

        } else {
            return abort(401);
        }

        return ["end" => -1];
    }
}
