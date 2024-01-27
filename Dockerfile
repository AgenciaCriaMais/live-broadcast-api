FROM php:8.2-fpm

# Atualiza a lista de pacotes e instala as dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libwebp-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl \
    libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd pdo pdo_mysql mysqli mbstring exif pcntl bcmath xml

# Configura o diretório de trabalho
WORKDIR /var/www

# Copia o aplicativo Laravel para o diretório de trabalho
COPY . /var/www

# Instala as dependências do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install

# Ajusta as permissões dos arquivos
RUN chown -R www-data:www-data /var/www

# Copia o script de entrada para o contêiner e o torna executável
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expõe a porta 9000
EXPOSE 9000

# Configura o script de entrada como o ponto de entrada do contêiner
ENTRYPOINT ["/entrypoint.sh"]
