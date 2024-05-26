<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\StatService;
// for type declaration
use Illuminate\View\View;


class SettingsController extends Controller
{
    /**
     * Show the profil of a given user
     *
     * @param User $user                The User through Model Binding
     * @param StatService $service     The stat service through dependency injection
     * 
     * @return View             The profile page view
     */
    public function show_profile(User $user, StatService $service): View {
        
        [$won, $lost, $drawn] = $service->get_game_stats($user->id);        

        // Enfin on retourne la vue de la profile page
        return view("app.settings.profile", [
            "user" => $user,
            "won_games" => $won,
            "lost_games" => $lost,
            "drawn_games" => $drawn,
            "history" => $service->get_game_history($user->id),
        ]);
    }

    
    /**
     * Show the settings page
     *
     * @return View
     */
    public function show_settings(): View {
        return view("app.settings.settings");
    }
}
