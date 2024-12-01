# Image de base
FROM php:8.2-apache

# Mise à jour des packages
RUN apt-get update && apt-get install -y \
    libpq-dev libzip-dev zip unzip \
    && docker-php-ext-install pdo_mysql zip

# Activation de mod_rewrite pour Apache
RUN a2enmod rewrite

# Copier tout le projet dans le conteneur
COPY . /var/www

# Définir le répertoire de travail
WORKDIR /var/www

# Fichier de configuration PHP personnalisé
COPY ./php.ini /usr/local/etc/php/

# Installer Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/local/bin/composer

# Installer les dépendances PHP
RUN composer install --no-dev --optimize-autoloader

# Optionnel : Donner les bons droits aux fichiers
RUN chown -R www-data:www-data /var/www && chmod -R 755 /var/www

# Installer MySQL client
RUN apt-get update && apt-get install -y default-mysql-client

# Copier le script SQL dans le conteneur
COPY init.sql /var/www/init.sql

# Copier le script d'entrée
COPY entrypoint.sh /usr/local/bin/

# Rendre le script d'entrée exécutable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Définir le script d'entrée
ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]