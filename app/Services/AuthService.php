<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use RobThree\Auth\TwoFactorAuth;
use RobThree\Auth\TwoFactorAuthException;
use RobThree\Auth\Providers\Qr\BaconQrCodeProvider;


class AuthService {
    /**
     * @param string $to_hash        The string to hash
     * @return string                The sha512 hash
     */
    public static function hash(string $to_hash): string {
        return hash("sha512", hash("sha512", $to_hash));
    }


    /**
     * Enable TFA (TOTP) for a given user
     *
     * @param User $user    The user
     *
     * @throws TwoFactorAuthException
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
