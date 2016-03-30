<?php
/**
 * Created by PhpStorm.
 * User: Neverier00
 * Date: 9/7/2015
 * Time: 2:26 PM
 */

namespace App;
use App\User;
use LucaDegasperi\OAuth2Server\Authorizer;
use Hash;

class PasswordVerifier {
    public function verify( $username, $password)
    {
        $user = User::where('email',$username)->first();
        if(count($user) > 0){
            if (Hash::check($password, $user->password))
            {
                return $user->id;
            }
        }
        return false;
    }
}