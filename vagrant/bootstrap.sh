#!/usr/bin/env bash

apt-get update
apt-get install -y php5 php-pear apache2 php5-suhosin php5-curl
rm -rf /var/www
ln -fs /vagrant/public /var/www
mkdir /vagrant/cache
chown :www-data /vagrant/cache -R
chmod g+w /vagrant/cache -R
sed -i '/AllowOverride None/c AllowOverride All' /etc/apache2/sites-available/default
a2enmod rewrite
service apache2 reload
