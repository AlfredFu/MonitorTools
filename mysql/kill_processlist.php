<?php
mysql_connect('host','user','password');
$result = mysql_query("SHOW FULL PROCESSLIST");

while ($row=mysql_fetch_array($result)) {
    $process_id=$row["Id"];
    if ($row['Host'] !='hostname' && $row['User']!='system user' && $row['User']!='replication') {
        $sql="KILL $process_id";
        mysql_query($sql);
    }   
}
