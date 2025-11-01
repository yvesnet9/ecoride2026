# ===============================================
# 🌱 Dockerfile stable pour backend Ecoride 2026
# ===============================================

FROM php:8.3-cli

# Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Créer le dossier d'application
WORKDIR /app

# Copier TOUT le projet
COPY . /app

# Aller dans le dossier backend
WORKDIR /app/backend

# Installer les dépendances PHP
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb || true

# Exposer le port pour Render
EXPOSE 10000

# Lancer le serveur PHP intégré avec router.php
CMD ["php", "-S", "0.0.0.0:10000", "-t", ".", "router.php"]

