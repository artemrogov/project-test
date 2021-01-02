<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;

use PDO;

class PgNotifySubscribe
{

    protected $client;

    public function __construct()
    {
        $this->client = DB::connection()->getPdo();
    }



    function MyPgListenEvent()
    {

    }

}
