# 1. Usamos la imagen oficial de PHP con Apache
FROM php:8.4-apache

# 2. Dependencias del sistema (Agregamos Node.js aquí)
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip libzip-dev \
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 3. Extensiones PHP
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 4. Habilitar mod_rewrite para Laravel
RUN a2enmod rewrite

# 5. Configurar Apache para apuntar a /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 6. Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 7. Directorio de trabajo
WORKDIR /var/www/html
COPY . /var/www/html

# 8. Instalamos dependencias PHP, JS y damos permisos
RUN composer install --no-interaction --optimize-autoloader --no-dev
# --- ESTA ES LA PARTE QUE FALTABA PARA LOS ESTILOS ---
RUN npm install && npm run build
# ----------------------------------------------------
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 9. Exponer puerto 80
EXPOSE 80
