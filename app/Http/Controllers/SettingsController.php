<?php

namespace App\Http\Controllers;

use App\Models\User_join;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class SettingsController extends Controller
{

    /**
     * Eloquent request to get the general stats (played games, winned games, lost games etc) of a given user
     *
     * @param integer $id_user      The id of the user to query
     * 
     * @return Collection           The ORM response 
     */
    private function get_general_stats(int $id_user) {
        // Disable the "ONLY_FULL_GROUP_BY" mode that is auto enabled on laravel
        DB::statement("SET SQL_MODE=''");
                
        // Get stats from the "user_play" table and the "games" table
        return User_join::select("winner", "symbol") 
            -> join('games', 'games.gameid', '=', 'user_joins.gameid')
            -> where("player", $id_user) 
            -> where("winner", "!=", null)
            -> get();
    }


    /**
     * Get the history of played games (player, his opponent, winner, and the date)
     *
     * @param integer $id       The id of the user to query
     * 
     * @return array            The ORM response 
     */
    private function get_history(int $id) {
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
        -> join('user_joins as user_joins2', 
            function ($join) {
                $join -> on('user_joins.gameid', '=', DB::raw("`user_joins2`.`gameid`"))
                      -> where('user_joins.player', '<>', DB::raw("`user_joins2`.`player`"));
            })
        -> join('users', 'user_joins.player', '=', 'users.id')
        -> join('users as users2', 'user_joins2.player', '=', 'users2.id')
        -> join('games', 'user_joins.gameid', '=', 'games.gameid')
        -> where("games.winner", "<>", null) 
        -> where("games.winner", "<>", "")
        -> where("users.email", "<>", DB::raw("`users2`.`email`"))
        -> where(function ($query) use ($id) {
            $query -> where('users.id', $id)
                   -> orWhere('users2.id', $id);
        })
        -> groupBy("games.gameid")
        -> orderBy("games.created_at", "DESC")
        -> get()
        -> toArray();
    } 


    /**
     * Show the profile of a given user
     *
     * @param Users $user       The user through model binding
     * 
     * @return void
     */
    public function show(Users $user) {

        // Get the ORM responde to the request
        $statistics = $this -> get_general_stats($user -> id);

        // Parse the ORM response to get usable stats
        $played_games = 0;
        $drawn_games = 0;
        $won_games = 0;
        $not_ended_games = 0;

        foreach($statistics as $game) {
            if($game -> winner === $game -> symbol) {
                $won_games++;
            }
            if($game -> winner === "draw") {
                $drawn_games++;
            }
            if($game -> winner === null) {
                $not_ended_games++;
            }
            $played_games++;
        }
        $lost_games = $played_games - $won_games - $drawn_games - $not_ended_games;
        
        // Get an array that represents the history of played games of the user
        $history = $this -> get_history($user -> id); 

        // Return the profile page with all the needed parameters
        return view("app.settings.profile", [
            "won_games" => $won_games,
            "lost_games" => $lost_games,
            "drawn_games" => $drawn_games,
            "email" => $user -> email,
            "name" => $user -> name,
            "history" => $history,

            // diffForHumans -> 15 seconds ago, 2 months ago for example
            "created_at" => Carbon::parse($user -> created_at) -> diffForHumans(),
        ]);
    }

    
    /**
     * Show the settings page
     *
     * @return view
     */
    public function show_settings() {
        return view("app.settings.settings");
    }
}
