# =========================================================
# 🚀 Dockerfile debug pour backend Ecoride sur Render
# =========================================================

FROM php:8.3-cli

# Installer extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier backend dans /app/backend
WORKDIR /app/backend
COPY backend/ /app/backend/

# Installer dépendances PHP
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb || true

# Ajouter le script de démarrage avec logs visibles
COPY backend/start.sh /app/backend/start.sh
RUN chmod +x /app/backend/start.sh

# Exposer le port 10000
EXPOSE 10000

# Lancer le serveur via notre script de debug
CMD ["/app/backend/start.sh"]

