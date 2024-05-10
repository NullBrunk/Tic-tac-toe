<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\User_join;
use Illuminate\Support\Facades\DB;

// for type declaration
use Illuminate\View\View;
use Illuminate\Database\Eloquent\Collection;


class SettingsController extends Controller
{

    /**
     * Get several informations about a given user (played/won/lost games... )
     *
     * @param integer $userid                                     The user id
     * 
     * @return \Illuminate\Database\Eloquent\Collection            The ORM response
     */
    private function get_general_stats(int $userid): Collection {
        // On désactive le mode "ONLY_FULL_GROUP_BY" qui est activé par défaut avec Laravel
        DB::statement("SET SQL_MODE=''");
                
        // On fait un inner join entre la table user_play et la tabke games pour récupérer les informations
        // qui nous intéressent
        return User_join::select("winner", "symbol") 
            ->join('games', 'games.gameid', '=', 'user_joins.gameid')
            ->where("player", $userid) 
            ->where("winner", "!=", null)
            ->get();
            
    }


    /**
     * Get the history of played games (player1, player2, winner)
     *
     * @param integer $userid                                     Id of the user to query
     * 
     * @return \Illuminate\Database\Eloquent\Collection            The ORM response
     */
    private function get_history(int $userid): Collection {
        return User_join::select(
            "users.email AS email_p1", 
            "users.name AS name_p1",
            "users2.email AS email_p2",
            "users2.name AS name_p2", 
            "user_joins.symbol AS join_p1",
            "user_joins2.symbol AS join_p2",
            "games.winner",
            "games.created_at",
        ) 
        ->join('user_joins as user_joins2', 
            function ($join) {
                $join->on('user_joins.gameid', '=', DB::raw("`user_joins2`.`gameid`"))
                     ->where('user_joins.player', '<>', DB::raw("`user_joins2`.`player`"));
            })
        ->join('users', 'user_joins.player', '=', 'users.id')
        ->join('users as users2', 'user_joins2.player', '=', 'users2.id')
        ->join('games', 'user_joins.gameid', '=', 'games.gameid')
        ->where("games.winner", "<>", null) 
        ->where("games.winner", "<>", "")
        ->where("users.email", "<>", DB::raw("`users2`.`email`"))
        ->where(function ($query) use ($userid) {
            $query->where('users.id', $userid)
                  ->orWhere('users2.id', $userid);
        })
        ->groupBy("games.gameid")
        ->orderBy("games.created_at", "DESC")
        ->get();
    } 


    /**
     * Show the profil of a given user
     *
     * @param User $user                         The User through Model Binding
     * 
     * @return \Illuminate\View\View             The profile page view
     */
    public function show(User $user): View {

        // On recupère des statistiques générale (nombre de games jouées, gagnées et perdues)
        $statistics = $this->get_general_stats($user->id);

        // On parse la réponse de l'ORM pour récuperer les informations qui nous intéressent
        $played_games = 0;
        $drawn_games = 0;
        $won_games = 0;
        $not_ended_games = 0;

        foreach($statistics as $game) {
            if($game->winner === $game->symbol) {
                $won_games++;
            }
            if($game->winner === "draw") {
                $drawn_games++;
            }
            if($game->winner === null) {
                $not_ended_games++;
            }
            $played_games++;
        }

        $lost_games = $played_games - $won_games - $drawn_games - $not_ended_games;
        
        // On recupère un array contenant l'historique des games jouées
        $history = $this->get_history($user->id); 

        // Enfin on retourne la vue de la profile page
        return view("app.settings.profile", [
            "won_games" => $won_games,
            "lost_games" => $lost_games,
            "drawn_games" => $drawn_games,
            "email" => $user->email,
            "name" => $user->name,
            "history" => $history,

            "created_at" => $user->created_at,
        ]);
    }

    
    /**
     * Show the settings page
     *
     * @return Illuminate\View\View
     */
    public function show_settings(): View {
        return view("app.settings.settings");
    }
}
