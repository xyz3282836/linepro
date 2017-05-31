<?php

return [
    //美元汇率
    'us_exchange_rate'=>6.78,

    //服务费 单位元
    'base_exchange'=>[
        //level1 普通会员
        1=>2,
        //level2 认证会员
        2=>1.5,
    ],
    //运费 单位元
    'freight_exchange'=>[
        //level1 普通会员
        1=>20,
        //level2 认证会员
        2=>15,
    ],

    //会员有效天数
    'vp_days'=>30,

    //认证会员的费用 单位元
    'vp_exchange'=>500,

    //每页多少条目
    'perpage' => 10,

    'bigc'=>[
        0   =>  '不选类别直接搜索',
        1   =>  'Alexa Skills',
        2   =>  'Amazon Video',
        3   =>  'Amazon Warehouse Deals',
        4   =>  'Appliances',
        5   =>  'Apps & Games',
        6   =>  'Arts, Crafts & Sewing',
        7   =>  'Automotive Parts & Accessories',
        8   =>  'Baby',
        9   =>  'Beauty & Personal Care',
        10  =>  'Books',
        11  =>  'CDs & Vinyl',
        12  =>  'Cell Phones & Accessories',
        13  =>  'Clothing, Shoes & Jewelry',
        14  =>  'Women',
        15  =>  'Men',
        16  =>  'Girls',
        17  =>  'Boys',
        18  =>  'Baby',
        19  =>  'Collectibles & Fine Art',
        20  =>  'Computers',
        21  =>  'Courses',
        22  =>  'Credit and Payment Cards',
        23  =>  'Digital Music',
        24  =>  'Electronics',
        25  =>  'Gift Cards',
        26  =>  'Grocery & Gourmet Food',
        27  =>  'Handmade',
        28  =>  'Health, Household & Baby Care',
        29  =>  'Home & Business Services',
        30  =>  'Home & Kitchen',
        31  =>  'Industrial & Scientific',
        32  =>  'Kindle Store',
        33  =>  'Luggage & Travel Gear',
        34  =>  'Luxury Beauty',
        35  =>  'Magazine Subscriptions',
        36  =>  'Movies & TV',
        37  =>  'Musical Instruments',
        38  =>  'Office Products',
        39  =>  'Patio, Lawn & Garden',
        40  =>  'Pet Supplies',
        41  =>  'Prime Pantry',
        42  =>  'Software',
        43  =>  'Sports & Outdoors',
        44  =>  'Tools & Home Improvement',
        45  =>  'Toys & Games',
        46  =>  'Vehicles',
        47  =>  'Video Games',
        48  =>  'Wine',
    ],

    'sortc'=>[
        1=>'Price: Low to High',
        2=>'Price: High to Low',
        3=>'Avg. Customer Review',
        4=>'Newest Arrivals',
    ],

    'placec'=>[
        1 => 'Frequently Bought Together',
        2 => 'Sponsored Products Related To This Item',
        3 => 'Customers Who Bought This Item Also Bought',
        4 => 'Customers Also Shopped For',
        5 => 'What Other Items Do Customers Buy After Viewing This Item?',
        6 => 'Compare to Similar Items',
        7 => 'customers who viewd this item also viewd',
    ],

    'pagec'=>[
        1=>'1-3页',
        2=>'4-9页',
        3=>'10-20页',
    ],

    'platformc'=>[
        1=>'amazon.com'
    ]
];