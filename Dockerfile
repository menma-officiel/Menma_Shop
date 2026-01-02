# Utilise PHP avec Apache
FROM php:8.2-apache

# Installe l'extension PostgreSQL pour Supabase
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copie tous les fichiers de ton projet dans le serveur
COPY . /var/www/html/

# Donne les permissions nécessaires
RUN chown -R www-data:www-data /var/www/html

# Expose le port 80
EXPOSE 80
