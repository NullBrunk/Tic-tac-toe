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
     * Génère un ID sur 4 caractère pour identifer une Game de manière unique
     * ainsi que de créé la game avec cet identifiant
     *
     * @return route        Route permettant de rejoindre cette Game créé
     */
    public function create() {
        
        # Génère l'ID unique sur 4 caractères
        $uuid = Str::random(4);
    
        # Créé la game en base de donnée à l'aide du Model
        Game::create([
            "gameid" => $uuid,
            "winner" => null
        ]);

        # Retourne à la route permettant de rejoindre la partie que nous venons de créer
        return to_route("games.join", $uuid);
    }

    /**
     * Rejoindre une partie
     *
     * @param string $id        L'ID unique de la Game sur 4 caractères
     * 
     * @return view|403|404      Une vue affichant le morpion ou une 403 si on n'a pas le droit
     *                           de rejoindre cette partie, ou une 404 si la partie n'existe pas          
     */
    public function join(string $id) {
        # Vérifier que la game existe
        Game::where("gameid", $id) -> firstorfail();
        
        # On recupère tous les utilisateurs qui ont rejoint la Game
        $joined_user = User_join::where("gameid", $id);

        # On les compte
        $count = $joined_user -> count();
        
        # Si cette variable vaut true, ca veut dire que l'utilisateur actuel n'a pas rejoint la game
        # sinon l'utilisateur a déja rejoint la game

        $user_has_not_join = $joined_user -> where("player", session("id")) 
                             -> count() === 0;
        
        # Si deux utilisateurs ont déja rejoint la partie et que l'utilisateur qui fait la requete
        # ne l'a pas rejoint
        if($count === 2 && $user_has_not_join) {
            return abort(403);
        } 

        # Si il y a moins de deux joueurs et que l'utilisateur courant n'a pas rejoint la partie
        else if($user_has_not_join) {
            # Alors on la rejoint

            # On attribue le bon symbole
            $symbol = $count === 0 ? "O" : "X";

            # On rejoint la partie
            User_join::create([
                "gameid" => $id,
                "player" => session("id"),
                "symbol" => $symbol,
            ]);

            # On met le symbole attribué en cache
            session(["symbol" => $symbol]);
        }


        return view("app.games.morpion", [ 
            "gameid" => $id, 
        ]);
    }
    

    /**
     * Check if the placed pawn led to a win or a draw or nothing
     *
     * @param array $morpion        The morpion
     * @param integer $position     The position of the placed pawn (from 0 to 8)
     * @param string $id            The unique ID of the game
     * 
     * @return void                 Update the database "winner" row
     */
    public static function check_win(array $morpion, int $position, string $id) {

        if(Game::where("gameid", $id) -> first() -> winner !== null) {
            return;
        }

        $x = $position / 3;
        $y = $position % 3;
        $pion = $morpion[$x][$y];

        if(MorpionController::check_win($morpion, $x, $y)) {
            Game::where("gameid", $id) -> update([
                "winner" => $pion
            ]);
            return;
        }
        else if(User_play::where("gameid", $id) -> get() -> count() === 9) {
            Game::where("gameid", $id) -> update([
                "winner" => "draw"
            ]);
        }
    }
    
    /**
     * Permet à l'utilisateur de jouer un coup en enregistrant ce dernier dans la base de donnée
     * 
     *  @param string $id           L'id unique de la game
     *  @param int $case            La position (int de 0 à 8) de la case sur laquelle 
     *                              l'utilisateur à cliqué
     * 
     * 
     */
    public static function store(string $id, int $position) {

        # Utilisateurs qui ont rejoint la game
        $players = User_join::where("gameid", $id);

        # Tous les coups joués pendant la partie
        $game_coups = User_play::where("gameid", $id);
        
        # Recupère le dernier coup joué
        $last_turn = $game_coups -> get() -> last();
        
        # Test tout ce qui rend interdit au joueur de jouer un coup à cet endroit
        if(
            # La partie est finie
            Game::where("gameid", $id) -> get() -> first() -> winner !== null
            
            # Ou alors la partie n'a pas encore commencé
            || $players -> get() -> count() !== 2

            # Ou alors le joueur essaye de jouer deux fois d'affilé
            || isset($last_turn) && $last_turn -> userid === session("id") 
        ) {
            return;
        }

        # Si l'utilisateur rejoint une autre game en meme temps, et qu'il a un symbol différent, 
        # et que la session n'est pas mise à jour, il se peut qu'en revenant sur la game initiale
        # il reusisse à changer de symbole.
        
        # Cette ligne est la pour être sur que ce genre de chose ne se produise pas
        $symbol = $players 
                -> where("player", session("id")) 
                -> get() 
                -> first() 
                -> symbol;
        session(["symbol" => $symbol]);

        # Si il n'y a pas déja un symbole placé ici
        if(sizeof(
                $game_coups -> where("position", $position) 
                -> get() 
                -> toArray()
            ) === 0
        ) {
            # Si il n'y en a pas, on place le symbole
            User_play::create([
                "gameid" => $id,
                "userid" => session("id"),
                "position" => $position,
                "symbol" => $symbol        
            ]);

        } else {
            # Sinon on retourne
            return;
        }
    }
}
