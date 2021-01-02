<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class UserNotFound extends Exception
{
    public function report()
    {
        Log::alert('Not found user!');
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function render($request)
    {
        return view('exception',compact('request'));
    }
}
