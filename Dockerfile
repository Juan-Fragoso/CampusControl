# 1. Usamos la versión con Apache incluido (esto elimina la necesidad de Nginx en AWS)
FROM php:8.4-apache

# 2. Argumentos de usuario
ARG user=jfuser
ARG uid=1000

# 3. Dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev

# 4. Extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 5. Habilitar mod_rewrite para Laravel (Vital para que funcionen las rutas)
RUN a2enmod rewrite

# 6. Cambiar el DocumentRoot de Apache a la carpeta /public de Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf.d/*.conf

# 7. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 8. Directorio de trabajo
WORKDIR /var/www/html
COPY . /var/www/html

# 9. Instalamos dependencias y damos permisos
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 10. Exponer puerto 80
EXPOSE 80

# Apache ya trae su propio comando de inicio, no necesitas CMD artesanal
