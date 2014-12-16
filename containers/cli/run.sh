#!/bin/bash
if [ -f  ~/.ssh/id_rsa ]; then
 eval "$(ssh-agent -s)" > /dev/null 2>&1
 ssh-add ~/.ssh/id_rsa > /dev/null 2>&1
fi
if [ -f  ~/.ssh/hosts ]; then
 ssh-keyscan -H `cat ~/.ssh/hosts` >> ~/.ssh/known_hosts 2>&1
fi
# Set the umask to 002 so that the group has write access.
umask 002
exec "${@}"
