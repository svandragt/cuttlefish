#!/usr/bin/env bash
export DEBIAN_FRONTEND=noninteractive


# Requirements
add-apt-repository -y ppa:ondrej/php
apt-get -y update
apt-get -y install nginx zip
apt-get -y install php7.4-cli php7.4-fpm php7.4-xdebug php7.4-curl php7.4-xml
apt-get clean && apt-get -y autoremove &

# Composer
curl -Ss https://getcomposer.org/installer | php
mv composer.phar /usr/bin/composer

# Phive
wget -O phive.phar "https://phar.io/releases/phive.phar"
wget -O phive.phar.asc "https://phar.io/releases/phive.phar.asc"
gpg --keyserver hkps.pool.sks-keyservers.net --recv-keys 0x9D8A98B29B2D5D79
gpg --verify phive.phar.asc phive.phar
rm phive.phar.asc
chmod +x phive.phar
mv phive.phar /usr/local/bin/phive

pushd /vagrant || exit
  sudo -u vagrant -H composer guest-setup
popd || exit
