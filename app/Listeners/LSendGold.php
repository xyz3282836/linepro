<?php

namespace App\Listeners;

use App\Events\ESendGold;
use App\GoldBill;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class LSendGold
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
     * Handle the event.
     *
     * @param  ESendGold  $event
     * @return void
     */
    public function handle(ESendGold $event)
    {
        $user = $event->model;
        $user->getGoldByReg(gconfig('registergold'));
    }
}
