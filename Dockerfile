FROM php:8.1-fpm
WORKDIR /var/www
RUN apt-get update && apt-get install -y \
    zip unzip git curl libpng-dev \
    && docker-php-ext-install pdo_mysql
COPY . .
RUN chmod -R 775 storage bootstrap/cache
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
EXPOSE 8000