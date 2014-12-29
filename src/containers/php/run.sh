#!/bin/bash

# Bindfs remount using local env variables.
if [ -n "$LOCAL_UID" ] && [ -n "$LOCAL_GID" ]; then
  bindfs -u www-data -g www-data -p 0000,u=rwX:go=rD --create-for-user=${LOCAL_UID} --create-for-group=${LOCAL_GID} "/data/var/www" "/data/var/www"
fi
exec "${@}"
