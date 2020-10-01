#!/usr/bin/env bash
export DEBIAN_FRONTEND=noninteractive

add-apt-repository -y ppa:ondrej/php

apt-get -y update
apt-get -y install nginx zip
apt-get -y install php7.4-cli php7.4-fpm php7.4-xdebug php7.4-curl

apt-get clean && apt-get -y autoremove &

curl -Ss https://getcomposer.org/installer | php
mv composer.phar /usr/bin/composer
pushd /vagrant || exit
  sudo -u vagrant -H composer install
popd || exit
