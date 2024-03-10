<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginReq;
use App\Http\Requests\SignupReq;
use App\Models\Users;

class AuthController extends Controller
{

    /**
     * Hash a basic string in double sha512 (sha512(sha512("the string")))
     *
     * @param string $to_hash       The string to hash
     *
     * @return                      The hash in sha512
     */
    private static function hash(string $to_hash) {
        return hash("sha512", hash("sha512", $to_hash));
    }


    /**
     * Log in a user
     *
     * @param LoginReq $request
     *
     * @return          Redirection to / or to /login with errors
     */
    public function login(LoginReq $request) {

        # Search for the username & password combination in the users table
        $data = Users::where("email", "=", $request["email"]) 
                -> where("password", "=", self::hash($request["password"]))
                -> get() 
                -> toArray();
        
        # If there is no such combination in the table, return to previous page with error
        if(empty($data)) {
            return to_route("auth.login") -> withErrors([
                "loginerror" => "Invalid username or password"
            ]);
        }

        # Add the full content returned by the table to the session
        # ( ID : NAME : EMAIL : PASSWORD (sha512) : TIMESTAMPS )
        session($data[0]);

        # Go to / page
        return to_route("app.app");
    }


    /**
     * Signup a user
     *
     * @param SignupReq $request
     * 
     * @return          Redirection to the login page with a success message 
     */
    public function signup(SignupReq $request) {

        # Since the validation of the request include the fact that the name is unique in
        # the table, we can create the user without any validation at this level

        $user = Users::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "password" => self::hash($request["password"])
        ]);

        # And safely return to the login page
        
        return to_route("auth.login") -> with(
            "success", "User " . $user -> name . " has been created !"
        );
    }
}
