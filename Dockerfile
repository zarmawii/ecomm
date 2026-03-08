# =========================
# Laravel + Vite (Render Ready)
# =========================

FROM php:8.4-cli

WORKDIR /var/www

# -------------------------
# System dependencies
# -------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libicu-dev \
    sqlite3 \
    libsqlite3-dev \
    npm \
    nodejs \
    python3 \
    && rm -rf /var/lib/apt/lists/*

# -------------------------
# PHP extensions
# -------------------------
RUN docker-php-ext-install zip intl pdo pdo_sqlite

# -------------------------
# Composer
# -------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -------------------------
# Project files
# -------------------------
COPY . .

# -------------------------
# Environment
# -------------------------
COPY .env.production .env

# -------------------------
# SQLite
# -------------------------
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 777 database

# -------------------------
# PHP deps
# -------------------------
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# -------------------------
# Storage
# -------------------------
RUN php artisan storage:link

# -------------------------
# Permissions
# -------------------------
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# -------------------------
# Cache
# -------------------------
RUN php artisan config:cache
RUN php artisan route:clear
RUN php artisan view:clear

# -------------------------
# Vite build
# -------------------------
RUN npm install --legacy-peer-deps
RUN npm run build

# -------------------------
# No Python pip here (not needed)
# -------------------------

# -------------------------
# Expose
# -------------------------
EXPOSE $PORT

# -------------------------
# Start
# -------------------------
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT