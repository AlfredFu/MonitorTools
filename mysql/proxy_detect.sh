#/bin/sh
IPTABLES="$(which iptables)"

#route connection 
IPTABLES -t nat -A PREROUTING -p tcp --dport 5050 -j REDIRECT --to-ports 3306
