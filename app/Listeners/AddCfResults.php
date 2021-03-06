<?php

namespace App\Listeners;

use App\CfResult;
use App\Events\CfResults;
use Carbon\Carbon;

class AddCfResults
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
     * @param  CfResults $event
     * @return void
     */
    public function handle(CfResults $event)
    {
        $model = $event->model;
        $dbarr = [];
        for ($i = $model->task_num; $i > 0; $i--) {
            $dbarr[] = [
                'uid'        => $model->uid,
                'cfid'       => $model->id,
                'asin'       => $model->asin,
                'from_site'  => $model->from_site,
                'shop_id'    => $model->shop_id,
                'status'     => CfResult::STATUS_WAITING,
                'created_at' => Carbon::now()->toDateTimeString(),
                'updated_at' => Carbon::now()->toDateTimeString(),
            ];
        }
        CfResult::insert($dbarr);
    }
}
