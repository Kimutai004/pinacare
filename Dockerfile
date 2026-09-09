FROM php:8.2-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update \
    && apt-get install -y --no-install-recommends git unzip libpq-dev libzip-dev nodejs npm \
    && docker-php-ext-install pdo_pgsql zip \
    && a2enmod rewrite headers deflate expires \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf \
    && sed -ri -e 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-scripts

COPY . .
RUN composer dump-autoload --no-dev --no-interaction --optimize

COPY package.json vite.config.js tailwind.config.js ./
COPY resources ./resources
RUN npm install && npm run build && rm -rf node_modules

COPY docker/entrypoint.sh /usr/local/bin/pinacare-entrypoint

RUN chmod +x /usr/local/bin/pinacare-entrypoint \
    && mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache

ENTRYPOINT ["pinacare-entrypoint"]