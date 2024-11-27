FROM php:8.1-fpm

# Cài đặt các gói cần thiết, bao gồm libwebp
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zlib1g-dev \
    libicu-dev \
    libzip-dev \
    libwebp-dev  # Thêm thư viện libwebp

# Cài đặt và kích hoạt các extension PHP cần thiết
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp && \
    docker-php-ext-install gd

# Cài đặt các extension khác
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Xóa bỏ các gói không cần thiết sau khi cài đặt
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Cấu hình thư mục làm việc (nếu cần)
WORKDIR /var/www/html

EXPOSE 9000
