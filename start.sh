#!/usr/bin/env bash
fig up data
mkdir -p data
docker run --rm -v /usr/local/bin/docker:/docker -v /var/run/docker.sock:/docker.sock svendowideit/samba data
mount_smbfs //guest@`boot2docker ip`/data ./data
