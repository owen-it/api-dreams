<?php
/**
 * Created by PhpStorm.
 * User: anteriovieira
 * Date: 11/09/15
 * Time: 23:28
 */

namespace App\OAuth;


use Illuminate\Support\Facades\Auth;

class PasswordVerifier
{
    /**
     * Verity grant
     *
     * @param $username
     * @param $password
     * @return bool
     */
    public function verify($username, $password)
    {
        $credentials = [
            'email'    => $username,
            'password' => $password,
        ];

        if (Auth::once($credentials)) {
            return Auth::user()->id;
        }

        return false;
    }
}