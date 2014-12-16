TODO TODO TODO

Boot2docker configuration steps:
```
sudo umount /Users
sudo /usr/local/etc/init.d/nfs-client start
# See http://www.slashroot.in/how-do-linux-nfs-performance-tuning-and-optimization
# See http://www.gossamer-threads.com/lists/wiki/mediawiki-cvs/500057
sudo mount 192.168.59.3:/Users /Users -o rw,async,noatime,rsize=32768,wsize=32768,proto=tcp
```

If you are using SublimeText, you could experience this problem: https://github.com/mitchellh/vagrant/issues/2768:
`NFS not updating files if the file length stayed the same.`
To fix it: Sublime Text > Preferences > Settings- User
```
{
    "atomic_save": false
}
```

