# 1. Utiliser l'image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# 2. Installer les dépendances système, PostgreSQL/MySQL + Node.js (pour Vite)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    gnupg \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 3. Installer les extensions PHP
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# 4. Activer le module mod_rewrite d'Apache
RUN a2enmod rewrite

# 5. Configurer le dossier public d'Apache
# Définir le dossier public de Laravel comme racine du serveur
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf



# 6. Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Copier le projet
WORKDIR /var/www/html
COPY . .

# 8. Installer les dépendances PHP et JavaScript + Compiler Vite
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# 9. Configurer les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Exposer le port 80
EXPOSE 80

# 11. Vider le cache, lancer les migrations et démarrer Apache
CMD php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear && apache2-foreground