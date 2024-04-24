<?php

namespace App\Http\Controllers;

use App\Events\SignupEvent;
use App\Http\Requests\LoginReq;
use App\Http\Requests\SignupReq;
use Illuminate\Support\Str;
use App\Models\Users;

class AuthController extends Controller
{

    /**
     * Hash a basic string in double sha512 (sha512(sha512("the string")))
     *
     * @param string $to_hash       The string to hash
     *
     * @return string               The hash in sha512
     */
    private static function hash(string $to_hash) {
        return hash("sha512", hash("sha512", $to_hash));
    }


    /**
     * Log in a user
     *
     * @param LoginReq $request     The validated request
     *
     * @return redirect             Redirection to / or to /login with errors
     */
    public function login(LoginReq $request) {

        # Search for the username & password combination in the users table
        $data = Users::where("email", $request["email"])
                -> where("password", self::hash($request["password"]))
                -> get() 
                -> toArray();

        # If there is no such combination in the table, return to previous page with error
        if(empty($data)) {
            return to_route("auth.login") -> withErrors([
                "loginerror" => "Invalid username or password"
            ]);
        }

        # Si le champs confirmation token ne vaut pas null, c'est que le mail n'a pas encore
        # été validé
        if($data[0]["confirmation_token"] !== null) {
            return to_route("auth.login") -> withErrors([
                "loginerror" => "You need to verify your mail address"
            ]);
        }

        # Add the full content returned by the table to the session
        # ( ID : NAME : EMAIL : PASSWORD (sha512) : TIMESTAMPS )
        session($data[0]);

        # Go to / page
        return to_route("index");
    }


    /**
     * Register a user
     *
     * @param SignupReq $request        The validated request
     * 
     * @return redirect                 Redirection to the login page with a success message 
     */
    public function register(SignupReq $request) {
        # Create the validation unique token
        $confirmation_token = Str::uuid();

        # Since the validation of the request include the fact that the name is unique in
        # the table, we can create the user without any validation at this level
        $user = Users::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "confirmation_token" => $confirmation_token,
            "password" => self::hash($request["password"])
        ]);

        # On envoie un événement SignupEvent qui sera capturé par le
        # SignupListener qui enverra un mail contenant le confirmation token
        SignupEvent::dispatch($user -> email, $confirmation_token);

        return to_route("auth.login") -> with(
            "success", 
            "User " . $user -> name . " has been created, please check your inbox !"
        );
    }

    
    /**
     * Validate a user by confirming his mail
     *
     * @param Users $user           The user through model binding
     * @param string $checksum      Random UUID generated to check the mail
     * 
     * @return route|403            Returns either to /login either to a 403 page
     */
    public function confirm_mail(Users $user, string $confirmation_token) {
        
        # Si le confirmation token passé dans l'URL n'est pas le meme que
        # le confirmation token attribué à la création du user
        if($user -> confirmation_token !== $confirmation_token)
            return abort(403);
        
        $user -> update([ "confirmation_token" => null ]);

        return to_route("auth.login") -> with(
            "success", 
            "Your mail have been confirmed, you can log-in now"
        );
    }
}
