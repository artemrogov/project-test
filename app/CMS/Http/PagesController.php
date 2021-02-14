<?php

namespace App\CMS\Http;

use App\Models\User;

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
        $user =  User::find($id);

        if(is_null($user)){
            return 'Object user not found!';
        }
        return response()->view('user',compact('user'))
            ->header('Content-Type','text/xml');
    }
}
