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

# Based on: http://chapeau.freevariable.com/2014/08/docker-uid.html
export ORIGPASSWD=$(cat /etc/passwd | grep www-data)
export ORIG_UID=$(echo $ORIGPASSWD | cut -f3 -d:)
export ORIG_GID=$(echo $ORIGPASSWD | cut -f4 -d:)
export DEV_UID=${APACHE_UID:=$ORIG_UID}
export DEV_GID=${APACHE_GID:=$ORIG_GID}
groupdel dialout
sed -i -e "s/:$ORIG_UID:$ORIG_GID:/:$DEV_UID:$DEV_GID:/" /etc/passwd
sed -i -e "s/www-data:x:$ORIG_GID:/www-data:x:$DEV_GID:/" /etc/group
chown -R ${DEV_UID}:${DEV_GID} ${APACHE_HOME}

# Set the umask to 002 so that the group has write access.
umask 002
# Mimic libcontainer changing user to www-data using gosu.
exec gosu www-data "${@}"
#exec "${@}"
