#!/bin/bash
mysql -u root -h localhost -p123456 mysql<<EOFMYSQL
PURGE BINARY LOGS BEFORE date_sub(now(),interval 2 day);
EOFMYSQL
exit
