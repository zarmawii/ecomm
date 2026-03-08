FROM php:8.4-cli

WORKDIR /var/www

# Install system dependencies
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

# Install PHP extensions
RUN docker-php-ext-install zip intl pdo pdo_sqlite

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Ensure SQLite database exists
RUN mkdir -p database \
    && touch database/database.sqlite \
    && chmod -R 777 database

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --ignore-platform-reqs

# Link storage AFTER copying files
RUN php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache
RUN chmod -R 775 storage bootstrap/cache

# Install Node dependencies and build frontend assets
RUN npm install
RUN npm run build

# Clear Laravel caches
RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
RUN php artisan view:clear

# Expose port for Render
EXPOSE $PORT

# Start Laravel (migrate DB first)
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT