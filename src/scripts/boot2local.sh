#|/bin/bash
sudo umount /Users
sudo /usr/local/etc/init.d/nfs-client start
sudo mount 192.168.59.3:/Users /Users -o rw,async,noatime,rsize=32768,wsize=32768,proto=tcp
