**.env 环境配置文件**

1. 下载依赖，执行命令  composer install 
2. 数据库迁移，执行命令  php artisan migrate

|   Table	|   Desc	|
|---	|---	|
|   users	    |   用户	|
|   password_resets	    |   密码重置	|
|   click_farms	|   刷单	|
|   evaluates	|   评价	|
|   account	|   账户	|
|   recharges	|   充值记录	|
|   bills	|   交易流水	|


部署：
1. php >= 5.6.4 推荐7+
2. mysql或者mariadb
3. nginx或者apache

```
nginx配置
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```
