FROM php:8.4-fpm-alpine

# Cài đặt Nginx, Git, Zip và các extension PHP cần thiết
RUN apk add --no-cache nginx git zip unzip libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip opcache

# Cài Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

# Cài dependencies Laravel
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Phân quyền cho Laravel
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache

# Cấu hình Nginx tối ưu cho Laravel
RUN mkdir -p /run/nginx
RUN echo 'server { \
    listen 8080 default_server; \
    root /var/www/public; \
    index index.php index.html; \
    location / { \
        try_files $uri $uri/ /index.php?$query_string; \
    } \
    location ~ \.php$ { \
        fastcgi_pass 127.0.0.1:9000; \
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name; \
        include fastcgi_params; \
    } \
}' > /etc/nginx/http.d/default.conf

EXPOSE 8080

# Chạy song song PHP-FPM và Nginx
CMD php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache && \
    php artisan storage:link || true && \
    php artisan migrate --force && \
    php-fpm -D && nginx -g "daemon off;"