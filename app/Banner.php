<?php

namespace App;

use Cache;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $appends = ['type_text'];

    public static function getBanners()
    {
        if (Cache::has('banners')) {
            return Cache::get('banners');
        } else {
            $list    = self::where('type', 1)->get();
            $banners = [];
            foreach ($list as $v) {
                $banners[] = [
                    'title' => $v->title,
                    'pic'   => url('upfile/admin/' . $v->pic)
                ];
            }
            Cache::forever('banners', $banners);
            return $banners;
        }
    }

    public static function getLogo()
    {
        if (Cache::has('logo')) {
            return Cache::get('logo');
        } else {
            $logo = self::where('type', 2)->first();
            $logo = url('upfile/admin/' . $logo->pic);
            Cache::forever('logo', $logo);
            return $logo;
        }
    }

    public function getTypeTextAttribute()
    {
        $arr = config('linepro.banner_type_text');
        return $arr[$this->type];
    }

}
