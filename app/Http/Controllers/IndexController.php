<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\User;
use Illuminate\View\View;

class IndexController extends Controller
{

    public function format(int $number): string {
        return $number < 10000 ?
            (string)$number :
            (int)($number / 1000) . "k";
    }

    public function __invoke(): View
    {
        $game_count = Game::count();
        $user_count = User::count();
        $today_game = Game::whereDate('created_at', today())->count();

        return view("app.index", [
            "games" => $this->format($game_count),
            "users" => $this->format($user_count),
            "today_games" => $this->format($today_game),
        ]);
    }
}
