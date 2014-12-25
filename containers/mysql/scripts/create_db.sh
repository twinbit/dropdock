#!/bin/bash
if [[ $# -eq 0 ]]; then
  echo "Usage: $0 <db_name>"
  exit 1
fi

echo "=> Starting MySQL Server"
/run.sh > /dev/null 2>&1 &

echo "=> Creating database $1"
RET=1
while [[ RET -ne 0 ]]; do
  sleep 5
  mysql -u${MYSQL_USER} -p${MYSQL_PASS} -h127.0.0.1 -e "CREATE DATABASE $1"
  RET=$?
done

mysqladmin -uroot shutdown

echo "=> Done!"
