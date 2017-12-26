#!/bin/bash


#	Install MySQL 5.6 & Utilities
mysql_packages=( 'mysql-server-5.6' 'mytop' 'mysql-utilities' )
for mysql_package in "${mysql_packages[@]}"; do :
	verify_apt_package_installed "$mysql_package"
	unset mysql_package
done
unset mysql_packages


#	Check MySQL Bind Address
if [ -f "/etc/mysql/my.cnf" ]; then
	grep "127.0.0.1" "/etc/mysql/my.cnf" &> /dev/null && {
		growl "Binding MySQL to All IP Addresses"
		sed -i s/127.0.0.1/0.0.0.0/ /etc/mysql/my.cnf
		service mysql restart
	} || {
		growl "MySQL Already Bound to All IP Addresses, Skipping"
	}
fi
