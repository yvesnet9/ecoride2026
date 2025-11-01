# 🐘 Dockerfile complet pour backend Ecoride (PHP + PostgreSQL + Composer)

# 1️⃣ Utiliser l’image officielle PHP 8.3 avec les extensions nécessaires
FROM php:8.3-cli

# 2️⃣ Installer les dépendances système et l’extension PostgreSQL (pdo_pgsql)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    unzip \
    git \
 && docker-php-ext-install pdo pdo_pgsql \
 && rm -rf /var/lib/apt/lists/*

# 3️⃣ Installer Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4️⃣ Définir le dossier de travail
WORKDIR /app/backend

# 5️⃣ Copier tout le backend
COPY . /app/backend

# 6️⃣ Installer les dépendances PHP sans erreur sur MongoDB
RUN composer install --no-interaction --no-progress --ignore-platform-req=ext-mongodb

# 7️⃣ Exposer le port pour Render
EXPOSE 10000

# 8️⃣ Lancer le serveur PHP intégré avec le routeur
CMD ["php", "-S", "0.0.0.0:10000", "router.php"]

