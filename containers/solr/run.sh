#!/bin/bash


# check for configuration directories

for D in /tmp/solr-configs/*; do
	NAME=`basename ${D}`
    if [ -f "${D}/conf/solrconfig.xml" ]; then
		echo "found config for ${NAME}"
		ln -s ${D} /opt/solr/example/multicore/${NAME}
		sed -i "s/\[core_name\]/${NAME}/g" /opt/solr/example/multicore/solr.xml
    fi
done


# start solr

cd /opt/solr/example
java -Xmx1024m -DSTOP.PORT=8079 -DSTOP.KEY=stopkey -Dsolr.solr.home=multicore -jar start.jar