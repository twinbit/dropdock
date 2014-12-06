sudo umount /Users
sudo /usr/local/etc/init.d/nfs-client start
# See http://www.slashroot.in/how-do-linux-nfs-performance-tuning-and-optimization
sudo mount 192.168.59.3:/Users /Users -o rw,async
