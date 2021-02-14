<?php

namespace App\Exceptions;
use Exception;


class ExceptionUserNotFound extends Exception
{
    /**
     * Report the exception.
     *
     * @return bool|null
     */
    public function report()
    {
        return true;
    }

    public function render($request)
    {
       return view('test_error');
    }
}
