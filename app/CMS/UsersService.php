<?php


namespace App\CMS;

use App\Exceptions\ExceptionUserNotFound;
use App\Models\User;


class UsersService
{

    /**
     * @param $id
     * @return mixed
     * @throws ExceptionUserNotFound
     */
    public function userById($id)
    {
        $user = User::find($id);

        if(!$user){
            throw new ExceptionUserNotFound('Пользователь с идентификатором '
                .$id.' не найден');
        }

        return $user;
    }
}
