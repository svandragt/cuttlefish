FROM php:7.3-fpm
LABEL maintainer="Sander van Dragt <sander@vandragt.com>"

# Install application dependencies
RUN curl --silent --show-error --fail --location \
      --header "Accept: application/tar+gzip, application/x-gzip, application/octet-stream" -o - \
      "https://caddyserver.com/download/linux/amd64?plugins=http.expires,http.realip&license=personal" \
    | tar --no-same-owner -C /usr/bin/ -xz caddy \
    && chmod 0755 /usr/bin/caddy \
    && /usr/bin/caddy -version \
    && docker-php-ext-install mbstring pdo pdo_mysql

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY src /srv/app
COPY Caddyfile /etc/Caddyfile

WORKDIR /srv/app/
RUN chown -R www-data:www-data /srv/app

CMD ["/usr/bin/caddy", "--conf", "/etc/Caddyfile", "--log", "stdout"]
