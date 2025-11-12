FROM php:8.2-cli

# Instalar dependencias del sistema y extensiones PHP necesarias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libicu-dev \
    && docker-php-ext-configure intl \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd intl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establecer directorio de trabajo
WORKDIR /var/www/html

# Copiar archivos de configuración primero (para cache de Docker)
COPY composer.json composer.lock* ./

# Instalar dependencias de Composer (sin scripts para evitar errores durante build)
RUN composer install --ignore-platform-reqs --no-scripts

# Copiar el resto de los archivos
COPY . .

# Establecer permisos para el directorio writable
RUN chmod -R 777 /var/www/html/writable || true

# Comando por defecto (puede ser sobrescrito por docker-compose)
CMD ["php", "contact-importer.php"]

