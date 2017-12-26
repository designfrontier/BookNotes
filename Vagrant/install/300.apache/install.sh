#!/bin/bash


#	Install Apache2 Web Server
verify_apt_package_installed "apache2"


#	Fix Annoying ServerName Missing Error
if [ ! -f /etc/apache2/conf-available/servername.conf ]; then
	growl 'Installing Apache ServerName conf.'
	cp $( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/conf/servername.conf /etc/apache2/conf-available/
	a2enconf servername
else
	growl 'Apache ServerName conf already installed.'
fi


#	Make sure mod_rewrite is enabled
apache2ctl -M | grep rewrite >> /dev/null && {
	growl 'Apache mod_rewrite already enabled.'
} || {
	growl 'Enabling Apache mod_rewrite.'
	a2enmod rewrite
}


#	Setup Virtual Hosts
for conf_file_path in $( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/vhosts/*.conf; do
	if [ -f $conf_file_path ]; then
		conf_file_name=$(basename "$conf_file_path")
		conf_name="${conf_file_name%.*}"
		if [ -d /var/www/$conf_name ]; then
			if [ ! -f /etc/apache2/sites-available/$conf_file_name ]; then
				growl $'Installing and Activating Apache Virtual Host:\n# '"$conf_file_path"
				ln -s $conf_file_path /etc/apache2/sites-available/$conf_file_name
				a2ensite $conf_file_name
			else
				if [ ! -f /etc/apache2/sites-enabled/$conf_file_name ]; then
					growl $'Apache Virtual Host Installed but inactive, Activating:\n# '"$conf_file_path"
					a2ensite $conf_file_name
				else
					growl $'Apache Virtual Host Already Installed and Activated, skipping:\n# '"$conf_file_path"
				fi
			fi
		else
			growl "Could Not Install Apache Virtual Host, Missing Git Repo."$'\n#\n'"# VHost Conf:"$'\t\t'"$conf_file_path"$'\n'"# Expected Repo Path:"$'\t'"/var/www/$conf_name" true
		fi
		unset conf_file_name
		unset conf_name
	fi
	unset conf_file_path
done


#	Disable Default Apache Site
a2query -s 000-default 2>1 >> /dev/null && {
	growl "Disabling Default Apache Site"
	a2dissite 000-default
} || {
	growl "Default Apache Site Not Enabled. Skipping."
}

#	Restart Apache Server
growl "Restarting Apache Server"
apachectl restart
