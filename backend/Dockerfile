# ✅ Dockerfile fonctionnel pour backend PHP + PostgreSQL sur Render

FROM php:8.3-cli

# --- Installer PostgreSQL driver (pdo_pgsql) et outils ---
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
 && docker-php-ext-install pdo pdo_pgsql \
 && php -m | grep pdo_pgsql \
 && rm -rf /var/lib/apt/lists/*

# --- Installer Composer depuis l'image officielle ---
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --- Copier le code du backend ---
WORKDIR /app/backend
COPY . /app/backend

# --- Installer les dépendances PHP ---
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb

# --- Exposer le port utilisé par Render ---
EXPOSE 10000

# --- Lancer le serveur PHP intégré ---
CMD ["php", "-S", "0.0.0.0:10000", "router.php"]

