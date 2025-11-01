# 🌿 Ecoride Backend - Dockerfile Render (PHP + PostgreSQL)

# Étape 1 : image de base PHP 8.3 avec Composer
FROM php:8.3-cli

# Étape 2 : installer les extensions nécessaires (PostgreSQL + utilitaires)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
 && docker-php-ext-install pdo pdo_pgsql \
 && rm -rf /var/lib/apt/lists/*

# Étape 3 : installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 4 : copier le backend dans le conteneur
WORKDIR /app/backend
COPY . /app/backend

# Étape 5 : installer les dépendances PHP (en ignorant Mongo si non dispo)
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb

# Étape 6 : exposer le port Render
EXPOSE 10000

# Étape 7 : démarrer le serveur PHP intégré
CMD ["php", "-S", "0.0.0.0:10000", "router.php"]

