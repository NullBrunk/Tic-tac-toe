<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AppController;

use Illuminate\Support\Facades\Route;


Route::view("/", "index") -> name("index");

/*
|--------------------------------------------------------------------------
| Authentication / Logout
|--------------------------------------------------------------------------
| 
*/

Route::middleware("guest") -> name("auth.") -> controller(AuthController::class) -> group( function () {
    Route::view("/login", "auth.login") -> name("login");
    Route::post("/login", "login");
    
    Route::view("/signup", "auth.signup") -> name("signup");
    Route::post("/signup", "signup");

    Route::get("/verify/{mail}/{confirmation_token}", "confirm_mail") -> name("confirm_mail");
});


Route::get("logout", function () {
    # Clean the session
    session() -> flush();

    # Redirect to /
    return to_route("index");
}) -> name("auth.logout") -> middleware("auth");


/*
|--------------------------------------------------------------------------
| App routing
|--------------------------------------------------------------------------
| 
*/

Route::name("app.") -> middleware("auth") -> controller(AppController::class) -> group(function () {
    Route::get("/generate",  "generate") -> name("generate");

    Route::get("/play/{id}", "join_game") -> name("join_game");
    Route::get("/move/{id}/{position}", "users_plays") -> name("play");
});


/*
|--------------------------------------------------------------------------
| Profile routing
|--------------------------------------------------------------------------
| 
*/

Route::name("profile.") -> middleware("auth") -> controller(ProfileController::class) -> group(function () {

    Route::get("settings",  "show_settings") -> name("settings");
    Route::get("p/{user:name}",  "show_profile") -> name("show");

});