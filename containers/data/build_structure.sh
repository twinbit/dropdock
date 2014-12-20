#!/bin/bash
mkdir -p /data && \
mkdir -p /data/ssh-keys && \
mkdir -p /data/etc && \
mkdir -p /data/var/www && \
mkdir -p /data/var/apps/drush && \
mkdir -p /data/var/cache/composer  && \
mkdir -p /data/var/log/nginx  \
mkdir -p /data/var/log/mysql && \
mkdir -p /data/var/log/php && \
mkdir -p /data/var/lib/mysql
exec $@
