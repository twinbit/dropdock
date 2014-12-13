#!/bin/bash
if [ -f  ~/.ssh/id_rsa ]; then
 eval "$(ssh-agent -s)"
 ssh-add ~/.ssh/id_rsa
fi
if [ -f  ~/.ssh/hosts ]; then
 ssh-keyscan -H `cat ~/.ssh/hosts` >> ~/.ssh/known_hosts
fi
exec $@
