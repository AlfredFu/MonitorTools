#!/bin/bash



yesterday=`date -d yesterday "+%Y-%m-%d %H:%M:%S"` 
curDate=`date  "+%Y%m%d"` 

mysqldump --skip-opt  --default-character-set=utf8 -t -h 127.0.0.1 -u root dbname tableName --where="update_time>='$yesterday'">"dbname.tableName_$curDate.sql"
mysqldump --skip-opt  --default-character-set=utf8 -t -h 127.0.0.1 -u root dbname tableName --where="ex_new_id in(Select id from ex_news where update_time>='$yesterday')" >"dbname.tableName_$curDate.sql"


sed -e 's/INSERT/REPLACE/' "dbname.tableName_$curDate.sql" >"tableName.sql"
sed -e 's/INSERT/REPLACE/' "dbname.tableName_$curDate.sql"> "tableName.sql"

mysql --default-character-set=utf8 dbname <"tableName.sql"

mysql --default-character-set=utf8 dbname <"tableName.sql"
