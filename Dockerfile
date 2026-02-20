# 1. Usamos la imagen oficial de PHP con FPM
FROM php:8.4-fpm

# 2. Argumentos para definir el usuario del sistema
ARG user=jfuser
ARG uid=1000

# 3. Instalamos dependencias del sistema y extensiones de PHP
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Limpiamos caché
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Extensiones PHP para Laravel
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# 4. Instalamos Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Creamos el usuario para no usar root
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && chown -R $user:$user /home/$user

# 6. Directorio de trabajo
WORKDIR /var/www
COPY . /var/www

# 7. Instalamos dependencias de Laravel y damos permisos
RUN composer install --no-interaction --optimize-autoloader --no-dev
RUN chown -R $user:www-data /var/www/storage /var/www/bootstrap/cache

# 8. Cambiamos al usuario creado
USER $user

EXPOSE 9000
CMD ["php-fpm"]
