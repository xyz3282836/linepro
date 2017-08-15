<?php

return [

    //每页多少条目
    'perpage'          => 10,

    /**
     * form
     */
    'time_typec'       => [
        1 => '限时下单(24小时)',
        3 => '普通下单(36小时)'
    ],
    /**
     * form
     */

    /**
     * db-text
     */
    'delivery_type'    => [
        1 => '自行转运',
        2 => '达购转运'
    ],
    'order_ptype'      => [
        1 => '支付宝',
    ],
    'time_type'        => [
        1 => '限时下单',
        3 => '普通下单'
    ],
    'cf_status'        => [
        0 => '取消订单',
        1 => '待支付',
        2 => '已经支付',
        3 => '正在找寻代购账号',
        4 => '购买中',
        5 => '购买完成',
        6 => '进行中',
    ],
    'from_site'        => [
        1  => '美国',
        2  => '加拿大',
        3  => '英国',
        4  => '德国',
        5  => '法国',
        6  => '日本',
        7  => '',
        8  => '西班牙',
        9  => '',
        10 => '意大利',
    ],
    'currency'         => [
        1 => '美元',
        2 => '加拿大元',
        3 => '英镑',
        4 => '欧元',
        5 => '日元',
    ],
    'bill_type'        => [
        0 => '注册送金币',
        1 => '充值金币',
        2 => '代购消费',
        3 => '退款',
    ],
    'order_status'     => [
        0 => '已删除',
        1 => '待付款',
        2 => '已付款',
        3 => '进行中',
        4 => '全部完成',
        5 => '全部失败',
        6 => '部分失败',
    ],
    'cfresult_status'  => [
        1 => '待发货',
        6 => '进行中',
        2 => '待评价',
        3 => '已提交',
        4 => '评价成功',
        5 => '评价失败',
    ],
    'order_type'       => [
        1 => '充值',
        2 => '消费',
        3 => '退款',
    ],
    'user_level'       => [
        1 => '普通会员',
        2 => '认证会员'
    ],
    'banner_type_text' => [
        1 => '轮播banner',
        2 => 'logo',
        3 => '购物车页banner',
        4 => '新建页面banner',
        5 => '首页图片',
        6 => '首页logo',
    ],
    'user_evaluate'    => [
        0 => '禁止评价',
        1 => '可评价'
    ],
    'is_fba'          => [
        0 => '非亚马逊发货(FBM)',
        1 => '亚马逊发货(FBA)'
    ],
    /**
     * db-text
     */

    /**
     * 自定义
     */
    'cf_statuss'       => [
        0 => '综合',
        2 => '已经支付',
        3 => '正在找寻代购账号',
        4 => '购买中',
        5 => '购买完成',
    ],
    'bill_types'       => [
        -1 => '综合',
        0  => '注册送金币',
        1  => '充值金币',
        2  => '代购消费',
        3  => '退款',
    ],
    'order_statuss'    => [
        1 => '待付款',
        2 => '已付款',
        3 => '进行中',
        4 => '全部完成',
        5 => '全部失败',
        6 => '部分失败',
    ],
    'admin_order_type' => [
        'all' => '全部',
        1     => '充值',
        2     => '消费',
        3     => '退款',
    ],
    'admin_user_level' => [
        'all' => '全部',
        1     => '普通会员',
        2     => '认证会员'
    ],
    /**
     * 自定义
     */

    'bigc' => [
        0  => '不选类别直接搜索',
        1  => 'Alexa Skills',
        2  => 'Amazon Video',
        3  => 'Amazon Warehouse Deals',
        4  => 'Appliances',
        5  => 'Apps & Games',
        6  => 'Arts, Crafts & Sewing',
        7  => 'Automotive Parts & Accessories',
        8  => 'Baby',
        9  => 'Beauty & Personal Care',
        10 => 'Books',
        11 => 'CDs & Vinyl',
        12 => 'Cell Phones & Accessories',
        13 => 'Clothing, Shoes & Jewelry',
        14 => 'Women',
        15 => 'Men',
        16 => 'Girls',
        17 => 'Boys',
        18 => 'Baby',
        19 => 'Collectibles & Fine Art',
        20 => 'Computers',
        21 => 'Courses',
        22 => 'Credit and Payment Cards',
        23 => 'Digital Music',
        24 => 'Electronics',
        25 => 'Gift Cards',
        26 => 'Grocery & Gourmet Food',
        27 => 'Handmade',
        28 => 'Health, Household & Baby Care',
        29 => 'Home & Business Services',
        30 => 'Home & Kitchen',
        31 => 'Industrial & Scientific',
        32 => 'Kindle Store',
        33 => 'Luggage & Travel Gear',
        34 => 'Luxury Beauty',
        35 => 'Magazine Subscriptions',
        36 => 'Movies & TV',
        37 => 'Musical Instruments',
        38 => 'Office Products',
        39 => 'Patio, Lawn & Garden',
        40 => 'Pet Supplies',
        41 => 'Prime Pantry',
        42 => 'Software',
        43 => 'Sports & Outdoors',
        44 => 'Tools & Home Improvement',
        45 => 'Toys & Games',
        46 => 'Vehicles',
        47 => 'Video Games',
        48 => 'Wine',
    ],

    'sortc' => [
        1 => 'Price: Low to High',
        2 => 'Price: High to Low',
        3 => 'Avg. Customer Review',
        4 => 'Newest Arrivals',
    ],

    'placec' => [
        1 => 'Frequently Bought Together',
        2 => 'Sponsored Products Related To This Item',
        3 => 'Customers Who Bought This Item Also Bought',
        4 => 'Customers Also Shopped For',
        5 => 'What Other Items Do Customers Buy After Viewing This Item?',
        6 => 'Compare to Similar Items',
        7 => 'customers who viewd this item also viewd',
    ],

    'pagec' => [
        1 => '1-3页',
        2 => '4-9页',
        3 => '10-20页',
    ],

    'platformc' => [
        1 => 'amazon.com'
    ]
];