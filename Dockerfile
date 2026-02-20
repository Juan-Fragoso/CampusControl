FROM php:8.4-apache

# 1. Dependencias (Tu versión original + Node para los estilos)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 2. Extensiones (Tu versión exacta)
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Apache (Tu versión exacta)
RUN a2enmod rewrite
# IMPORTANTE: Usamos la sintaxis de espacio, no el igual, como la tenías antes
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Código
WORKDIR /var/www/html
COPY . /var/www/html

# 6. Instalación (PHP + JS)
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN npm install && npm run build

# 7. Permisos (Aseguramos que Apache pueda leer TODO)
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
