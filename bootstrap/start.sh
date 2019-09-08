#!/usr/bin/env bash

sudo rm -rf /srv/carbon/logs
sudo -u www-data mkdir /srv/carbon/logs -p

sudo cp /vagrant/bootstrap/etc/ / -r
sudo service php7.3-fpm restart
sudo service nginx restart

echo "Ready. http://carbon.test"