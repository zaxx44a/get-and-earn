<?php

namespace App\Listeners;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class CountingPointListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event by increment the point and flush the cache.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        !is_null($event->user->parent) ? $event->user->parent->incrementCredit() : '';
        User::flushQueryCache();


    }
}
