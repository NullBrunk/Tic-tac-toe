<?php

namespace App\Http\Controllers;

use App\Models\User_join;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProfileController extends Controller
{

    /**
     * Eloquent request to get general stats (played games, winned games, lost games etc)
     *
     * @param integer $id_user      The id of the user to query
     * 
     * @return Collection           The orm response 
     */
    private function get_general_stats(int $id_user) {
        # Disable the "ONLY_FULL_GROUP_BY" mode that is auto enabled on laravel
        DB::statement("SET SQL_MODE=''");
                
        # Get stats from the "user_play" table and the "games" table
        return User_join::select("winner", "symbol") 
            -> join('games', 'games.gameid', '=', 'user_joins.gameid')
            -> where("player", $id_user) 
            -> where("winner", "!=", null)
            -> get();
    }


    /**
     * Get the history of played games, with the opponent, the winner and the date
     *
     * @param integer $id       The id of the user to query
     * 
     * @return array            An array that represents history
     */
    private function get_history(int $id) {
        return User_join::select(
            "users.email AS email_p1", 
            "users2.email AS email_p2", 
            "user_joins.symbol AS join_p1",
            "user_joins2.symbol AS join_p2",
            "games.winner AS winner",
            "games.created_at",
        ) 
        -> join('user_joins as user_joins2', 
            function ($join) {
                $join -> on('user_joins.gameid', '=', 'user_joins2.gameid')
                      -> where('user_joins.player', '<>', 'user_joins2.player');
            })
        -> join('users', 'user_joins.player', '=', 'users.id')
        -> join('users as users2', 'user_joins2.player', '=', 'users.id')
        -> join('games', 'user_joins.gameid', '=', 'games.gameid')
        -> where("winner", "<>", null) 
        -> where("winner", "<>", "")
        -> where("users.email", "<>", DB::raw("`users2`.`email`"))
        -> where(function ($query) use ($id) {
            $query -> where('users.id', $id)
                   -> orWhere('users2.id', $id);
        })
        -> groupBy("games.gameid")
        -> get()
        -> toArray();

    } 

    /**
     * Show the profile of a given user
     *
     * @param Users $user       The user through model binding
     * @return void
     */
    public function show_profile(Users $user) {

        $statistics = $this -> get_general_stats($user -> id);

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
        
        # Don't count unterminated games in the "played games"
        $played_games -= $not_ended_games;

        # Get the history of played games of the user
        $history = $this -> get_history($user -> id); 

        
        return view("profile", [
            "played_games" => $played_games,
            "won_games" => $won_games,
            "lost_games" => $lost_games,
            "drawn_games" => $drawn_games,
            "email" => $user -> email,
            "history" => $history,

            "created_at" => Carbon::parse($user -> created_at) -> diffForHumans(),
        ]);
    }
}
