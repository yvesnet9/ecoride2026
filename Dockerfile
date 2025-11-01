# ===============================
# 🌱 Dockerfile pour backend Ecoride 2026 (PHP 8.3 + Composer + Render)
# ===============================

# Étape 1 : base PHP officielle
FROM php:8.3-cli

# Étape 2 : installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Étape 3 : installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 4 : copier le backend dans /app/backend
WORKDIR /app/backend
COPY backend/ /app/backend/

# Étape 5 : installer les dépendances PHP (sans l’extension mongodb)
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb

# Étape 6 : copier le router PHP pour le serveur intégré
COPY backend/router.php /app/backend/router.php
COPY backend/index.php /app/backend/index.php

# Étape 7 : exposer le port utilisé par Render
EXPOSE 10000

# Étape 8 : lancer le serveur PHP intégré AVEC router.php
CMD ["php", "-S", "0.0.0.0:10000", "-t", ".", "router.php"]

