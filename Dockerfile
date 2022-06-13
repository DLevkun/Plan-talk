FROM ubuntu

ENV TZ=Europe/Kiev
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt update && apt-get update
RUN apt install apt-transport-https software-properties-common -y
RUN add-apt-repository ppa:ondrej/php

RUN apt install -y \
    apache2 \
    php8.0 \
    php-mysql \
    redis-server \
    git \
    curl

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app

COPY . .

#RUN php artisan migrate
#RUN php artisan db:seed

EXPOSE 9000

ENTRYPOINT ["php", "artisan", "serve", "--host", "0.0.0.0", "--port=9000"]
