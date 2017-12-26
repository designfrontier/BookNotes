#!/bin/bash

if [ -f "/home/vagrant/.bash_profile" ]; then
	if [ -L "/home/vagrant/.bash_profile" ]; then
		if [ $(readlink "/home/vagrant/.bash_profile") -eq "/vagrant/bash_profile" ]; then
			growl "Vagrant User's Bash Profile Already Correctly Symlinked. Skipping."
		else
			growl "Vagrant User's Bash Profile Incorrectly Symlinked. Fix This." true
		fi
	else
		growl "Vagrant User's Bash Profile Exists and is NOT a Symlink. Fix this." true
	fi
else
	growl "Linking Vagrant User's Bash Profile"
	ln -s "/vagrant/bash_profile" "/home/vagrant/.bash_profile"
fi
