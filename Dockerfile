# Gunakan PHP 8.2 CLI (lebih ringan)
FROM php:8.2-cli

# Install ekstensi yang dibutuhkan Laravel
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy semua file Laravel ke container
COPY . .

# Install dependency Laravel
RUN composer install --no-dev --optimize-autoloader

# Set permission untuk Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose port (Render akan isi $PORT)
EXPOSE 8000

# Jalankan Laravel pakai php artisan serve
CMD php artisan serve --host=0.0.0.0 --port=$PORT
