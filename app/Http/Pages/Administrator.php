<?php


namespace App\Http\Pages;
use App\Exceptions\UserNotFound;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserServices;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class Administrator extends Controller
{

    private $user;

    /**
     * Administrator constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        ///$this->middleware('auth')->only('dashboard'); // only one method
        $this->middleware('auth')
            ->except(['dashboard','userPage']); // все методы кроме метода dashboard
    }

    public function dashboard()
    {
        return 'start page';
    }

    public function userPage($email)
    {
        try{
            $user = (new UserServices())->userByName($email);
        }catch (\UserNotFound $error){
            return view('exception',compact('error'));
        }
        return view('user_page',compact('user'));
    }

    public function settingsPage(Request $request)
    {
        dd($request->user());
    }

}
