<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\StatService;
// for type declaration
use Illuminate\View\View;
use App\Services\SettingsService;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\SettingsRequest;


class SettingsController extends Controller
{
    /**
     * @param User $user              The User through Model Binding
     * @param StatService $service    The stat service through dependency injection
     *
     * @return View                   The profile page view
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
     * Updates username AND password OR only username OR only password
     *
     * @param SettingsRequest $request
     * @param SettingsService $services
     *
     * @return RedirectResponse
     */
    public function update(SettingsRequest $request, SettingsService $service): RedirectResponse {

        // Check if the provided password match the user password
        if(!$service->check_password($request->get("password"))) {
            return back()->withErrors([
                "password" => __("validation.current_password"),
            ]);
        }

        // If a new username is given, change the users username
        $service->change_username($request->get("name"));

        // If a password is given, change the users password
        $service->change_password($request->get("new_password"));


        return back()->with("success", __("app.settings.updated_success"));
    }

}
