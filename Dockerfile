# ===============================================
# 🚀 Dockerfile pour Render - Ecoride Backend PHP
# ===============================================

FROM php:8.3-cli

# Installer PostgreSQL et MongoDB extensions
RUN apt-get update && apt-get install -y \
    libpq-dev libssl-dev pkg-config \
    && docker-php-ext-install pdo pdo_pgsql \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb

# Copier Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dossier de travail
WORKDIR /app

# Copier tout le projet
COPY . .

# Installer les dépendances PHP du backend
WORKDIR /app/backend
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb

# Exposer le port Render
EXPOSE 10000

# Démarrer le serveur PHP intégré
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/app/backend"]

