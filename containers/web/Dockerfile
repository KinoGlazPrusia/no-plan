# Partimos de la imagen oficial de PHP 8.3 + Apache2
FROM php:8.3-apache

# Actualizamos el sistema e instalamos las dependencias necesarias
# Incluimos libzip-dev para la extensi      n zip de PHP y unzip
RUN apt-get update && apt-get install -y \
    nano \
    curl \
    gnupg \
    git \
    libzip-dev \
    unzip \
    && rm -rf /var/lib/apt/lists/*

# Instalamos los m      dulos de PHP necesarios, incluyendo zip
RUN docker-php-ext-install pdo pdo_mysql zip

# Descargamos e instalamos Node.js
RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash - \
    && apt-get install -y nodejs \
    && rm -rf /var/lib/apt/lists/*

# Descargamos, instalamos y actualizamos composer
RUN curl -sS https://getcomposer.org/installer -o composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && composer self-update \
    && rm composer-setup.php

# Activamos el módulo de reescritura en apache
RUN a2enmod rewrite

# Reiniciamos el servicio Apache (no se si es realmente necesario ya que al iniciar la máquina empieza de cero)
RUN service apache2 restart

# Configuramos el directorio de trabajo
WORKDIR /var/www/html

# Clonamos el repositorio de GitHub
RUN git clone http://github.com/KinoGlazPrusia/no-plan.git

# Instalamos las dependencias de npm
WORKDIR /var/www/html/no-plan/frontend
RUN npm install && npm cache clean --force

# Instalamos las dependencias de Composer
WORKDIR /var/www/html/no-plan/app
RUN composer install --no-dev --optimize-autoloader

# Damos permisos completos al servidor para la carpeta pública
RUN chown -R www-data:www-data /var/www/html/no-plan/app/public/assets/images
RUN chmod -R 755 /var/www/html/no-plan/app/public/assets/images

# Volvemos al directorio de trabajo principal
WORKDIR /var/www/html

# Limpiamos archivos innecesarios
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*