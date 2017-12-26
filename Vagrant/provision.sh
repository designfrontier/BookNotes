#!/bin/bash

#	Preload Common Variable(s) and Function(s)
function growl {
	if [ -z "$growl_partition" ]; then
		growl_partition=$( printf '#%.0s' {1..90} )
	fi
	if [ -z "$2" ]; then
		echo "$growl_partition"; echo $'#\n# '$"$1"$'\n#\n'; echo "$growl_partition";
	else
		>&2 echo "$growl_partition"; >&2 echo $'#\n# '$"$1"$'\n#\n'; >&2 echo "$growl_partition";
	fi
}

function verify_apt_package_installed {
	if [ -n "$1" ]; then
		if [ "$DEBIAN_FRONTEND" != "noninteractive" ]; then
			export DEBIAN_FRONTEND="noninteractive"
		fi
		dpkg -s "$1" &> /dev/null && {
			growl "Package Already Installed, Skipping: $1"
		} || {
			growl "Installing Package: $1"
			apt-get -y install "$1"
		}
	else
		growl "Apt Package to Verify Not Found";
	fi
}

#	Update/Upgrade Apt Packages
growl "Upgrading Apt Packages"
apt-get update >> /dev/null
apt-get -y upgrade

#	Install Required Packages with apt-get
apt_packages=( 'git' 'htop' 'ack-grep' 'silversearcher-ag' 'iotop' 'pv' 'sysbench' )
for apt_package in "${apt_packages[@]}"; do :
	verify_apt_package_installed "$apt_package"
	unset apt_package
done
unset apt_packages

#	Perform Additional Installations
for folder in /vagrant/install/*/; do
	file=$folder"install.sh"
	if [ -f "$file" ] && [ -x "$file"  ]; then
		growl "Running Install Script: $file"
		. "$file"
	else
		growl "Could Not Run Install Script: $file" true
	fi
	unset file
	unset folder
done

#	Clean Up Apt-Get
apt-get -y autoremove