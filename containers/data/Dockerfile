FROM debian:jessie
MAINTAINER Paolo Mainardi <paolo@twinbit.it>
ENV REFRESHED_AT 2014-11-24
RUN mkdir -p /data && \
    mkdir -p /data/sss-keys && \
    mkdir -p /data/etc && \
    mkdir -p /data/var/www && chown -R www-data:www-data /data/var/www && \
    mkdir -p /data/var/cache && \
    mkdir -p /data/var/apps/drush && chown -R www-data:www-data /data/var/apps/drush && \
    mkdir -p /data/var/cache/composer && chown -R www-data:www-data /data/var/cache/composer && \
    mkdir -p /data/var/log/nginx && chown -R www-data:www-data /data/var/log/nginx && \
    mkdir -p /data/var/log/mysql && \
    mkdir -p /data/var/log/php && chown -R www-data:www-data /data/var/log/php && \
    mkdir -p /data/var/lib/mysql
VOLUME ["/data"]
CMD true
