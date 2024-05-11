<?php

use App\Http\Controllers\SettingsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GamesController;

use Illuminate\Support\Facades\Route;

// If you want to test the support for localization :
// app()->setLocale("fr");


// If you want to test the mail :
// use App\Mail\ConfirmationMail;
// Route::get("/mail", function() {
//     return new ConfirmationMail("a@a.a", "idididid");
// });


Route::view("/", "app.index")->name("index");


/*
|--------------------------------------------------------------------------
| Authentication routing
|--------------------------------------------------------------------------
| 
*/

Route::middleware("guest")->name("auth.")->controller(AuthController::class)->group( function () {
    Route::view("/login", "app.auth.login")->name("login");
    Route::post("/login", "login");
    
    Route::view("/register", "app.auth.register")->name("register");
    Route::post("/register", "register");

    Route::view("/validate", "app.auth.login_2fa")->name("login_2fa");
    Route::post("/validate", "login_2fa");

    Route::get("/verify/{user:email}/{confirmation_token}", "confirm_mail")->name("confirm_mail");
});


Route::get("logout", function () {
    # Clean the session
    session()->flush();

    # Redirect to /
    return to_route("index");
})->name("auth.logout")->middleware("auth");


/*
|--------------------------------------------------------------------------
| App routing
|--------------------------------------------------------------------------
| 
*/

Route::name("games.")->middleware("auth")->controller(GamesController::class)->group(function () {
    Route::get("/create",  "create")->name("create");

    Route::get("/play/{game}", "join")->name("join");
    Route::get("/move/{id}/{position}", "users_plays")->name("play");
});


/*
|--------------------------------------------------------------------------
| Profile/Settings routing
|--------------------------------------------------------------------------
| 
*/

Route::name("settings.")->middleware(["auth", "no-cache"])->controller(SettingsController::class)->group(function () {
    Route::get("settings",  "show_settings")->name("profile");
});

Route::get("p/{user:name}", [ SettingsController::class, "show" ])->name("settings.show");


