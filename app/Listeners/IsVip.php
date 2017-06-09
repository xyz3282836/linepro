<?php

namespace App\Listeners;

use App\Events\Vip;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IsVip
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
     * @param  Vip  $event
     * @return void
     */
    public function handle(Vip $event)
    {
        $model = $event->model;
        if(strtotime($model->validity) < time()){
            $model->level = 1;
            $model->save();
        }
    }
}
