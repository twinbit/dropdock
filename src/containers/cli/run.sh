#!/bin/bash

## Automatic discovery of ssh keys.
export HOME=$APACHE_HOME
if [ -f  ~/.ssh/id_rsa ]; then
  eval "$(ssh-agent -s)" > /dev/null 2>&1
  gosu www-data ssh-add ~/.ssh/id_rsa > /dev/null 2>&1
fi
if [ -f  ~/.ssh/hosts ]; then
  if [ ! -f ~/.ssh/known_hosts ]; then
    gosu www-data ssh-keyscan -H `cat ~/.ssh/hosts` >> ~/.ssh/known_hosts 2>&1
  fi
fi

# Bindfs mount using nginx env variables.
if [ -n "$LOCAL_UID" ] && [ -n "$LOCAL_GID" ]; then
  bindfs -u www-data -g www-data -p 0000,u=rwX:go=rD --create-for-user=${LOCAL_UID} --create-for-group=${LOCAL_GID} "/data/var/www" "/data/var/www"
  bindfs -u www-data -g www-data -p 0000,u=rwX:go=rD --create-for-user=${LOCAL_UID} --create-for-group=${LOCAL_GID} "$HOME" "$HOME"
fi

# Set the umask to 002 so that the group has write access.
umask 002
# Mimic libcontainer changing user to www-data using gosu.
exec gosu www-data "${@}"
