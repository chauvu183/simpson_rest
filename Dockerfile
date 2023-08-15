FROM php:8.1 as app

# Install system dependencies
RUN apt-get update -y
RUN apt-get install -y unzip

# Install PHP extensions including pdo_pgsql
RUN apt-get install -y unzip libpq-dev libcurl4-gnutls-dev
RUN docker-php-ext-install pdo pdo_pgsql bcmath


WORKDIR /var/www

COPY . .

COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

RUN composer install

ENV PORT=8000
ENTRYPOINT [ "docker/entrypoint.sh" ]


