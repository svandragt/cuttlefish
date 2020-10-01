#!/usr/bin/env bash

sudo rm -rf /srv/app/_logs
sudo -u www-data mkdir /srv/app/{_logs,_cache,content} -p

sudo cp /vagrant/.vagrant/etc/ / -r
sudo service php7.4-fpm restart
sudo service nginx restart

echo "Ready. http://cuttlefish.test"
