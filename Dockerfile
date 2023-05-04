FROM ubuntu:jammy

ENV TZ=UTC

#
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
#
RUN apt update
#php install
RUN apt install php8.1 -y
RUN apt install php8.1-curl -y
RUN apt install php8.1-xml -y
RUN apt install composer -y
#
RUN git clone https://github.com/mv28jam/PHP-chess-with-console-view.git /var/www/php-chess
#clean key
WORKDIR /var/www/php-chess
RUN composer install --no-dev