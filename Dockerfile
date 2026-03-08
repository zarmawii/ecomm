# =========================
# Dockerfile for Laravel + Vite (Render Ready)
# =========================
FROM php:8.4-cli

WORKDIR /var/www

# -------------------------
# Install system dependencies
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
    && rm -rf /var/lib/apt/lists/*

# -------------------------
# Install PHP extensions
# -------------------------
RUN docker-php-ext-install zip intl pdo pdo_sqlite

# -------------------------
# Install Composer
# -------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# -------------------------
# Copy project files
# -------------------------
COPY . .

# -------------------------
# Copy production environment
# -------------------------
COPY .env.production .env

# -------------------------
# Ensure SQLite database exists
# -------------------------
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 777 database

# -------------------------
# Install PHP dependencies
# -------------------------
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# -------------------------
# Link storage
# -------------------------
RUN php artisan storage:link

# -------------------------
# Permissions
# -------------------------
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# -------------------------
# Clear Laravel caches
# -------------------------
RUN php artisan config:cache
RUN php artisan route:clear
RUN php artisan view:clear

# -------------------------
# Install Node dependencies and build assets
# -------------------------
RUN npm install --legacy-peer-deps
RUN npm run build

# -------------------------
# Expose Render port
# -------------------------
EXPOSE $PORT

# -------------------------
# Start Laravel
# -------------------------
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT