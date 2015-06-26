# Dropdock

## Installing

### Phar

[Download dropdock.phar >](http://twinbit.github.io/dropdock/dropdock.phar)

```
wget http://twinbit.github.io/dropdock/dropdock.phar
```

To install globally put `dropdock.phar` in `/usr/bin`.

```
sudo chmod +x dropdock.phar && sudo mv dropdock.phar /usr/bin/dropdock
```

Now you can use it just like `dropdock`.

## Usage

Just run `dropdock init` in a empty folder to bootstrap a new dropdock project:

```
|-- bin
|   |-- cli
|   |-- drush
|   |-- mysql
|   |-- mysql_cli
|   |-- mysql_create
|   |-- mysql_import
|   |-- phing
|   `-- phpcs
|-- data
`-- fig.yml
```

(@TODO) Tweak `fig.yml` to match your needs and run `fig up -d` to run the containers.
At the first run fig will download and build remote containers, it can takes several minutes.


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

## TODO

- Move boot2local nfs configurations out of https://github.com/twinbit/dropdock-containers repository
- Refactor dropdockRoboFile::boot2dockerNfsSetup() to handle better mount.nfs "fsc" options (Related to cachefilesd)
- Create a custom iso tu automatically run the cachefilesd repository

```
FROM ubuntu:14.04
MAINTAINER Paolo Mainardi "paolo@twinbit.it"
ENV UPDATE_AT 1
RUN apt-get update && apt-get -y install cachefilesd
CMD /sbin/cachefilesd -n -f /etc/cachefilesd.conf -s
```
