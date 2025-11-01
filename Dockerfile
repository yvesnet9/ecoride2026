# =========================================================
# 🌱 Dockerfile FINAL pour backend Ecoride (PHP 8.3 Render)
# =========================================================

FROM php:8.3-cli

# Installer extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev unzip git \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copier uniquement le backend dans /var/www/html
WORKDIR /var/www/html
COPY backend/ /var/www/html/

# Installer dépendances PHP
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb || true

# Exposer le port 10000 utilisé par Render
EXPOSE 10000

# Lancer le serveur PHP intégré dans le bon dossier
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/var/www/html", "router.php"]

