<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User_join;
use App\Models\User_play;
use Illuminate\Support\Str;



class AppController extends Controller
{
    /**
     * Generate a unique ID to identify a game
     *
     * @return route        Join the game with the generated ID
     */
    public function generate() {
        
        # Generate the random unique ID
        $uuid = Str::random(4);
    
        # Create a game with the generated ID
        Game::create([
            "gameid" => $uuid,
            "winner" => null
        ]);

        # And join the game that we just created
        return to_route("app.join_game", $uuid);
    }


    /**
     * Join a game
     *
     * @param string $id        The unique ID of the game to join
     * 
     * @return view|403         The view of the tictactoe board, or a 403 abort            
     */
    public function join_game(string $id) {
        # Get all the users that joined the game
        $joined_user = User_join::where("gameid", "=", $id);
        # Count them
        $count = $joined_user -> count();
        
        # Have you joined the game already ?
        $user_has_not_join = $joined_user -> where("player", "=", session("id")) -> count() === 0;
        
        # If there is already two users AND you have not joined the game
        if($count === 2 && $user_has_not_join) {
            return abort(403);
        } 

        # If there is less than two users in the game, AND you have not joined the game
        else if($user_has_not_join) {
            
            # Join the game
            $symbol = $count === 0 ? "O" : "X";

            User_join::create([
                "gameid" => $id,
                "player" => session("id"),
                "symbol" => $symbol,
            ]);
            session(["symbol" => $symbol]);
            $count++;
        }


        return view("app.morpion", [ 
            "gameid" => $id, 
        ]);
    }

    
    /**
     * Get a morpion
     *
     * @param string $id        The ID of the game
     * 
     * @return array            The morpion in form of a 2D array
     */
    public static function get_morpion(string $id): array {
        $coups = User_play::where("gameid", "=", $id) -> get();
        $morpion = [["", "", ""],["", "", ""],["", "", ""]];

        foreach($coups as $coup) {
            $pos = $coup -> position;
            
            $morpion[floor($pos/3)][$pos%3] = $coup -> symbol;
        }
        
        return $morpion;
    }
    

    /**
     * Check if the placed pawn led to a win or a draw or nothing
     *
     * @param array $morpion        The morpion
     * @param integer $position     The position of the placed pawn (from 0 to 8)
     * @param string $id            The unique ID of the game
     * 
     * @return void                 Update the database "winner" row, don't return
     */
    public static function check_win(array $morpion, int $position, string $id) {

        include_once "checkwin.php";

        $x = $position / 3;
        $y = $position % 3;
        $pion = $morpion[$x][$y];


        if(
            $pion !== "" && (
                check_line($morpion, $x, $y) ||
                check_col($morpion, $x, $y) ||
                check_diagonale_dg($morpion, $x, $y) ||
                check_diagonale_gd($morpion, $x, $y)
            )
        ) {
            Game::where("gameid", "=", $id) -> update([
                "winner" => $pion
            ]);
        }

        if(User_play::where("gameid", "=", $id) -> get() -> count() === 9) {
            Game::where("gameid", "=", $id) -> update([
                "winner" => "draw"
            ]);
        }
    }
    
    /**
     *  @param string $id 
     *  @param int $case
     */
    public static function users_plays(string $id, int $position) {

        $players = User_join::where("gameid", "=", $id);
        $game_coups = User_play::where("gameid", "=", $id);
        
        $last_turn = $game_coups -> get() -> last();
        
        if(
            Game::where("gameid", "=", $id) -> get() -> first() -> winner !== null
            // if there is only one player in the game
            || $players -> get() -> count() !== 2
            // The player try to play 2 times in a row
            || isset($last_turn) && $last_turn -> userid === session("id") 
        ) {
            // Exit the function
            return;
        }

        $symbol = $players 
                -> where("player", "=", session("id")) 
                -> get() 
                -> first() 
                -> symbol;
        session(["sybmol" => $symbol]);

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

        } else {
            return abort(401);
        }
    }
}
