#!/usr/bin/env bash

apt-get update
apt-get install -y php5 php-pear apache2 php5-suhosin
rm -rf /var/www
ln -fs /vagrant/public /var/www
sed -i '/AllowOverride None/c AllowOverride All' /etc/apache2/sites-available/default
a2enmod rewrite
service apache2 reload
