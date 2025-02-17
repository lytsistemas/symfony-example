# Usa PHP 8.2 con Apache
FROM php:8.2-apache

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git unzip curl libpq-dev libsqlite3-dev libicu-dev libonig-dev \
    && docker-php-ext-install pdo pdo_sqlite intl

# Instala Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Configura Apache para que use mod_rewrite (necesario para Symfony)
RUN a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos del proyecto
COPY . .

# Instala las dependencias de Symfony
RUN composer install --no-scripts --no-progress --no-interaction

# Permisos correctos en TODAS las carpetas necesarias
RUN mkdir -p var/cache var/log var/data var/sessions public/assets && \
    chown -R www-data:www-data var/ public/assets && \
    chmod -R 777 var/ public/assets

# Copia el entrypoint para manejar múltiples procesos
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expone el puerto 8000
EXPOSE 8000

# Usa un script de inicio en lugar de CMD directo
CMD ["/entrypoint.sh"]
