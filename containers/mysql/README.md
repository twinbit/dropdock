## Drupal Docker Mysql

This images is partially inspired on [tutum/mysql](https://registry.hub.docker.com/u/tutum/mysql/) image.

### Scripts

In order to simplify the management of this image, a set of helper scripts are bundled with the container.

#### Create database

Create a new database:

```
fig run --rm mysql /create NAME_OF_YOUR_DB
```

#### Import sql dump

Import a new database

```
fig run --rm mysql /import [PATH_TO_FILE]
```

Where PATH_TO_FILE is the absolute path of `data` container automatically mounted on `/data`.

Example:

```
fig run --rm mysql /import /data/tmp/dump.sql
```

#### Command line

Access Mysql cli:

```
fig run --rm mysql /cli
```







