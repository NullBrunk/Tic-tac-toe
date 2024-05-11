<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Events\SignupEvent;

// Form requests
use Illuminate\Support\Str;
use App\Http\Requests\LoginReq;

// Manage 2FA  
use RobThree\Auth\TwoFactorAuth;
use App\Http\Requests\RegisterReq;
use App\Http\Requests\ValidateA2FRequest;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;

// for type declaration
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;


class AuthController extends Controller
{

    /**
     * Hash a basic string in double sha512 (sha512(sha512("the string")))
     *
     * @param string $to_hash        The string to hash
     *
     * @return string                The hash in sha512
     */
    private static function hash(string $to_hash): string {
        return hash("sha512", hash("sha512", $to_hash));
    }


    /**
     * Log in a user
     *
     * @param LoginReq $request                                The Form Request
     *
     * @return Illuminate\Http\RedirectResponse                Redirection to / or to /login with errors
     */
    public function login(LoginReq $request): RedirectResponse {
        // On cherche la combinaison email:password dans la table User
        $data = User::where("email", $request["email"])
                    ->where("password", self::hash($request["password"]))
                    ->get() 
                    ->toArray();

        // Si on ne trouve rien
        if(empty($data)) {
            return to_route("auth.login")->withErrors([
                "loginerror" => "Invalid username or password"
            ]);
        }

        // On recupère le premier record, qui sera notre user a logger
        $data = $data[0];

        // Si le champs confirmation token ne vaut pas null, c'est que le mail 
        // n'a pas encore été validé
        if($data["confirmation_token"] !== null) {
            return to_route("auth.login")->withErrors([
                "loginerror" => "You need to verify your mail address"
            ]);
        }
        
     
        if($data["secret"] !== null) {
            // On stocke l'id de l'utilisateur que nous avons "validé"
            // en d'autre terme, on indique que l'utilisateur avec cet ID a rentré le bon username
            // et le bon password, mais il n'est pas encore loggé car il n'a pas encore entré le
            // token a2f
            session(["validated_id" => $data["id"]]);
            // L'utilisateur à activé l'A2F, rediriger vers la page demandant l'entrée du code totp
            return to_route("auth.validate_a2f");
        }

        // L'utilisateur n'utilise pas l'A2F, le login instantanément
        session($data);

        // Et on redirect à /
        return to_route("index");

    }


    /**
     * Register a user
     *
     * @param RegisterReq $request        The Register form request
     * 
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     *                                Redirection to the login page with a success message 
     */
    public function register(RegisterReq $request) : RedirectResponse|View {


        // On créé le token unique qui sera envoyé à l'utilisateur par mail
        $confirmation_token = Str::uuid();

        // La form RegisterReq form request vérifie déjà que le mail et le name choisi sont unique
        // dans al table User. Nous n'avons donc pas besoin de faire ces validations après coup.
        // Ici nous nous contentons donc d'ajouter l'utilisateur dans la table User.
        $user = User::create([
            "name" => $request["name"],
            "email" => $request["email"],
            "confirmation_token" => $confirmation_token,
            "password" => self::hash($request["password"]),

            // Par défaut le secret totp (2FA) vaut null
            // ce qui signifie que l'utilisateur n'a pas l'A2F activée
            "secret" => null,
        ]);

        // On envoie un événement SignupEvent qui sera capturé par le
        // SignupListener qui enverra un mail contenant le confirmation token
        SignupEvent::dispatch($user->email, $confirmation_token);

        // Si l'utilisateur ne souhaite pas bénéficier de l'authentification à deux facteurs,
        if(!($request->has("2fa_token"))) {
            return to_route("auth.login")->with(
                "success", 
                "User " . $user->name . " has been created, please check your inbox !"
            );
        }

        // Si on est arrivé ici, c'est que l'utilisateur souhaite bénéficier de l'A2F. 
        // On va donc le renvoyer vers une page lui permettant de scanner un QRCode ou 
        // d'ajouter un code secret sur son app de TOTP
        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());
        $secret = $tfa->createSecret();
        $qrcode = $tfa->getQRCodeImageAsDataUri($request["email"], $secret);

    
        $user->update([
            // On update le secret pour annoncer que l'utilisateur utilise l'A2F
            "secret" => $secret,
        ]);
        
        // On ne va pas a la page de login, mais a la page contenant le QRCode et le secret
        return view("app.auth.2fa", [
            "secret" => $secret,
            "qrcode" => $qrcode,
        ]);
    }

    
    /**
     * Validate a user by confirming his mail
     *
     * @param User $user                                      The user through model binding
     * @param string $checksum                                Random UUID generated to check the mail
     * 
     * @return \Illuminate\Http\RedirectResponse              Returns either to /login either to a 403 page
     */
    public function confirm_mail(User $user, string $confirmation_token): RedirectResponse {
        
        // Si le confirmation_token passé dans l'URL n'est pas le même que
        // le confirmation token attribué au user lors de sa création
        if($user->confirmation_token !== $confirmation_token)
            return abort(403);
        
        $user->update([ "confirmation_token" => null ]);

        return to_route("auth.login")->with(
            "success", "Your mail have been confirmed, you can log-in now"
        );
    }


    public function validate_a2f(ValidateA2FRequest $request) {
        if(!session()->has("validated_id")) {
            return abort(403);
        }

        $user = User::findOrFail(session("validated_id"));

        $totp_code = 
                    $request["totp1"] . $request["totp2"] . $request["totp3"] . 
                    $request["totp4"] . $request["totp5"] . $request["totp6"];




        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());

        // On check la validité à partir du secret récupéré dans la BDD, et du code fourni par 
        // l'utilisateur. Si ce n'est pas valide on affiche une erreur à l'utilisateur
        if(!$tfa->verifyCode($user->secret, $totp_code)) {
            return back()->withErrors([
                "2fa_code" => __("validation.attributes.invalid_2fa"),
            ]);
        }

        // Ceci ne nous sert plus a rien
        session()->forget("validated_id");

        // On rajoute la row retourné par la BDD dans la session
        session($user->toArray());
        
        // Et on redirect à /
        return to_route("index");
    }
}
