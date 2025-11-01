# ============================================================
# 🚀 Dockerfile PHP 8.3 pour Render (avec PostgreSQL)
# ============================================================

FROM php:8.3-cli

# 1️⃣ Installer les extensions nécessaires
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
    && docker-php-ext-configure pdo_pgsql --with-pdo-pgsql \
    && docker-php-ext-install pdo pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

# 2️⃣ Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 3️⃣ Copier le backend dans le conteneur
WORKDIR /app/backend
COPY . /app/backend

# 4️⃣ Installer les dépendances PHP (en ignorant ext-mongodb)
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb

# 5️⃣ Exposer le port utilisé par Render
EXPOSE 10000

# 6️⃣ Démarrer le serveur PHP interne avec le router
CMD ["php", "-S", "0.0.0.0:10000", "router.php"]
