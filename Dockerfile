FROM ubuntu:jammy

ENV TZ=UTC
ARG ssh_prv_key

#
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
#
RUN apt update
#php install
RUN apt install php8.1 -y
RUN apt install php8.1-curl -y
RUN apt install php8.1-xml -y
RUN apt install composer -y
#key to clone
RUN mkdir /root/.ssh/
RUN echo "$ssh_prv_key" > /root/.ssh/id_rsa
RUN chmod 400 /root/.ssh/id_rsa
RUN ssh-keyscan github.com >> /root/.ssh/known_hosts
#
RUN git clone git@github.com:mv28jam/PHP-chess-with-console-view.git /var/www/php-chess
#clean key
RUN rm /root/.ssh/id_rsa
WORKDIR /var/www/php-chess
RUN composer install --no-dev