<?php

namespace App\Services;

use App\Models\Game;
use App\Models\User_move;


class MorpionService
{

    /**
     * Recupère tout les records liés à un morpion à partir de l'id unique de la game qui lui 
     * est associé afin de construire un tableau 2D représentant le morpion
     *
     * @param string $id        L'ID unique de la game associé
     * 
     * @return array            Un morpion sous forme d'un tableau 2D
     */
    public static function get_morpion(string $id): array {
        $coups = User_move::where("game_id", $id)->get();
        $morpion = [["", "", ""],["", "", ""],["", "", ""]];

        foreach($coups as $coup) {
            $pos = $coup->position;
            
            $morpion[(int)floor($pos/3)][$pos%3] = $coup->symbol;
        }
        
        return $morpion;
    }

    /**
     * Check if the user has the rights to do a move at this position
     *
     * @param Game $game            Current Game through model binding
     * @param integer $position     Pawn position
     * @return boolean              
     */
    public static function check_move_permissions(Game $game, int $position): bool {
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
            return false;
        } 

        return true;
    }

    /**
     * Test si le pion placé en position x,y permet la victoire en ligne, colone ou diagonale du joueur.
     *
     * @param array $morpion    Le morpion sous forme d'un tableau 2D
     * @param int $position     The position of the placed pawn
     *
     * @return array
     */
    public static function check_win(array $morpion, int $position): array {

        
        // On converti un nombre de 0 à 8 en sa position dans un tableau 2D
        $x = (int)floor($position / 3);
        $y = $position % 3;
        $symbol = $morpion[$x][$y];
        
        $mls = new MorpionLogicService($morpion, $x, $y);


        if($symbol === "") return [ "win" => false, "pawn" => null ];
        return [
            "win" => $mls->check_line() || $mls->check_col() || $mls->check_diagonale_dg() || $mls->check_diagonale_gd(),
            "pawn" => $symbol,
        ];
    }
}

