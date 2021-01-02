<?php


namespace App\Services;

use App\Exceptions\UserNotFound;
use App\Models\User;

class UserServices
{


    public function userByName($email)
    {

        if(!$email){
            throw new UserNotFound("user not found email");
        }

        return User::where('email',$email)->first();
    }

}
