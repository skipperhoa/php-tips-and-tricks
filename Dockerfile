# Dockerfile
FROM php:8.0-fpm

WORKDIR /var/www/html

# Cài đặt các extension PHP cần thiết (nếu có)
RUN docker-php-ext-install pdo_mysql

# Sao chép mã nguồn vào container (nếu cần)
COPY . /var/www/html
