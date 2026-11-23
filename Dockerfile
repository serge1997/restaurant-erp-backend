FROM php:8.4-fpm AS builder
WORKDIR /var/www
COPY composer.json composer.lock ./
COPY  . .

RUN apt-get update && apt-get install -y \
    zip \
    unzip 

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction
RUN composer dump-autoload --optimize

FROM php:8.4-fpm AS runtime
ARG UID=501
ARG GID=20
WORKDIR /app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libicu-dev \
    libpq-dev \
    libjpeg-dev \
    libfreetype6-dev \
    chromium \
    chromium-driver \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        intl \
        zip


RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g puppeteer \
    && npx puppeteer browsers install chrome

RUN groupadd -r www && useradd -u ${UID} -G www,${GID} sergegogo

COPY --from=builder --chown=sergegogo:sergegogo /var/www/vendor ./vendor
COPY --from=builder --chown=sergegogo:sergegogo /var/www/app ./app
COPY --from=builder --chown=sergegogo:sergegogo /var/www/bootstrap ./bootstrap
COPY --from=builder --chown=sergegogo:sergegogo /var/www/config ./config
COPY --from=builder --chown=sergegogo:sergegogo /var/www/database ./database
COPY --from=builder --chown=sergegogo:sergegogo /var/www/public ./public
COPY --from=builder --chown=sergegogo:sergegogo /var/www/resources ./resources
COPY --from=builder --chown=sergegogo:sergegogo /var/www/routes ./routes
COPY --from=builder --chown=sergegogo:sergegogo /var/www/storage ./storage
COPY --from=builder --chown=sergegogo:sergegogo /var/www/composer.json .
COPY --from=builder --chown=sergegogo:sergegogo /var/www/composer.lock .
COPY --from=builder --chown=sergegogo:sergegogo /var/www/artisan .
COPY --from=builder --chown=sergegogo:sergegogo /var/www/package.json .

RUN chown -R sergegogo:www ./bootstrap/cache ./storage \
    && chmod 775 -R ./bootstrap/cache ./storage
USER sergegogo

CMD ["php-fpm"]