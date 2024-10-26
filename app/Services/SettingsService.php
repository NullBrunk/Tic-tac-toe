<?php
declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use App\Http\Controllers\AuthController;

class SettingsService
{
    /**
     * Check if the provided password match the users password
     *
     * @param string $password
     *
     * @return bool
     */
    public function check_password(string $password): bool {
        $hashed_password = AuthService::hash($password);

        return $hashed_password === session("password");
    }


    /**
     * Update the current username
     *
     * @param string|null $name    The new username
     *
     * @return void
     */
    public function change_username(?string $name): void {
        if($name === null) {
            return;
        }

        User::find(session("id"))->update([
            "name" => $name,
        ]);
        session(["name" => $name]);
    }


    /**
     * Update the password
     *
     * @param string|null $new_password    The new password
     *
     * @return void
     */
    public function change_password(?string $new_password): void {
        if($new_password === null) {
            return;
        }

        $hashed_new_password = AuthService::hash($new_password);

        User::find(session("id"))->update([
            "password" => $hashed_new_password,
        ]);

        session(["password" => $hashed_new_password]);
    }

}