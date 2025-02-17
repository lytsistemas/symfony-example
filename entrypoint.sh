#!/bin/sh

# Compilar los assets antes de iniciar
php bin/console asset-map:compile

# Ejecutar la supervisión de assets en segundo plano
php bin/console asset-map:watch &

# Iniciar el servidor Symfony
symfony server:start --no-tls --allow-http --port=8000 --allow-all-ip

