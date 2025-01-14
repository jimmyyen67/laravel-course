FROM php:8.3-fpm

# Install Dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    supervisor \
    nginx \
    nodejs \
    npm


# Insatll PHP Extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set Working Directory
WORKDIR /var/www/html

# Copy Project Files
COPY . .
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY ./docker/supervisor/laravel.conf /etc/supervisor/conf.d/laravel.conf

# Install NPM Dependencies and Build Assets
RUN npm install && npm run build

# Set Permission
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Install PHP Composer Dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

EXPOSE 9000 5173

# Start Supervisor
CMD ["/usr/bin/supervisord", "-n", "-c", "/etc/supervisor/supervisord.conf"]
