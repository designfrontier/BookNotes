#!/bin/bash


#	Add PPA Repository
if [ -f /etc/apt/sources.list.d/ondrej-php-trusty.list ]; then
	growl "PHP Apt Repository (Ondrej) Already Added, Skipping"
else
	growl "Adding PHP Apt Repository (Ondrej)"
	add-apt-repository -y ppa:ondrej/php 2>1 >> /dev/null
	apt-get update >> /dev/null
	apt-get -y upgrade
fi


#	Install PHP Packages
apt_packages=( 'php7.2' 'php7.2-mysql' 'php7.2-mbstring' 'php7.2-zip' 'php7.2-json' 'php7.2-curl' 'php-mcrypt' 'php7.2-xml' 'phpunit' )
for apt_package in "${apt_packages[@]}"; do :
	verify_apt_package_installed "$apt_package"
	unset apt_package
done
unset apt_packages


#	Enable Mcrypt Module
phpenmod mcrypt


#	Make sure PHP5 is disabled
apache2ctl -M | grep php5 >> /dev/null && {
	growl 'Disabling Apache PHP5.'
	a2dismod php5
} || {
	growl 'Apache PHP5 Already Disabled. Skipping.'
}


#	Restart Apache
service apache2 restart
