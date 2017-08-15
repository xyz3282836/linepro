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

    public static function getAd($place)
    {
        $key = 'banner-' . $place;
        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $ad   = self::where('type', $place)->first();
            $pic  = url('upfile/admin/' . $ad->pic);
            $link = $ad->title;
            $val  = ['pic' => $pic, 'link' => $link];
            Cache::forever($key, $val);
            return $val;
        }
    }

    public static function getIndex()
    {
        $key = 'index';
        if (Cache::has($key)) {
            return Cache::get($key);
        } else {
            $pic  = self::where('type', 5)->first();
            $logo = self::where('type', 6)->first();
            $val  = ['pic' => url('upfile/admin/' . $pic->pic), 'logo' => url('upfile/admin/' . $logo->pic)];
            Cache::forever($key, $val);
            return $val;
        }
    }

    public function getTypeTextAttribute()
    {
        $arr = config('linepro.banner_type_text');
        return $arr[$this->type];
    }

}
