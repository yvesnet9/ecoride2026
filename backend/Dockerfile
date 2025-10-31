# Utilise PHP 8.3 avec Composer intégré
FROM php:8.3-apache

# Active les extensions nécessaires (pdo_pgsql, etc.)
RUN docker-php-ext-install pdo pdo_pgsql

# Installe Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copie ton backend dans le conteneur
WORKDIR /var/www/html
COPY . .

# Expose le port Render
EXPOSE 10000

# Commande de démarrage
CMD ["php", "-S", "0.0.0.0:10000", "-t", "."]
