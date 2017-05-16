<?php

namespace App\Listeners;

use App\Events\Vp;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class IsVp
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
     * @param  Vp  $event
     * @return void
     */
    public function handle(Vp $event)
    {
        $model = $event->model;
        if(strtotime($model->validity) < time()){
            $model->level = 1;
            $model->save();
        }
    }
}
