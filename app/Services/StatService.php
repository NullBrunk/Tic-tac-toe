<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use App\Models\User_join;

class StatService {
    /**
     * Get unparsed information about a given user (played/won/lost games...)
     *
     * @param integer $userid        The user id from which to retrieve the statistics
     * 
     * @return Collection            The ORM response
     */
    private function query_game_stats(int $userid): Collection {
        // On désactive le mode "ONLY_FULL_GROUP_BY" qui est activé par défaut avec Laravel
        DB::statement("SET SQL_MODE=''");
                
        // On fait un inner join entre la table user_play et la table games pour récupérer les informations
        // qui nous intéressent
        return User_join::select(["winner", "symbol"])
            ->join('games', 'games.id', '=', 'user_joins.game_id')
            ->where("user_id", $userid) 
            ->where("winner", "!=", null)
            ->get();
    }


    /**
     * Get the history of played games (player1, player2, winner)
     *
     * @param integer $userid        User id to query
     * 
     * @return Collection            The ORM response
     */
    public function get_game_history(int $userid): Collection {
        return User_join::select([
            "users.email AS email_p1", "users.name AS name_p1",
            "users2.email AS email_p2", "users2.name AS name_p2",
            "user_joins.symbol AS join_p1",
            "user_joins2.symbol AS join_p2",
            "games.winner", "games.created_at",
        ])
            ->join('games', 'user_joins.game_id', '=', 'games.id')
            ->join('users', 'user_joins.user_id', '=', 'users.id')
            ->join('user_joins as user_joins2', function ($join) {
                $join->on('user_joins.game_id', '=', DB::raw("`user_joins2`.`game_id`"))
                    ->where('user_joins.user_id', '<>', DB::raw("`user_joins2`.`user_id`"));
            })
            ->join('users as users2', 'user_joins2.user_id', '=', 'users2.id')
            ->where("games.winner", "<>", null)
            ->where("users.email", "<>", DB::raw("`users2`.`email`"))
            ->whereExists(function ($query) use ($userid) {
                $query->select(DB::raw(1))
                    ->from('user_joins')
                    ->whereRaw('user_joins.game_id = games.id')
                    ->where('user_id', $userid);
            })
            ->orderBy("games.created_at", "DESC")
            ->get();
    }


    /**
     * Parse the result of the query_game_stats and returns won, lost and drawn games
     *
     * @param integer $userid       The user id from which to retrieve the statistics
     * 
     * @return array[int]           Won, Lost and Drawn games
     */
    public function get_game_stats(int $userid): array {
        // On parse la réponse de l'ORM pour récuperer les informations qui nous intéressent

        $statistics = $this->query_game_stats($userid);

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

        return [$won_games, $lost_games, $drawn_games];
    }
}