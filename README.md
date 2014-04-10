Personal Account Manager System
==============

AccountManager, made by zf2 with 3-tier architecture
## Note ##

 - View layer use ExtJS (**Following GPL LICENSE**)
 - But Others use **MIT LICENSE** (Do you want to do.)

## Install ##

**Webroot:** /ams/public

**Mysql config:** /ams/module/Propel/config/zf2-domain-model-conf.php

**Writeable directory:** /ams/public/captcha

**ExtJS library path:** /ams/public/ext (build with ExtJs 4.1.x, [download][1])

**Library dependencies:** *composer install* (For composer installation, see [here][2])

**Database initialization：**

 - create database account_manager
 - import tables by /ams/module/Propel/build/sql/schema.sql
 - import demo data by /ams/module/Propel/build/sql/ams-init.sql


## Deploy ##
### Nginx ###
    log_format  ams.host.org  '$remote_addr - $remote_user [$time_local] "$request" '                                                                                            
    '$status $body_bytes_sent "$http_referer" '
    '"$http_user_agent" $http_x_forwarded_for';
    server
    {
        listen       80; 
        server_name ams.host.org;
        index index.html index.htm index.php default.html default.htm default.php;
        root  /path/ams/ams.host.org/public;

        location ~ .*\.(php|php5)?$
        {   
            try_files       $uri =404;
            fastcgi_pass    127.0.0.1:9000;
            fastcgi_index   index.php;
            include fcgi.conf;
        }   

        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
        {   
            expires      30d;
        }   

        location ~ .*\.(js|css)?$
        {   
            expires      12h;
        }   

        access_log  /data/logs/ams.host.org.log  ams.host.org;
    }

## Test ##

    http://ams.host.org
    (default user: demo/demo)
Enjoying it~

  [1]: http://www.sencha.com/products/extjs/download/
  [2]: https://getcomposer.org/