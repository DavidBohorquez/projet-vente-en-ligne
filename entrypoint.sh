#!/bin/sh

# Attendre que le service MySQL soit prêt
while ! mysqladmin ping -h"db" -u"$DB_USER" -p"$DB_PASSWORD" --silent; do
    echo "Waiting for MySQL to be ready..."
    sleep 1
done

# Exécuter le script SQL
mysql -h db -u $DB_USER -p$DB_PASSWORD $DB_NAME < /var/www/init.sql

# Exécuter la commande par défaut
exec "$@"