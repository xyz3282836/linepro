<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    public static function getFaqs()
    {
        if (Cache::has('faqs')) {
            return Cache::get('faqs');
        } else {
            $list = self::orderBy('order', 'desc')->get();
            $faqs = [];
            foreach ($list as $v) {
                $faqs[$v->id] = [
                    'q' => $v->q,
                    'a' => $v->a,
                ];
            }
            Cache::forever('faqs', $faqs);
            return $faqs;
        }
    }

    public static function getFaq($id){
        $arr = self::getFaqs();
        if(isset($arr[$id])){
            return json_encode($arr[$id]);
        }else{
            return '';
        }
    }

}