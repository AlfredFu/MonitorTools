#!/usr/bin/env python
import os
import MySQLdb
import sys
import lexismail
#os.system("mmm_control show")
db_conn=MySQLdb.connect("host","user",'password','databasename')
db_cursor=db_conn.cursor()
db_cursor.execute("show processlist")

conncount=db_cursor.rowcount
#print conncount
if conncount>50:
        lexismail.sendNotification("Too many connection on database server,connections now:%d" % conncount)
        #os.system("mmm_control set_offline db1");
        pass
