#!/bin/bash
exec mkdir -p /data
exec mkdir -p /data/sss-keys
exec mkdir -p /data/var/www && chown -R www-data:www-data /data/var/www
exec mkdir -p /data/var/cache
exec mkdir -p /data/var/cache/drush && chown -R www-data:www-data /data/var/cache/drush
exec mkdir -p /data/var/log/nginx && chown -R www-data:www-data /data/var/log/nginx
exec mkdir -p /data/var/log/mysql
exec mkdir -p /data/var/log/php && chown -R www-data:www-data /data/var/log/php
exec mkdir -p /data/var/lib/mysql
exec $@
