FROM php:8.4-apache

# 1. Dependencias (PHP + Node para estilos)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 2. Extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Apache (Tu configuración original que sí funcionaba)
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Código y Construcción
WORKDIR /var/www/html
COPY . /var/www/html

# Instalamos todo aquí para que la imagen ya vaya "lista"
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

# 6. Permisos (Crucial para evitar el Not Found)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
