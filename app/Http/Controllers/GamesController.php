<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User_join;
use App\Models\User_move;
use Illuminate\Support\Str;
use App\Services\MorpionService;

// for type declaration
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class GamesController extends Controller
{
    /**
     * Create a game in the database
     *
     * @return RedirectResponse    Return to the "join game" route
     */
    public function create(): RedirectResponse {
        
        // Créé la game ayant cet ID dans la table DB
        $game = Game::create([
            "id" => Str::random(4),
            "winner" => null
        ]);

        // Retourne à la route permettant de rejoindre la partie que nous venons de créer
        return to_route("games.join", $game->id);
    }


    /**
     * Join a game via the unique ID associated to it
     *
     * @param Game $game    The game through model binding
     * 
     * @return View         A view that displays the morpion, or a 403 or a 404
     */
    public function join(Game $game): View {
        // On recupère tous les utilisateurs qui ont rejoint la Game
        $joined = $game->get_joined_users()->get();
        
        // Vaudra true si l'utilisateur actuel n'a pas rejoint la game
        $user_joined = $joined->where("id", session("id"))->count() !== 0;
        
        // Si deux utilisateurs ont rejoint mais pas l'utilisateur actuel
        abort_if($joined->count() === 2 && !$user_joined, 403);

        // Si l'utilisateur courant n'a pas rejoint la partie
        if(!$user_joined) {
            // On rejoint la partie
            $join = User_join::create([
                "game_id" => $game->id,
                "user_id" => session("id"),
                "symbol" => $joined->count() === 0 ? "O" : "X",
            ]);

            // On met le symbole attribué en cache
            session(["symbol" => $join->symbol]);
        }

        return view("app.games.morpion", [ 
            "game_id" => $game->id, 
        ]);
    }


    /**
     * Play a move by placing a pawn on a given case
     *
     * @param Game $game       The game through model binding
     * @param int $position    The position of the pawn (from 0 to 8)
     *
     * @return null
     */
    public static function move(Game $game, int $position): null {

        if(!MorpionService::check_move_permissions($game, $position))
            return null;

        // Si l'utilisateur rejoint une autre game en meme temps, et qu'il a un symbol différent, 
        // et que la session n'est pas mise à jour, il se peut qu'en revenant sur la game initiale
        // il reusisse à changer de symbole.
        $symbol = User_join::where("game_id", $game->id)->where("user_id", session("id"))->first()->symbol;

        session(["symbol" => $symbol]);


        User_move::create([
            "game_id" => $game->id,
            "user_id" => session("id"),
            "position" => $position,
            "symbol" => $symbol        
        ]);

        return null;
    }


    /**
     * @param array $morpion           The morpion
     * @param integer $position        The position of the placed pawn (from 0 to 8)
     * @param string $id               The unique ID of the game
     * 
     * @return null                    Update the database "winner" row
     */
    public static function check_win(array $morpion, int $position, string $id): null {

        // Si la game est déjà finie, on quitte la fonction
        if(Game::where("id", $id)->first()->winner !== null) {
            return null;
        }

        $check_win = MorpionService::check_win($morpion, $position);
        if($check_win["win"] === true) {
            // Update la table pour indiquer qui a gagné
            Game::where("id", $id)->update([
                "winner" => $check_win["pawn"],
            ]);
            return null;
        }

        // Si c'est le 9ème coup
        if(User_move::where("game_id", $id)->count() === 9) {
            // Update la table pour indiquer que c'est un match nul
            Game::where("id", $id)->update([
                "winner" => "draw"
            ]);
        }

        return null;
    }
}
