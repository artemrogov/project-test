<?php

namespace App\CMS\Http;

use App\CMS\UsersService;
use App\Exceptions\ExceptionUserNotFound;

class PagesController extends BaseAdminController
{
    public function index()
    {
        return 'index page for admin';
    }

    public function categories()
    {
        return 'categories page';
    }

    public function help_page()
    {
        return 'help page';
    }

    public function users($id)
    {
        try {

            $user = (new UsersService())->userById($id);

        }catch (ExceptionUserNotFound $userError){
            return view('exception',compact('userError'));
        }

        return response()->view('user',compact('user'))
            ->header('Content-Type','text/xml');
    }
}
