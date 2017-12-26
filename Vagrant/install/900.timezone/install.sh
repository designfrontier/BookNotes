#!/bin/bash

if [ ! -f /etc/timezone ]; then
	growl "Creating timezone file and setting Linux timezone to: America/Denver"
	touch /etc/timezone
	echo "America/Denver" > /etc/timezone
	dpkg-reconfigure --frontend noninteractive tzdata
else
	if [ "America/Denver" != "$(cat /etc/timezone)" ]; then
		growl "Setting Linux timezone to: America/Denver"
		echo "America/Denver" > /etc/timezone
		dpkg-reconfigure --frontend noninteractive tzdata
	else
		growl "Linux timezone already set to: America/Denver, skipping."
	fi
fi