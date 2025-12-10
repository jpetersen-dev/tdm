FROM php:8.2-apache

# 1. Instalar utilidades y extensiones PHP
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip

# 2. Habilitar reescritura de Apache
RUN a2enmod rewrite

# 3. Configurar Apache para que la carpeta pública sea 'public'
# Esto protege tu código fuente y .env
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

# 4. Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Copiar código
WORKDIR /var/www/html
COPY . .

# 6. Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# 7. Permisos
RUN chown -R www-data:www-data /var/www/html