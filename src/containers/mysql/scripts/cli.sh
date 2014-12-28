#!/bin/bash
/run.sh > /dev/null 2>&1 &
RET=1
echo "=> Starting MySQL Server"
while [[ RET -ne 0 ]]; do
  sleep 1
  mysql -u${MYSQL_USER} -p${MYSQL_PASS} -h127.0.0.1 -e "status"  > /dev/null 2>&1
  RET=$?
done
exec mysql -u${MYSQL_USER} -p${MYSQL_PASS} -h127.0.0.1
