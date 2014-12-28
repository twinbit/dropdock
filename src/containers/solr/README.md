# Docker drupal search api solr container

This image can be used as-is, it is based on search_api_solr solr 4.x configurations.

## Example fig configuration

```
solr:
  build: containers/solr
  hostname: solr
  ports:
    - "8983:8983"
  command: -Xmx1024m -DSTOP.PORT=8079 -DSTOP.KEY=stopkey -jar start.jar
```

