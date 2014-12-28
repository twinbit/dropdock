# Drupal Docker environment

![Docker + Drupal](https://raw.githubusercontent.com/twinbit/drupal-docker-env/master/src/dde.png)

## Boot2docker configuration steps:

In order to not going insane trying to fix vboxfs shared folder permissions, it is better to
use NFS from OSX in order to have an automatic mapping to local user uid/gid:

### OSX NFS Export

Edit your /etc/exports file as follows:

```
/Users -mapall=youruser:staff boot2docker
```

### Booot2docker configuration

```
boot2docker ssh
sudo umount /Users
sudo /usr/local/etc/init.d/nfs-client start
# See http://www.slashroot.in/how-do-linux-nfs-performance-tuning-and-optimization
# See http://www.gossamer-threads.com/lists/wiki/mediawiki-cvs/500057
sudo mount 192.168.59.3:/Users /Users -o rw,async,noatime,rsize=32768,wsize=32768,proto=tcp
```

## Sublime text NFS bug

If you are using SublimeText, you could experience this problem: https://github.com/mitchellh/vagrant/issues/2768:
`NFS not updating files if the file length stayed the same.`

To fix it: Sublime Text > Preferences > Settings- User

```
{
    "atomic_save": false
}
```

