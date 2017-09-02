# 开发：
## .env必填部分
|   name	|   Desc	|
|---	|---	|
|   DB_HOST	    |   数据库地址	|
|   DB_PORT	    |   数据库端口	|
|   DB_DATABASE	    |   数据库库名	|
|   DB_USERNAME	|   数据库用户名	|
|   DB_PASSWORD	|   数据库密码 |
|   MAIL_DRIVER	|   电子邮箱配置方式	|
|   MAIL_HOST	|   电子邮箱配置地址	|
|   MAIL_PORT	|   电子邮箱配置端口	|
|   MAIL_USERNAME	|   电子邮箱	|
|   MAIL_FROM_ADDRESS	|   电子邮箱	|
|   MAIL_FROM_NAME	|   电子邮箱别名	|
|   MAIL_PASSWORD	|   电子邮箱密码	|

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


# 部署：
## 环境要求
1. php >= 5.6.4 推荐7+
2. mysql或者mariadb
3. nginx或者apache

```
nginx配置
location / {
    try_files $uri $uri/ /index.php?$query_string;
}
```

## 安装
1. 解压zip包到web目录
2. 将解压目录中.env文件进行编辑
3. 在项目目录根目录下执行以下命令，初始化数据库
```
php artisan migrate
php artisan db:seed
```

## sql
```sql
alter table `click_farms` add `keyword` varchar(100) DEFAULT '' after `bd`;
```