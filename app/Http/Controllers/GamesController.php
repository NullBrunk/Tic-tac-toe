<?php

namespace App\Http\Controllers;

use App\Http\Controllers\MorpionController;
use App\Models\Game;
use App\Models\User_join;
use App\Models\User_play;
use Illuminate\Support\Str;

class GamesController extends Controller
{
    /**
     * Generate a 4 char random ID to uniqely identify a game, and creates the 
     * game with this id in the table
     *
     * @return route        Return to the "join game" route
     */
    public function create() {
        
        // Génère l'ID unique sur 4 caractères
        $uuid = Str::random(4);
    
        // Créé la game ayant cet ID dans la table DB
        Game::create([
            "gameid" => $uuid,
            "winner" => null
        ]);

        // Retourne à la route permettant de rejoindre la partie que nous venons de créer
        return to_route("games.join", $uuid);
    }

    /**
     * Join a
     *
     * @param string $id           The ID of the game to join
     * 
     * @return view|403|404        A view displaying the morpion, or a 403 if we are not
     *                             authorized to join the game, or a 404 if the game doesn't exists
     */
    public function join(string $id) {
        // Vérifier que la game existe
        Game::where("gameid", $id)->firstorfail();
        
        // On recupère tous les utilisateurs qui ont rejoint la Game
        $joined_user = User_join::where("gameid", $id);

        // On les compte
        $count = $joined_user->count();
        
        // Si cette variable vaut true, ca veut dire que l'utilisateur actuel n'a pas rejoint la game
        // sinon l'utilisateur a déja rejoint la game

        $user_has_not_join = $joined_user->where("player", session("id")) 
                            ->count() === 0;
        
        // Si deux utilisateurs ont déja rejoint la partie et que l'utilisateur qui fait la requete
        // ne l'a pas rejoint
        if($count === 2 && $user_has_not_join) {
            return abort(403);
        } 

        // Si il y a moins de deux joueurs et que l'utilisateur courant n'a pas rejoint la partie
        else if($user_has_not_join) {
            // Alors on la rejoint

            // On attribue le bon symbole
            $symbol = $count === 0 ? "O" : "X";

            // On rejoint la partie
            User_join::create([
                "gameid" => $id,
                "player" => session("id"),
                "symbol" => $symbol,
            ]);

            // On met le symbole attribué en cache
            session(["symbol" => $symbol]);
        }


        return view("app.games.morpion", [ 
            "gameid" => $id, 
        ]);
    }
    

    /**
     * Check if the placed pawn led to a win or a draw or nothing
     *
     * @param array $morpion           The morpion
     * @param integer $position        The position of the placed pawn (from 0 to 8)
     * @param string $id               The unique ID of the game
     * 
     * @return void                    Update the database "winner" row
     */
    public static function check_win(array $morpion, int $position, string $id) {

        // Si la game est déjà finie, on quitte la fonction
        if(Game::where("gameid", $id)->first()->winner !== null) {
            return;
        }

        // On converti un nombre de 0 à 8 en sa position dans un tableau 2D
        $x = $position / 3;
        $y = $position % 3;
        $pion = $morpion[$x][$y];

        // Si on gagne
        if(MorpionController::check_win($morpion, $x, $y)) {
            // Update la table pour indiquer qui a gagné
            Game::where("gameid", $id)->update([
                "winner" => $pion
            ]);
            return;
        }
        // Sinon si c'est le 9ème coup
        else if(User_play::where("gameid", $id)->get()->count() === 9) {
            // Update la table pour indiquer que c'est un match nul
            Game::where("gameid", $id)->update([
                "winner" => "draw"
            ]);
        }
    }
    

    /**
     * Play a turn by placing a pawn on a given case (0 to 8)
     * 
     * @param string $id        The unique ID of the game
     * @param int $case         The position of the pawn 
     * 
     * @return null|void
     */
    public static function store(string $id, int $position) {

        // Utilisateurs qui ont rejoint la game
        $players = User_join::where("gameid", $id);

        // Tous les coups joués pendant la partie
        $game_coups = User_play::where("gameid", $id);
        
        // Recupère le dernier coup joué
        $last_turn = $game_coups->get()->last();
        
        // Test tout ce qui rend interdit au joueur de jouer un coup à cet endroit
        if(
            // La partie est finie
            Game::where("gameid", $id)->get()->first()->winner !== null
            
            // Ou alors la partie n'a pas encore commencé
            || $players->get()->count() !== 2

            // Ou alors le joueur essaye de jouer deux fois d'affilé
            || isset($last_turn) && $last_turn->userid === session("id") 
        ) {
            return;
        }

        // Si l'utilisateur rejoint une autre game en meme temps, et qu'il a un symbol différent, 
        // et que la session n'est pas mise à jour, il se peut qu'en revenant sur la game initiale
        // il reusisse à changer de symbole.
        
        // Cette ligne est la pour être sur que ce genre de chose ne se produise pas
        $symbol = $players 
            ->where("player", session("id")) 
            ->get() 
            ->first() 
            ->symbol;
        
        session(["symbol" => $symbol]);

        // Si il n'y a pas déja un symbole placé ici
        if(sizeof(
                $game_coups->where("position", $position) 
               ->get() 
               ->toArray()
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
            // Sinon on retourne
            return;
        }
    }
}
