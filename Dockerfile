# 1. Utiliser l'image officielle PHP 8.2 avec Apache
FROM php:8.2-apache

# 2. Installer les dépendances système nécessaires à Laravel (zip, pdo, libpq pour PostgreSQL, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    zip \
    unzip \
    git \
    curl

# 3. Installer les extensions PHP indispensables pour Laravel et les bases de données (MySQL et PostgreSQL)
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd

# 4. Activer le module mod_rewrite d'Apache (obligatoire pour le routage de Laravel)
RUN a2enmod rewrite

# 5. Définir le dossier racine d'Apache sur le dossier public/ de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 'before/s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 'before/s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/conf-available/*.conf

# 6. Installer Composer dans le conteneur
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Copier le code source de votre projet dans le dossier du serveur
WORKDIR /var/www/html
COPY . .

# 8. Installer les dépendances de Laravel avec Composer
RUN composer install --no-dev --optimize-autoloader

# 9. Configurer les permissions sur les dossiers de stockage et de cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Indiquer le port d'écoute d'Apache
EXPOSE 80

# 11. Commande de démarrage d'Apache
CMD ["apache2-foreground"]