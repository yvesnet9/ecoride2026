# ===============================================
# 🚀 Dockerfile pour Render - Ecoride Backend PHP
# ===============================================

# 1️⃣ Image officielle PHP avec Composer
FROM php:8.3-cli

# 2️⃣ Installer les dépendances nécessaires à PostgreSQL et MongoDB
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libssl-dev \
    pkg-config \
    && docker-php-ext-install pdo pdo_pgsql

# 3️⃣ Installer l’extension MongoDB
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# 4️⃣ Installer Composer depuis l’image officielle
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5️⃣ Définir le répertoire de travail
WORKDIR /app

# 6️⃣ Copier tout le projet dans le conteneur
COPY . .

# 7️⃣ Installer les dépendances PHP du backend uniquement
WORKDIR /app/backend
RUN composer install --no-interaction --no-progress

# 8️⃣ Exposer le port 10000 pour Render
EXPOSE 10000

# 9️⃣ Démarrer le serveur PHP intégré depuis le dossier backend
CMD ["php", "-S", "0.0.0.0:10000", "-t", "/app/backend"]

