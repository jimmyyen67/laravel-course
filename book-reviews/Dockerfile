FROM php:8.2-fpm-alpine

# 安裝系統依賴
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    pkg-config \
    libsqlite3-dev

RUN docker-php-ext-install pdo pdo_mysql pdo_sqlite mbstring exif pcntl bcmath gd
RUN docker-php-ext-install pdo pdo_sqlite mbstring exif pcntl bcmath gd

# 安裝 Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 設定工作目錄
WORKDIR /var/www/html

# 複製專案檔案
COPY . .

# 安裝專案依賴
RUN composer install

# 設定權限
RUN chown -R www-data:www-data \
    /var/www/html/storage \
    /var/www/html/bootstrap/cache

# 啟動腳本
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# 其餘保持不變，並在最後添加
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

ENTRYPOINT ["docker-entrypoint.sh"]
