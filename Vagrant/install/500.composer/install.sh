#!/bin/bash

which composer >> /dev/null && {
	growl "Composer Already Installed, Updating"
	composer self-update
} || {
	growl "Installing Composer"
	curl -sS https://getcomposer.org/installer | php
	mv composer.phar /usr/local/bin/composer
}