<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    public static function getBanners(){
        if (Cache::has('banners')){
            return Cache::get('banners');
        }else{
            $list = self::all();
            $banners = [];
            foreach ($list as $v) {
                $banners[] = [
                    'title'=>$v->title,
                    'pic'=>url('upfile/admin/'.$v->pic)
                ];
            }
            Cache::forever('banners',$banners);
            return $banners;
        }
    }

}
