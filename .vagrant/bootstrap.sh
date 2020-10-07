#!/usr/bin/env bash
export DEBIAN_FRONTEND=noninteractive

# Requirements
if ! [ -x "$(command -v php)" ]
then
  echo "📦  Installing packages..."
  echo 'Dpkg::Use-Pty "0";' > /etc/apt/apt.conf.d/00usepty
  add-apt-repository -y ppa:ondrej/php
  apt-get -qq -y update
  apt-get -qq -y install nginx zip php7.4-cli php7.4-fpm php7.4-xdebug php7.4-curl php7.4-xml php7.4-mbstring
  apt-get -qq clean && apt-get -qq -y autoremove &
fi


# Composer
FILE=/usr/bin/composer
if [[ ! -f $FILE ]]
then
  echo "🎼  Installing Composer..."
  curl -Ss https://getcomposer.org/installer | php
  mv composer.phar $FILE
fi

# Phive
FILE=/usr/local/bin/phive
if [[ ! -f $FILE ]]
then
  echo "🐝  Installing Phive..."
  wget -qO phive.phar "https://phar.io/releases/phive.phar"
  wget -qO phive.phar.asc "https://phar.io/releases/phive.phar.asc"
  gpg --keyserver hkps.pool.sks-keyservers.net --recv-keys 0x9D8A98B29B2D5D79
  gpg --verify phive.phar.asc phive.phar
  rm phive.phar.asc
  chmod +x phive.phar
  mv phive.phar $FILE
fi

pushd /vagrant || exit
  echo "🐡  Setup Cuttlefish..."
  sudo -u vagrant -H composer guest:setup
popd || exit
