#/bin/sh
#monitor mysql proxy host is running or not
LANG=C

#host list
server_all_list=(\
10.123.4.212:4040 \
)
date=$(date -d "today" +"%Y-%m-%d_%H:%M:%S")

server_all_len=${#server_all_list[*]}
i=0

#IPTABLES="$(which iptables)"
#route connection 
#IPTABLES -t nat -A PREROUTING -p tcp --dport 5050 -j REDIRECT --to-ports 3306
IPTABLES="$(which iptables)"

while [ $i -lt $server_all_len ]
do
	server_ip=$(echo ${server_all_list[$i]}| awk -F ':' '{print $1}')
	server_port=$(echo ${server_all_list[$i]}| awk -F ':' '{print $2}')
	is_send_msg=0
	if nc -vv -z -w 3 $server_ip $server_port >/dev/null 1>&1
	then
		#status 0,http down 1,http ok 2,http down but ping ok
		status=1
		#echo "服务器${server_ip},端口${server_port}能够正常访问"
	else
		if nc -vv -z -w 10 $server_ip $server_port >/dev/null 2>&1
		then
			status=1
			#echo "服务器${server_ip},端口${server_port}能够正常访问"
		else
			if ping -c 1 $server_ip >/dev/null 2>&1
			then
				status=2
				echo "SERVER:${server_ip},PORT:${server_port}connectio refused,but ping successfully"
				message="Connect to server failed,but ping successfully"
				is_send_msg=1
			else
				status=0
				echo "SERVER:${server_ip},PORT:${server_port} connection refused,and fail to ping"
				message="Connect to server failed,ping failed"
				is_send_msg=1
				
			fi
		fi
		if is_send_msg=1
		then
			echo "ALERTING SERVER:${server_ip},ALERTING MSG:$message,TIME:$date"| mail -s "MYSQL PROXY ALERTING" 13482736200@139.com
			$IPTABLES -t nat -A PREROUTING -p tcp --dport 4040 -j REDIRECT --to-ports 3306
            $IPTABLES -t nat -A OUTPUT -p tcp -d 10.123.4.212 --dport 4040 -j DNAT --to 10.123.4.212:3306
		fi
	fi
	let i++
done	
