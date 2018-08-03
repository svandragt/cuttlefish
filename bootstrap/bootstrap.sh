#!/usr/bin/env bash
export DEBIAN_FRONTEND=noninteractive

add-apt-repository -y ppa:ondrej/php
add-apt-repository -y ppa:nginx/development

apt-get -y update
apt-get -y install nginx zip
apt-get -y install php7.2-cli php7.2-fpm php7.2-xdebug

apt-get clean && apt-get -y autoremove &

curl -Ss https://getcomposer.org/installer | php
mv composer.phar /usr/bin/composer

cp /vagrant/bootstrap/etc/ / -r

pushd /vagrant
composer update
popd

service nginx restart
