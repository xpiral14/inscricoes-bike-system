FROM unit:1.34.1-php8.4

# Instala dependências e Node.js 18 com npm
# Instala dependências e Node.js 18 com npm
RUN apt update && apt install -y \
    curl unzip git libicu-dev libzip-dev libpng-dev libjpeg-dev libfreetype6-dev libssl-dev \
    libpq-dev libmariadb-dev ca-certificates gnupg \ # <-- Problematic comment position [cite: 1]
    && curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt install -y nodejs \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) pcntl opcache pdo pdo_pgsql pdo_mysql intl zip gd exif ftp bcmath \ # <-- Problematic comment position [cite: 2]
    && pecl install redis \
    && docker-php-ext-enable redis \

# Configurações do PHP
RUN echo "opcache.enable=1" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.jit=tracing" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "opcache.jit_buffer_size=256M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "memory_limit=512M" > /usr/local/etc/php/conf.d/custom.ini \
    && echo "upload_max_filesize=64M" >> /usr/local/etc/php/conf.d/custom.ini \
    && echo "post_max_size=64M" >> /usr/local/etc/php/conf.d/custom.ini

# Instala o Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Define o diretório da aplicação
WORKDIR /var/www/html

# Cria diretórios de cache do Laravel
RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache

# Permissões para o usuário unit
RUN chown -R unit:unit /var/www/html/storage bootstrap/cache && chmod -R 775 /var/www/html/storage

# Copia os arquivos da aplicação
COPY . .

# Ajusta permissões novamente (caso sobrescreva com COPY)
RUN chown -R unit:unit storage bootstrap/cache && chmod -R 775 storage bootstrap/cache

# Instala dependências do Laravel
RUN composer install --prefer-dist --optimize-autoloader --no-interaction

RUN php artisan migrate --force --no-interaction
RUN php artisan db:seed PermissionSeeder --force --no-interaction

RUN php artisan optimize:clear

RUN php artisan config:clear

RUN php artisan route:clear

RUN php artisan view:clear

RUN php artisan optimize

RUN php artisan filament:optimize

RUN npm install

RUN npm run build

# Copia configuração do NGINX Unit
COPY unit.json /docker-entrypoint.d/unit.json

# Expõe a porta padrão do Unit
EXPOSE 8000

# Inicializa o serviço
CMD ["unitd", "--no-daemon"]
