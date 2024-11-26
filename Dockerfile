# Image de base
FROM php:8.2-apache

# Mise à jour des packages
RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo_mysql zip

# Activation de mod_rewrite pour Apache
RUN a2enmod rewrite

# Copie des fichiers PHP dans le conteneur
COPY ./public /var/www/html

# Fichier de configuration PHP personnalisé
COPY ./php.ini /usr/local/etc/php/
