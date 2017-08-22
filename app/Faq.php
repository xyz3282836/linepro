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
                $faqs[] = [
                    'q' => $v->q,
                    'a' => $v->a,
                ];
            }
            Cache::forever('faqs', $faqs);
            return $faqs;
        }
    }

}