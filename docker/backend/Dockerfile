FROM php:8.1-fpm
SHELL ["/bin/bash", "-oeux", "pipefail", "-c"]

# timezone environment
#ENV TZ=UTC \
#  # locale
#  LANG=en_US.UTF-8 \
#  LANGUAGE=en_US:en \
#  LC_ALL=en_US.UTF-8 \
#  # composer environment
#  COMPOSER_ALLOW_SUPERUSER=1 \
#  COMPOSER_HOME=/composer \
#  # Laravel environment
#  DB_CONNECTION=mysql \
#  DB_HOST=db \
#  DB_DATABASE=laravel_local \
#  DB_USERNAME=phper \
#  DB_PASSWORD=secret
ARG PUID=1000
ARG PGID=1000

RUN echo "-> $PUID"
RUN echo "-> $PGID"

RUN groupmod -o -g $PGID www-data && \
    usermod -o -u $PUID -g www-data www-data

# composer
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer && \
    composer self-update

#COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

RUN apt-get update && \
  apt-get -y install git libxrender1 libfontconfig1 fonts-ipafont libicu-dev libonig-dev libzip-dev unzip locales && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* && \
  locale-gen ja_JP.UTF-8 && \
  localedef -f UTF-8 -i ja_JP ja_JP.UTF-8 && \
  mkdir /var/run/php-fpm && \
  mkdir /var/log/php && \
  docker-php-ext-install intl pdo_mysql zip bcmath
#  composer config -g process-timeout 3600 && \
#  composer config -g repos.packagist composer https://packagist.jp

# nodeインストール
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs
RUN npm install npm@latest -g

COPY ./zzz-www.conf /usr/local/etc/php-fpm.d/zzz-www.conf
COPY ./php.ini /usr/local/etc/php/php.ini

WORKDIR /var/web/html