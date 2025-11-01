# ============================================================
# 🚀 Dockerfile pour backend PHP (Render)
# ============================================================

# Étape 1 : Image de base PHP
FROM php:8.3-cli

# Étape 2 : Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Étape 3 : Installer Composer (pour les dépendances PHP)
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Étape 4 : Copier le code du backend
WORKDIR /app/backend
COPY . /app/backend

# Étape 5 : Installer les dépendances PHP (sans l’extension Mongo)
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb

# Étape 6 : Exposer le port 10000 (Render l’utilise par défaut)
EXPOSE 10000

# Étape 7 : Commande de démarrage
CMD ["php", "-S", "0.0.0.0:10000", "router.php"]

