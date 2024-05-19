<?php

namespace App\Listeners;

use App\Events\TFAEnableEvent;
use RobThree\Auth\TwoFactorAuth;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;

class TFAEnableListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * 
     * Enable TFA by adding a new TOTP secret to the user (in the database), 
     * and creates two flash messages
     * 
     * (tmp_secret): The user OTP secret 
     * (tmp_qrcode): A QRCode that contains the secret
     */
    public function handle(TFAEnableEvent $event): void
    {

        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());
        $secret = $tfa->createSecret();
        $qrcode = $tfa->getQRCodeImageAsDataUri($event->user->email, $secret);

    
        $event->user->update([
            // On update le secret pour annoncer que l'utilisateur utilise l'A2F
            "secret" => $secret,
        ]);

        session()->flash("tmp_secret", $secret);
        session()->flash("tmp_qrcode", $qrcode);
    }
}
