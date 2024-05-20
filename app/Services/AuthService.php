<?php

namespace App\Services;

use App\Models\User;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;


class AuthService {
    /**
     * Enable TFA (TOTP) for a given user
     *
     * @param User $user    The user
     * @return array        The secret + A qrcode that contains the secret
     */
    public static function enable_tfa(User $user): array {
        $tfa = new TwoFactorAuth(new BaconQrCodeProvider());
        $secret = $tfa->createSecret();
        $qrcode = $tfa->getQRCodeImageAsDataUri($user->email, $secret);
    
        $user->update([
            // On update le secret pour annoncer que l'utilisateur utilise l'A2F
            "secret" => $secret,
        ]);

        return [ $secret, $qrcode ];
    }
}
