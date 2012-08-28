#!/bin/bash
#clear binlog 2 days before
mysql -u root -h localhost -p123456 mysql<<EOFMYSQL
PURGE BINARY LOGS BEFORE date_sub(now(),interval 2 day);
EOFMYSQL
exit
