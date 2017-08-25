<?php

namespace App\Console;

use App\CfResult;
use App\ExchangeRate;
use App\Order;
use GuzzleHttp\Client;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $this->getRate();
        })->daily();
        $schedule->call(function () {
            $this->dealRefund();
            $this->tmp();
        })->everyFiveMinutes();
    }

    private function tmp(){
        $list = CfResult::with('cf')->get();
        foreach ($list as $v) {
            if($v->cf){
                if($v->from_site != $v->cf->from_site){
                    $v->from_site = $v->cf->from_site;
                    $v->save();
                }
            }
        }
    }

    /**
     * 退款
     */
    private function dealRefund()
    {
        $list = CfResult::where('status', 0)->get();
        foreach ($list as $v) {
            $v->refund();
        }
    }

    /**
     * 获取汇率
     */
    private function getRate()
    {
        $showapi_appid  = '40811';
        $showapi_secret = 'eab8fb3f739540ea8dcb649bd4f57512';
        $paramArr       = [
            'showapi_appid' => $showapi_appid,
            'code'          => ""
        ];
        $param          = $this->createParam($paramArr, $showapi_secret);
        $url            = 'http://route.showapi.com/105-30?' . $param;
        $client         = new Client();
        $res            = $client->request('GET', $url);
        $body           = $res->getBody()->getContents();
        $arr            = json_decode($body, true);
        if (isset($arr['showapi_res_body']['list'])) {
            foreach ($arr['showapi_res_body']['list'] as $v) {
                if (in_array($v['code'], ['USD', 'CAD', 'GBP', 'EUR', 'JPY'])) {
                    $one          = ExchangeRate::where('apiname', $v['code'])->first();
                    $apirate      = ($v['hui_in'] + $v['hui_out'] + $v['chao_in'] + $v['chao_out']) / 400;
                    $one->apirate = $apirate;
                    $one->save();
                }
            }
        }
    }

    private function createParam($paramArr, $showapi_secret)
    {
        $paraStr = "";
        $signStr = "";
        ksort($paramArr);
        foreach ($paramArr as $key => $val) {
            if ($key != '' && $val != '') {
                $signStr .= $key . $val;
                $paraStr .= $key . '=' . urlencode($val) . '&';
            }
        }
        $signStr .= $showapi_secret;
        $sign    = strtolower(md5($signStr));
        $paraStr .= 'showapi_sign=' . $sign;
        return $paraStr;
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
