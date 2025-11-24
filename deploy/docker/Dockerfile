###############################################
#   FASE BASE: PHP 8.2 + Apache (Bookworm)
###############################################

# Imagen oficial de PHP con Apache incluida.
# Variante basada en Debian 12 (bookworm).
FROM php:8.2-apache-bookworm AS base


################################################
#   CONFIGURACIÓN DE APACHE
################################################

# Cambiamos el DocumentRoot para que apunte a /public,
# que es la carpeta de entrada de Laravel.
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Reemplaza todas las referencias al DocumentRoot en Apache.
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf


################################################
#   FIX DE REPOS DEBIAN (NECESARIO EN BOOKWORM)
################################################

# Debian 12 usa debian.sources en vez de sources.list.
# Esto evita errores de repos 403.
RUN sed -i 's|http://deb.debian.org|https://deb.debian.org|g' /etc/apt/sources.list.d/debian.sources \
    && sed -i 's|http://security.debian.org|https://security.debian.org|g' /etc/apt/sources.list.d/debian.sources


################################################
#   INSTALACIÓN DE EXTENSIONES Y LIBRERÍAS PHP
################################################

# Instalamos librerías necesarias para Laravel, GD, PDO, ZIP, SOAP, etc.
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype-dev \
    libonig-dev \
    libzip-dev \
    libpq-dev \
    libsqlite3-dev \
    libcurl4-openssl-dev \
    libxml2-dev \
    unzip \
    autoconf \
    pkg-config \
    \
    # Configuración de GD para imágenes
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    \
    # Instalación de extensiones PHP necesarias
    && docker-php-ext-install -j$(nproc) \
        gd \
        mbstring \
        mysqli \
        pdo_mysql \
        pdo_sqlite \
        pgsql \
        soap \
        zip \
        bcmath \
    \
    # Limpieza para reducir el peso
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*


################################################
#   EXTENSIONES OPCIONALES (DESACTIVADAS)
################################################

# ======= MongoDB (Opcional) =======
# Para activarlo solo quita el "#" de estas líneas
#
# RUN pecl install mongodb-1.20.0 \
#     && docker-php-ext-enable mongodb
#
# ==================================


################################################
#   HABILITAR MÓDULOS DE APACHE
################################################

RUN a2enmod rewrite   # Necesario para rutas de Laravel


################################################
#   CONFIGURACIÓN PERSONALIZADA DE PHP
################################################

RUN echo "upload_max_filesize = 120M" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size = 150M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "memory_limit = 512M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "error_reporting = E_ALL & ~E_WARNING & ~E_DEPRECATED" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "display_errors = Off" >> /usr/local/etc/php/conf.d/custom.ini


################################################
#   CAMBIAR PUERTO DE APACHE A 8080
################################################

RUN sed -i 's/Listen 80/Listen 8080/g' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:8080>/g' /etc/apache2/sites-available/000-default.conf


################################################
#   COPIAR CÓDIGO LARAVEL + COMPOSER INSTALL
################################################

WORKDIR /var/www/html

# Copiar código del proyecto al contenedor
COPY . .

# Copiar binario de Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instalar dependencias optimizadas para producción
RUN composer install --no-dev --optimize-autoloader --no-interaction --prefer-dist



###############################################
#   FASE DE BUILD DEL FRONTEND
###############################################

FROM node:20 AS build

WORKDIR /app

# Copiar archivos necesarios de NPM
COPY package.json package-lock.json ./

# Instalar dependencias de Vite + Tailwind
RUN npm install

# Copiar carpeta de recursos del frontend
COPY resources resources
COPY vite.config.js vite.config.js
COPY tailwind.config.js tailwind.config.js
COPY postcss.config.js postcss.config.js

# Compilar assets
RUN npm run build



###############################################
#   FASE FINAL (PRODUCCIÓN)
###############################################

FROM base AS final

# Copiar frontend compilado hacia Laravel/public
COPY --from=build /app/public /var/www/html/public
COPY --from=build /app/public/build /var/www/html/public/build

# Permisos correctos para Laravel
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Exponer puerto de Apache
EXPOSE 8080

# Seguridad: Ejecutar como usuario www-data
USER www-data
