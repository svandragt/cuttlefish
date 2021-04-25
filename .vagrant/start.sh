#!/usr/bin/env bash

sudo mkdir /srv/app/content -p

sudo rm -rf /srv/app/data/_logs
sudo -u www-data mkdir /srv/app/data/{_logs,_cache} -p

sudo cp /srv/app/.vagrant/etc/ / -r
sudo service php7.4-fpm restart
sudo service nginx restart
echo ""
echo "🐡  Ready. http://cuttlefish.test"
