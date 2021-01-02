<?php

namespace App\Listeners;

use App\Events\SaveEventCompanies;
use App\Jobs\TestJob1;
use App\Jobs\TestJob2;
use App\Jobs\TestJob3;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SaveListenerCompanies
{

    /**
     * Handle the event.
     *
     * @param  SaveEventCompanies  $event
     * @return void
     */
    public function handle(SaveEventCompanies $event)
    {
        $data = json_encode($event->data);

        TestJob1::withChain([
            new TestJob2,
            new TestJob3
        ])->dispatch($data);

    }
}
