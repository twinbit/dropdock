
This image is cannot be executed as-is!

The startup script (`run.sh`) searches for solr core configuration directories in `/tmp/solr-configs`.

So remember to map a volume to that dir, some examples follows:

```
ADD /your/configuration/folder /tmp/solr-configs/core0
VOLUME /your/configuration/folder:/tmp/solr-configs/core0
```

Use `VOLUME` if you want the indexed data to be persistent across image runs.