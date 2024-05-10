<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User_join;
use App\Models\User_move;
use Illuminate\Support\Str;
use App\Http\Controllers\MorpionController;

// for type declaration
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class GamesController extends Controller
{
    /**
     * Generate a 4 char random ID to uniqely identify a game, and creates the 
     * game with this id in the table
     *
     * @return \Illuminate\Http\RedirectResponse        Return to the "join game" route
     */
    public function create(): RedirectResponse {
        
        // Génère l'ID unique sur 4 caractères
        $uuid = Str::random(4);
    
        // Créé la game ayant cet ID dans la table DB
        Game::create([
            "id" => $uuid,
            "winner" => null
        ]);

        // Retourne à la route permettant de rejoindre la partie que nous venons de créer
        return to_route("games.join", $uuid);
    }

    /**
     * Join a
     *
     * @param Game $game                    The game through model binding
     * 
     * @return \Illuminate\View\View        A view displaying the morpion, or a 403 if we are not
     *                                      authorized to join the game, or a 404 if the game doesn't exists
     */
    public function join(Game $game): View {
        // On recupère tous les utilisateurs qui ont rejoint la Game
        $joined = $game->get_joined_users()->get();
        
        // Si cette variable vaut true, l'utilisateur actuel a pas rejoint la game
        $user_joined = $joined->where("id", session("id"))->count() !== 0;
        

        if($joined->count() === 2 && !$user_joined)
            return abort(403);


        // Si l'utilisateur courant n'a pas rejoint la partie
        else if(!$user_joined) {
            // Alors on la rejoint

            // On attribue le bon symbole
            $symbol = $joined->count() === 0 ? "O" : "X";

            // On rejoint la partie
            User_join::create([
                "game_id" => $game->id,
                "user_id" => session("id"),
                "symbol" => $symbol,
            ]);

            // On met le symbole attribué en cache
            session(["symbol" => $symbol]);
        }


        return view("app.games.morpion", [ 
            "game_id" => $game->id, 
        ]);
    }
    

    /**
     * Check if the placed pawn led to a win or a draw or nothing
     *
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

        $check_win = MorpionController::check_win($morpion, $position);
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
    

    /**
     * Play a turn by placing a pawn on a given case (0 to 8)
     * 
     * @param string $id        The unique ID of the game
     * @param int $case         The position of the pawn 
     * 
     * @return null
     */
    public static function store(Game $game, int $position): null {

        // Utilisateurs qui ont rejoint la game
        $joined = $game->get_joined_users()->get();

        // Tous les coups joués pendant la partie
        $move = $game->get_played_move()->get();
        

        // Test tout ce qui rend interdit au joueur de jouer un coup à cet endroit
        if(
            // La partie est finie
            $game->winner !== null
            
            // Ou alors la partie n'a pas encore commencé
            || $joined->count() !== 2

            // Ou alors le joueur essaye de jouer deux fois d'affilé
            || $move->last()?->user_id === session("id") 

            // Ou alors il y a déjà un symbole placé ici
            || $move->where("position", $position)->count() !== 0
        ) {
            return null;
        } 

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
}
