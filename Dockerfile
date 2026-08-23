FROM php:8.4-cli

# Cài đặt các thư viện cần thiết cho Laravel & MySQL
RUN apt-get update -y && apt-get install -y \
    libzip-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_mysql zip

# Cài đặt Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Thiết lập thư mục làm việc
WORKDIR /var/www

# Copy toàn bộ code vào container
COPY . .

# Cài đặt dependencies (bỏ qua check platform cứng nhắc để tránh xung đột version)
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Phân quyền cho storage và bootstrap/cache
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Cấp cổng cho Render
EXPOSE 8080

# Chạy lệnh cấu hình và khởi chạy ứng dụng
CMD php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan storage:link || true && \
    php artisan migrate --force && \
    php artisan serve --host=0.0.0.0 --port=${PORT:-8080}